<?php

namespace App\SourceBundle\Base;

use App\SourceBundle\Helpers\Arr;
use App\SourceBundle\Interfaces\Handler;


abstract class HandlerManager implements Handler {

    // Permission Codes
    const PERM_ALL    = 1;
    const PERM_MEMBER = 2;
    const PERM_ADMIN  = 4;

    // Default permission required to load the handler
    const REQUIRED_PERMISSION = 2;

	/**
	 * @var HandlerGateway
	 * @DI(alias=handler_gateway)
	 */
	protected $handlerGateway;

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

	public function setPaging(array $paging)
	{
		$this->paging = $paging;
		return $this;
	}

	abstract function execute();
}