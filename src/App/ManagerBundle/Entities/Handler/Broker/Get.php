<?php

namespace App\ManagerBundle\Entities\Handler\Broker;

use App\SourceBundle\Base\HandlerManager;
use App\SourceBundle\Interfaces\Handler;
use Doctrine\Bundle\DoctrineBundle\Registry;
use App\SourceBundle\Base\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Get extends HandlerManager implements Handler {

	/**
	 * @var Registry
	 * @DI (alias=doctrine)
	 */
	protected $em;

	/**
	 * Outsource data
	 * @var array
	 */
	protected $options = [];
	protected $id;

	public function setID($id, array $options = [])
	{
		$this->options = $options;
		$this->id = $id;

		return $this;
	}

	public function execute()
	{
		$Broker = $this->em->getRepository('AppManagerBundle:Model\Broker')->find($this->id);

		if ( ! $Broker)
			throw new NotFoundHttpException('Broker Not Found!');

		return $Broker;
	}
}
 