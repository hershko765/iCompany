<?php

namespace App\ManagerBundle\Entities\Handler\Department;

use App\SourceBundle\Base\HandlerManager;
use App\SourceBundle\Exception\ValidationException;
use App\SourceBundle\Helpers\Arr;
use App\SourceBundle\Interfaces\Handler;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException;

class Login extends HandlerManager {

	/**
	 * @var Registry
	 * @DI (alias=doctrine)
	 */
	protected $em;

    public function setCredentials(array $credentials)
    {
        $this->credentials = $credentials;
        return $this;
    }
	/**
	 * Outsource data
	 * @var array
	 */
	protected $filters  = [];

	protected function _execute()
	{
        if ( ! Arr::get($this->credentials, 'email'))
            throw new PreconditionRequiredHttpException('Email Address required');

        if (! Arr::get($this->credentials, 'password'))
            throw new PreconditionRequiredHttpException('Password required');

		$department = $this->em->getRepository('AppManagerBundle:Model\Department')->collect([ 'login' => $this->credentials ]);

        if ( ! $department) throw new PreconditionFailedHttpException('Failed to login user');

        return $department;
	}
}
 