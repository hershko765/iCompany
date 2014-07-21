<?php

namespace App\UserBundle\Entities\Handler\User;

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

	public function setData($id, array $options = [])
	{
		$this->options = $options;
		$this->id = $id;

		return $this;
	}

	public function execute()
	{
		$user = $this->em->getRepository('AppUserBundle:Model\User')->find($this->id);

		if ( ! $user)
			throw new NotFoundHttpException('User Not Found!');

		return $user;
	}
}
 