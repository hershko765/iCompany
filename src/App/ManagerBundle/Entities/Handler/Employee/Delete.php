<?php

namespace App\ManagerBundle\Entities\Handler\Employee;

use App\SourceBundle\Base\HandlerManager;
use App\SourceBundle\Interfaces\Handler;
use Doctrine\Bundle\DoctrineBundle\Registry;

class Delete extends HandlerManager implements Handler {

	/**
	 * @var Registry
	 * @DI (alias=doctrine)
	 */
	protected $em;

	/**
	 * Outsource data
	 * @var array
	 */
	protected $id;

	public function setID($id)
	{
		$this->id = $id;

		return $this;
	}

	public function execute()
	{
		$repository = $this->em->getRepository('AppManagerBundle:Model\Employee');
		$repository->delete($this->id);
	}
}
 