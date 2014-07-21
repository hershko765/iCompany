<?php

namespace App\SourceBundle\Base;

use Doctrine\DBAL\ConnectionException;
use Symfony\Bundle\FrameworkBundle;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\SourceBundle\Helpers\Arr;
use App\SourceBundle\Base\HandlerManager;

class HandlerGateway {

    private $permission_code;

	/**
	 * @var \Symfony\Component\DependencyInjection\ContainerBuilder
	 */
	private $handler_container;
	private $container;

	public function __construct($container)
	{
		$this->container = $container;
		$this->handler_container =  new ContainerBuilder();
	}

	/**
	 * Get handler class
	 *
	 * @param $bundle
	 * @param $entity
	 * @param $handler
	 * @throws Exception
	 * @return HandlerManager object
	 */
	public function getHandler($entity, $handler, $bundle = FALSE)
	{
        // Get request permission
        $this->trackPermission();

		// Creating class alias for handler container
		$handler_alias = strtolower($bundle).'_'.strtolower($entity).'_'.strtolower($handler);

		// Get handler class name
		$handler_class = 'App\\'.ucwords($bundle).'Bundle\Entities\Handler\\'.ucwords($entity).'\\'.ucwords($handler);
		$handler_class = str_replace(':', '\\', $handler_class);
		$handler_alias = str_replace(':', '_', $handler_alias);

		if(class_exists($handler_class))
		{
			// Checking if the handler container already have that handler, if not creating one
			if ( ! $this->handler_container->has($handler_alias))
			{
				$this->registerHandlerDependency($handler_class, $handler_alias);
			}

            /**
             * @var $handler HandlerManager
             */
            $handler = $this->handler_container->get($handler_alias);
            
            // Check if the right permission given
            if ($this->permission_code < $handler::REQUIRED_PERMISSION)
                throw new ConnectionException('Permission Denied');

            return $handler;
        }
        echo $handler_class;
		throw new Exception('Handler class not found!');
	}

	/**
	 * Register handler and inject dependencies
	 *
	 * @param $handler
	 * @param $alias
	 * @throws \Symfony\Component\Config\Definition\Exception\Exception
	 */
	private function registerHandlerDependency($handler, $alias)
	{
		// Register handler
		$handlerReg = $this->handler_container->register($alias, $handler);

		// Getting construct method to inject dependencies
		$ref = new \ReflectionClass($handler);
		$argKeys = [];

		// Inject dependencies
		foreach($ref->getProperties() as $prop)
		{
            // Get DI of the handler
			$docs = $prop->getDocComment();
			preg_match('/@DI([ ]{0,})\((?<props>.*)\)/', $docs, $match);

			if ( ! Arr::get($match, 'props')) continue;
			$docs = Arr::formatArray(Arr::get($match, 'props'), '=');
			$alias = Arr::get($docs, 'alias', $prop->getName());

			// Checking if the container has the dependency
			if ( ! $this->container->has($alias))
				throw new Exception('Service '.$alias.' is not registered within service manager!');

			// Add argument to the handler registration
			$argKeys[] = $prop->getName();
			$handlerReg->addArgument($this->container->get($alias));
		}

		$handlerReg->addArgument($argKeys);
	}

    /**
     * Locate request permission
     */
    private function trackPermission()
    {
        $request = $this->container->get('request');

        if ($request->cookies->get('user'))
            $this->permission_code = HandlerManager::PERM_MEMBER;
        else
            $this->permission_code = HandlerManager::PERM_ALL;
    }

} // End HandlerGateway