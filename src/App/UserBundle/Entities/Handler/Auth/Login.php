<?php

namespace App\UserBundle\Entities\Handler\Auth;

use App\SourceBundle\Base\HandlerManager;
use App\SourceBundle\Helpers\Arr;
use App\SourceBundle\Interfaces\Handler;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class Login extends HandlerManager {

    // Lower permission of login page to everyone
    const REQUIRED_PERMISSION = self::PERM_ALL;

    /**
	 * @var Registry
	 * @DI (alias=doctrine)
	 */
	protected $em;

    /**
	 * Outsource data
	 * @var array
	 */
	protected $credentials;

	public function setCredentials(array $credentials)
	{
		$this->credentials = $credentials;

		return $this;
	}

	public function execute()
	{
		$user = $this->em->getRepository('AppUserBundle:Model\User');

		$result = $user->collect([
            'login' => [
                'email' => Arr::get($this->credentials, 'email'),
                'password' => Arr::get($this->credentials, 'password')
		    ]
        ]);
		
        
		if ( ! Arr::get($result, 0))
			return FALSE;
        
//		$verify = password_verify(Arr::get($this->credentials, 'password'), $result[0]['password']);
//
//		if ( ! $verify)
//			return FALSE;

		return $result;
	}
}
 