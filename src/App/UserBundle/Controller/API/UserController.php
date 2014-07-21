<?php

namespace App\UserBundle\Controller\API;

use App\SourceBundle\Base;


use App\SourceBundle\Helpers\Arr;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations;

// Annotations dependency
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Validator\Exception\ValidatorException;

class UserController extends Base\Controller {

	/**
	 * Get single User,
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Gets a Page for a given id",
	 *   output = "Acme\BlogBundle\Entity\Page",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the page is not found"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="user")
	 *
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getUserAction($id)
	{
		$handler = $this->getHandler('user', 'get');
		return $handler->setData($id)->execute();
	}

	/**
	 * Get single User,
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get an user by given ID",
	 *   filters={
	 *      {"name"="user", "dataType"="string", "description"="search user by name"},
	 *      {"name"="limit", "dataType"="integer"},
	 *      {"name"="offset", "dataType"="integer"},
	 *      {"name"="order", "dataType"="string", "description"="order by column"}
	 *   },
	 *   output = "App\UserBundle\Entities\Model\User",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the user is not found"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="user")
	 *
	 * @param Request $request the request object
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getUsersAction(Request $request)
	{
		$query    = $request->query->all();
		$paging   = Arr::extract($query, [ 'limit', 'offset', 'page', 'order' ]);
		$filters  = Arr::extract($query, [ 'search', 'category' ]);
		$settings = Arr::extract($query, [ 'select', 'selectBox' ]);

		$handler  = $this->getHandler('user', 'collect');
		return $handler->setData($filters, $paging, $settings)->execute();
	}

	/**
	 * Create a user from the submitted data.
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Creates a new page from the submitted data.",
	 *   input = "Acme\BlogBundle\Form\PageType",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     400 = "Returned when the form has errors"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="user")
	 *
	 * @param Request $request the request object
	 *
	 * @return array
	 */
	public function postUserAction(Request $request)
	{
		$response = new Response();
		$response->setStatusCode(Response::HTTP_OK);

		// Gathering data and handler
		$post = $request->request->all();
		$handler = $this->getHandler('user', 'create');
		return $handler->setData($post)->execute();
	}

	/**
	 * Login a user.
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Creates a new page from the submitted data.",
	 *   input = "Acme\BlogBundle\Form\PageType",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     400 = "Returned when the form has errors"
	 *   }
	 * )
	 *
	 * @Annotations\View()
	 *
	 * @param Request $request the request object
	 * @param Response $response the request object
	 *
	 * @return array
	 */
	public function postLoginAction(Request $request)
	{
		$credentials = json_decode($request->cookies->get('user') ?: '{}', TRUE);

		if ( ! $credentials)
		{
			$post = $request->request->all();
			$credentials = [
				'username' => Arr::get($post, 'username'),
				'password' => Arr::get($post, 'password')
			];
		}

		$user = $this->getHandler('Auth', 'Login', 'User')->setCredentials($credentials)->execute();

		$response = new Response();
		$response->headers->setCookie(new Cookie('user', json_encode($credentials), 0, '/', NULL, FALSE, FALSE));
		$response->send();

		return $user;
	}
}
