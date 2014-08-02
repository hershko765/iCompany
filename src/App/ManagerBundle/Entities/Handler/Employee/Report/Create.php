<?php

namespace App\ManagerBundle\Entities\Handler\Employee\Report;

use App\ManagerBundle\Entities\Model\Employee\Report;
use App\SourceBundle\Base\Repository\Repository;
use App\SourceBundle\Base\HandlerManager;
use App\SourceBundle\Exception\ValidationException;
use App\SourceBundle\Interfaces\Handler;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Validator\Validator;

class Create extends HandlerManager implements Handler {

 	/**
	 * @var Registry
	 * @DI (alias=doctrine)
	 */
	protected $em;

	/**
	 * @var Validator
	 * @DI (alias=validator)
	 */
	protected $validate;

	/**
	 * Outsource data
	 * @var array
	 */
	protected $data;

	public function setData(array $data, $id = NULL)
	{
		$this->data = $data;
		return $this;
	}

	protected function _execute()
	{
		$employeeReport = new Report();

		// Get repository and filter data to contain only allowed data
		$repo = $this->em->getRepository('AppManagerBundle:Model\Employee\Report');
		$repo->hydrate($this->data, $employeeReport, Repository::PERM_CREATE);

		// Validate model, check for errors and return them if exists
		$errors = $this->validate->validate($employeeReport);

		if(count($errors) > 0)
            throw new ValidationException($this->errorsToArr($errors), 'Failed to Validate Request');

        // Save model and return data response with the new ID
		return [
			'status' => TRUE,
			'data_array' => $repo->save($employeeReport)
		];
	}
}