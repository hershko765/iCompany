<?php

namespace App\UserBundle\Entities\Handler\Auth;

use App\SourceBundle\Base\HandlerManager;
use App\SourceBundle\Helpers\Arr;
use App\SourceBundle\Interfaces\Handler;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class isLogged extends HandlerManager {

	/**
	 * @var Registry
	 * @DI (alias=doctrine)
	 */
	protected $em;

	/**
	 * Request Object
	 * @var Request
	 */
	protected $request;

	public function setRequest(Request $request)
	{
		$this->request = $request;
		return $this;
	}

	public function execute()
	{
		return (bool) $this->request->cookies->get('user');
	}
}
 