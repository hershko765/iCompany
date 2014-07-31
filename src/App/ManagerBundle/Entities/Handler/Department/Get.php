<?php

namespace App\ManagerBundle\Entities\Handler\Department;

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
		$Department = $this->em->getRepository('AppManagerBundle:Model\Department')->find($this->id);

		if ( ! $Department)
			throw new NotFoundHttpException('Department #'.$this->id.' Not Found');

		return $Department;
	}
}
 