<?php

namespace App\ManagerBundle\Entities\Handler\Permission;

use App\ManagerBundle\Entities\Model\Permission;
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
		$repo = $this->em->getRepository('AppManagerBundle:Model\Permission');
		// Load model by id, throw exception if nothing found
		$Permission = $repo->find($this->id);
		if ( ! $Permission)
			throw new NotFoundHttpException('Permission ID #'.$this->id.' Not Found');

		$repo->hydrate($this->data, $Permission, Repository::PERM_UPDATE);

		// Validate model, if errors found return them
		$errors = $this->validate->validate($Permission);
        // Throw exception if error returned
		if(count($errors) > 0)
            throw new ValidationException($this->errorsToArr($errors), 'Failed to Validate Request');

		// Save model into the database and return response
		return [
			'status' => TRUE,
			'data_array' => $repo->save($Permission)
		];
	}
}