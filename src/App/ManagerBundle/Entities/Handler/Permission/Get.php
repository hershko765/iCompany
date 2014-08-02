<?php

namespace App\ManagerBundle\Entities\Handler\Permission;

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

	protected function _execute()
	{
		$Permission = $this->em->getRepository('AppManagerBundle:Model\Permission')->find($this->id);

		if ( ! $Permission)
			throw new NotFoundHttpException('Permission #'.$this->id.' Not Found');

		return $Permission;
	}
}
 