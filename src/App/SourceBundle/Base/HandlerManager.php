<?php

namespace App\SourceBundle\Base;

use App\SourceBundle\Exception\ValidationException;
use App\SourceBundle\Helpers\Arr;
use App\SourceBundle\Interfaces\Handler;
use Symfony\Component\HttpFoundation\Request;


abstract class HandlerManager implements Handler {

    // Permission Codes
    const PERM_ALL    = 1;
    const PERM_MEMBER = 2;
    const PERM_ADMIN  = 4;

    // Default permission required to load the handler
    const REQUIRED_PERMISSION = self::PERM_ALL;

	/**
	 * @var HandlerGateway
	 * @DI(alias=handler_gateway)
	 */
	protected $handlerGateway;

    /**
     * Used to force an handler not
     * to apply permissions
     *
     * @var bool
     */
    protected $forceHandler = FALSE;

    /**
     * @var Request
     * @DI(alias=request)
     */
    protected $request;

    /**
     * Single use credentials
     * @var array
     */
    protected $credentials;

    /**
     * Contain currenct permission code
     * @var integer
     */
    protected $permission_code;

	/**
	 * Inject dependencies into class properties
	 */
	public function __construct()
	{
		$args = func_get_args();
		$DIarray = Arr::get($args, count(func_get_args()) - 1);
		foreach ($DIarray as $key => $DIClass)
		{
			$this->{$DIClass} = Arr::get($args, $key);
		}
		if(method_exists($this, 'initialize')) $this->initialize();
	}

	/**
	 * Get handler gateway instance
	 * @return HandlerGateway
	 */
	protected function getHandlerGateway()
	{
		return $this->handlerGateway;
	}

    /**
     * Force the handler to execute
     * without permissions
     */
    public function forceHandler()
    {
        $this->forceHandler = TRUE;
    }

	/**
	 * Shortcut for loading handler
	 *
	 * @param      $entity
	 * @param      $handler
	 * @param bool $bundle
	 * @return HandlerManager
	 */
	protected function getHandler($entity, $handler, $bundle = FALSE)
	{
		return $this->handlerGateway->getHandler($entity, $handler, $bundle);
	}
	/**
	 * Convert Validator object to array
	 * @param $errors
	 * @return array
	 */
	protected function errorsToArr($errors)
	{
		$errorArr = [];
		foreach ($errors as $error)
		{
			$errorArr[$error->getPropertyPath()] = $error->getMessage();
		}

		return $errorArr;
	}

	public function setFilters(array $filters)
	{
		$this->filters = $filters;
		return $this;
	}

	public function setSettings(array $settings)
	{
		$this->settings = $settings;
		return $this;
	}

	public function setCredentials(array $credentials)
	{
		$this->credentials = $credentials;
		return $this;
	}

	public function setPaging(array $paging)
	{
		$this->paging = $paging;
		return $this;
	}

    /**
     * Locate request permission
     */
    private function trackPermission()
    {
        if ($this->request->cookies->get('user'))
        {
            $this->permission_code = HandlerManager::PERM_MEMBER;
        }
        else
        {
            if ($this->credentials && static::REQUIRED_PERMISSION > self::PERM_ALL)
            {
                $result = $this->getHandler('Auth', 'Login', 'User')
                    ->setCredentials($this->credentials)
                    ->execute();


                if ($result)
                    $this->permission_code = HandlerManager::PERM_MEMBER;
                else
                    $this->permission_code = HandlerManager::PERM_ALL;

                return;
            }

            $this->permission_code = HandlerManager::PERM_ALL;
        }
    }

    /**
     * @return mixed
     */
    abstract protected function _execute();

    /**
     * Secure execute method
     *
     * @return array
     * @throws \App\SourceBundle\Exception\ValidationException
     */
    public function execute()
    {
        // Update permissions
        if ( ! $this->forceHandler) $this->trackPermission();

        // Check permissions
        if ($this->permission_code < static::REQUIRED_PERMISSION && ! $this->forceHandler)
            throw new ValidationException('Invalid Permissions');

        // Continue with the flow
        return $this->_execute();
    }
}