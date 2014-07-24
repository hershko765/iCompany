<?php

namespace App\ManagerBundle\Entities\Handler\Employee\Condition;

use App\ManagerBundle\Entities\Model\Employee;
use App\SourceBundle\Base\Repository\Repository;
use App\SourceBundle\Base\HandlerManager;
use App\SourceBundle\Exception\ValidationException;
use App\SourceBundle\Helpers\Arr;
use App\SourceBundle\Interfaces\Handler;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator;

class Update extends HandlerManager implements Handler {

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
	 * data to update
	 * @var array
	 */
	protected $data, $id;

	public function setData(array $data, $id = NULL)
	{
		$this->data = $data;
		$this->id = $id;
		return $this;
	}

	protected function _execute()
	{
		// Get repository and filter data to contain only allowed data
		$repo = $this->em->getRepository('AppManagerBundle:Model\Employee\Condition');
		// Load model by id, throw exception if nothing found
		$employee = $repo->find($this->id);
		if ( ! $employee)
			throw new NotFoundHttpException('Employee not found for id: '.$this->id);

		$repo->hydrate($this->data, $employee, Repository::PERM_UPDATE);

		// Validate model, if errors found return them
		$errors = $this->validate->validate($employee);
        if(count($errors) > 0)
            throw new ValidationException($errors);

		// Save model into the database and return response
		return [
			'status' => TRUE,
			'data_array' => $repo->save($employee)
		];
	}
}