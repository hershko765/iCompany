<?php

namespace App\UserBundle\Controller;

use App\SourceBundle\Base;

use App\SourceBundle\Helpers\Arr;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations;

// Annotation Dependency
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;



class SecurityController extends Base\Controller
{
    /**
     * @Route("/login")
     * @Template("UserBundle:Security:login.html.twig")
     */
    public function loginAction(Request $request)
    {
	    $credentials = json_decode($request->cookies->get('user') ?: '{}', TRUE);

	    if ( ! $credentials)
	    {
		    $post = $request->request->all();
		    if ( ! $post) return [];

		    $credentials = [
			    'email' => Arr::get($post, 'username'),
			    'password' => Arr::get($post, 'password')
		    ];
	    }
        
	    $this->getHandler('Auth', 'Login', 'User')->setCredentials($credentials)->execute();
        
	    $response = new Response();
	    $response->headers->setCookie(new Cookie('user', json_encode($credentials), 0, '/', NULL, FALSE, FALSE));
	    $response->send();

	    return $this->redirect('/');
    }
}
