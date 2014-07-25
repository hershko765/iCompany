<?php

namespace App\ManagerBundle\Entities\Handler\Employee;

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
		$Employee = $this->em->getRepository('AppManagerBundle:Model\Employee')->find($this->id);

		if ( ! $Employee)
			throw new NotFoundHttpException('Employee #'.$this->id.' Not Found');

		return $Employee;
	}
}
 