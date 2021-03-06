<?php

namespace App\ManagerBundle\Entities\Handler\Department;

use App\ManagerBundle\Entities\Model\Department;
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
		$repo = $this->em->getRepository('AppManagerBundle:Model\Department');
		// Load model by id, throw exception if nothing found
		$department = $repo->find($this->id);
		if ( ! $department)
			throw new NotFoundHttpException('Department ID #'.$this->id.' Not Found');

		$repo->hydrate($this->data, $department, Repository::PERM_UPDATE);

		// Validate model, if errors found return them
		$errors = $this->validate->validate($department);
        // Throw exception if error returned
		if(count($errors) > 0)
            throw new ValidationException($this->errorsToArr($errors), 'Failed to Validate Request');

		// Save model into the database and return response
		return [
			'status' => TRUE,
			'data_array' => $repo->save($department)
		];
	}
}