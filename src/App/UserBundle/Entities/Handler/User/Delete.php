<?php

namespace App\UserBundle\Entities\Handler\User;

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

	public function setData($id)
	{
		$this->id = $id;

		return $this;
	}

	public function execute()
	{
		$repository = $this->em->getRepository('AppUserBundle:Model\User');
		$repository->delete($this->id);
	}
}
 