<?php

namespace App\ManagerBundle\Entities\Handler\Employee\Report;

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

	protected function _execute()
	{
		$repository = $this->em->getRepository('AppManagerBundle:Model\Employee\Report');
		$repository->delete($this->id);
	}
}
 