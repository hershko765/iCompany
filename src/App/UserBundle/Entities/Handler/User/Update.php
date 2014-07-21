<?php

namespace App\UserBundle\Entities\Handler\User;

use App\SourceBundle\Base\Repository\Repository;
use App\SourceBundle\Base\HandlerManager;
use App\SourceBundle\Helpers\Arr;
use App\SourceBundle\Interfaces\Handler;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Process\Process;
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

	public function setData(array $data, $id)
	{
		$this->data = $data;
		$this->id = $id;
		return $this;
	}

	public function execute()
	{
		// Get repository and filter data to contain only allowed data
		$repo = $this->em->getRepository('AppUserBundle:Model\User');

		// Load model by id, throw exception if nothing found
		$user = $repo->find($this->id);
		if ( ! $user)
			throw new NotFoundHttpException('User not found for id: '.$this->id);

		$repo->hydrate($this->data, $user, Repository::PERM_CREATE);

		// Validate model, if errors found return them
		$errors = $this->validate->validate($user);
		if(count($errors) > 0)
		{
			return [
				'status' => FALSE,
				'errors' => $this->errorsToArr($errors)
			];
		}

		// Save model into the database and return response
		return [
			'status' => TRUE,
			'data_array' => $repo->save($user)
		];
	}
}