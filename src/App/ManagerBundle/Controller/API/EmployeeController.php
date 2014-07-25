<?php

namespace App\ManagerBundle\Controller\API;

use App\SourceBundle\Base;


use App\SourceBundle\Exception\ValidationException;
use App\SourceBundle\Helpers\Arr;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations;

// Annotations dependency
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;


class EmployeeController extends Base\Controller {


    /**
     * Validate Employee Login.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new page from the submitted data.",
     *   input = "Acme\BlogBundle\Form\PageType",
     *   requirements={
     *      {
     *          "name"="email",
     *          "dataType"="string",
     *          "requirement"="3 chars",
     *          "description"="employee email"
     *      },
     *      {
     *          "name"="password",
     *          "dataType"="string",
     *          "requirement"="3 chars",
     *          "description"="employee password"
     *      }
     * },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     412 = "Returned when login failed",
     *     428 = "Returned when parameters are missing"
     *   }
     * )
     * @post("/login")
     * @Annotations\View(templateVar="Broker")
     * @param Request $request the request object
     * @return array
     */
    public function validateLoginAction(Request $request)
    {
        // avivbenyair159@gmail.com
        $post = $request->request->all();
        // Gathering data and handler
        $handler = $this->getHandler('Employee', 'Login');

        return $handler
            ->setCredentials([ 'email' => Arr::get($post, 'email'), 'password' => Arr::get($post, 'password') ])
            ->execute();
    }

	/**
	 * Get single Employee,
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get Single Employee",
	 *   output = "array",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the employee is not found"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="Employee")
	 * @param int $id employee id
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getEmployeeAction($id)
	{
		$handler = $this->getHandler('Employee', 'get');

		return $handler->setID($id)->execute();
	}

	/**
	 * Get List of Employees,
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get List of Employees",
	 *   filters={
	 *      {"name"="search", "dataType"="string", "description"="search Employee by name"},
	 *      {"name"="limit", "dataType"="integer"},
	 *      {"name"="offset", "dataType"="integer"},
	 *      {"name"="order", "dataType"="string", "description"="order by DESC/ASC"},
	 *      {"name"="sort", "dataType"="string", "description"="order by column"}
	 *   },
	 *   output = "App\ManagerBundle\Entities\Model\Employee",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the Employee is not found"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="Employee")
	 *
	 * @param Request $request the request object
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getEmployeesAction(Request $request)
	{
		$query    = $request->query->all();
        $paging   = Arr::extract($query, [ 'limit', 'offset',  'order', 'page', 'sort' ]);
		$filters  = Arr::extract($query, [ 'search', 'employee', 'active', 'country' ]);
		$settings = Arr::extract($query, [ 'select', 'index', 'selectBox', 'get_total' ]);

        $filters = array_filter($filters);
        $filters = array_diff($filters, [ 'null' ]);

		$handler  = $this->getHandler('Employee', 'collect');

        try {
            return $handler->setOptions($filters, $paging, $settings)->execute();
        }
        catch(NotFoundHttpException $e)
        {
            $response = new Response();
            $response->setStatusCode(404);
            $response->send();
            return [
                'error' => [
                    'code' => 404,
                    'message' => $e->getMessage()
                ]
            ];
        }
	}

	/**
	 * Create a Employee from the submitted data.
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Creates a new employee from post fields",
	 *   input = "Acme\BlogBundle\Form\PageType",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     412 = "Returned when the form has errors"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="Employee")
	 * @param Request $request the request object
	 * @return array
	 */
	public function postEmployeeAction(Request $request)
	{
		// Gathering data and handler
		$post = $request->request->all();
        $handler = $this->getHandler('Employee', 'Create');

        try {
            return $handler->setData($post)->execute();
        }
        catch(ValidationException $e)
        {
            $response = new Response();
            $response->setStatusCode(412);
            $response->send();
            return [
                'error' => [
                    'code' => 412,
                    'message' => $e->getMessage(),
                    'validation' => $e->errors
                ]
            ];
        }
	}

	/**
	 * Update exist employee by given ID
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Update exist employee by given ID, make sure to add Content-Type: application/x-www-form-urlencoded in your request header",
	 *   input = "Acme\BlogBundle\Form\PageType",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     400 = "Returned when the form has errors"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="Employee")
	 * @param Request $request the request object
	 * @return array
	 */
	public function putEmployeeAction(Request $request, $id)
	{
		// Gathering data and handler
		$post = $request->request->all();
		$handler = $this->getHandler('Employee', 'Update');

        try {
            return $handler->setData($post, $id)->execute();
        }
        catch(ValidationException $e)
        {
            $response = new Response();
            $response->setStatusCode(412);
            $response->send();
            return [
                'error' => [
                    'code' => 412,
                    'message' => $e->getMessage(),
                    'validation' => $e->errors
                ]
            ];
        }
        catch(NotFoundHttpException $e)
        {
            $response = new Response();
            $response->setStatusCode(404);
            $response->send();
            return [
                'error' => [
                    'code' => 404,
                    'message' => $e->getMessage()
                ]
            ];
        }
	}
}
