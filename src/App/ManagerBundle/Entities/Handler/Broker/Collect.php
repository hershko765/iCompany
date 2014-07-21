<?php

namespace App\ManagerBundle\Entities\Handler\Broker;

use App\SourceBundle\Base\HandlerManager;
use App\SourceBundle\Interfaces\Handler;
use Doctrine\Bundle\DoctrineBundle\Registry;

class Collect extends HandlerManager {

	/**
	 * @var Registry
	 * @DI (alias=doctrine)
	 */
	protected $em;

	/**
	 * Outsource data
	 * @var array
	 */
	protected $filters  = [];
	protected $paging   = [];
	protected $settings = [];

	public function setOptions(array $filters = [], array $paging = [], array $settings = [])
	{
		$this->filters  = $filters;
		$this->paging   = $paging;
		$this->settings = $settings;

		return $this;
	}

	public function execute()
	{
		return $this->em->getRepository('AppManagerBundle:Model\Broker')
			->collect($this->filters, $this->paging, $this->settings);
	}
}
 