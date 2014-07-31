<?php

namespace App\ManagerBundle\Controller\API;

use App\SourceBundle\Base;


use App\SourceBundle\Exception\ValidationException;
use App\SourceBundle\Helpers\Arr;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations;
use Symfony\Component\HttpKernel\Exception\HttpException;

// Annotations dependency
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException;

class DepartmentController extends Base\Controller {


    /**
     * Validate Department Login.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Validate Department with email and password",
     *   input = "Acme\BlogBundle\Form\PageType",
     *   requirements={
     *      {
     *          "name"="email",
     *          "dataType"="string",
     *          "requirement"="3 chars",
     *          "description"="department email"
     *      },
     *      {
     *          "name"="password",
     *          "dataType"="string",
     *          "requirement"="3 chars",
     *          "description"="department password"
     *      }
     * },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     412 = "Returned when login failed",
     *     428 = "Returned when parameters are missing"
     *   }
     * )
     * @post("/login")
     * @Annotations\View(templateVar="Department")
     * @param Request $request the request object
     * @return array
     */
    public function validateLoginAction(Request $request)
    {
        // avivbenyair159@gmail.com
        $post = $request->request->all();

        // Gathering data and handler
        $handler = $this->getHandler('Department', 'Login');

        try {
            // Return response
            return $handler
                ->setCredentials([ 'email' => Arr::get($post, 'email'), 'password' => Arr::get($post, 'password') ])
                ->execute();
        }
        catch(HttpException $e)
        {
            $this->PipeException($e);
        }
    }

	/**
	 * Get single Department,
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get Single Department",
     *   output = "App\ManagerBundle\Entities\Model\Department",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the department ID given is not exists"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="Department")
	 * @param int $id department id
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getDepartmentAction($id)
	{
		$handler = $this->getHandler('Department', 'get');

        try {
            return $handler->setID($id)->execute();
        }
        catch(HttpException $e)
        {
            $this->PipeException($e);
        }
	}

	/**
	 * Get List of Departments,
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get List of Departments",
	 *   filters={
	 *      {"name"="search", "dataType"="string", "description"="search Department by name"},
	 *      {"name"="limit", "dataType"="integer"},
	 *      {"name"="offset", "dataType"="integer"},
	 *      {"name"="order", "dataType"="string", "description"="order by DESC/ASC"},
	 *      {"name"="sort", "dataType"="string", "description"="order by column"}
	 *   },
	 *   output = "App\ManagerBundle\Entities\Model\Department",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="Department")
	 *
	 * @param Request $request the request object
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 */
	public function getDepartmentsAction(Request $request)
	{
		$query    = $request->query->all();
        $paging   = Arr::extract($query, [ 'limit', 'offset',  'order', 'page', 'sort' ]);
		$filters  = Arr::extract($query, [ 'search', 'department', 'active', 'country' ]);
		$settings = Arr::extract($query, [ 'select', 'index', 'selectBox', 'get_total' ]);

        // Remove false or empty filters
        $filters = array_filter($filters);

        // remove NULL values
        $filters = array_diff($filters, [ 'null' ]);

		$handler  = $this->getHandler('Department', 'collect');
        return $handler->setOptions($filters, $paging, $settings)->execute();
	}

	/**
	 * Create a Department from the submitted data.
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Creates a new department from post fields",
	 *   input = "App\ManagerBundle\Entities\Model\Department",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     412 = "Returned when the form has errors"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="Department")
	 * @param Request $request the request object
	 * @return array
	 */
	public function postDepartmentAction(Request $request)
	{
		// Gathering data and handler
		$post = $request->request->all();
        $handler = $this->getHandler('Department', 'Create');

        try {
            return $handler->setData($post)->execute();
        }
        catch(ValidationException $e)
        {
            $this->PipeException($e, [
                'validation' => $e->errors
            ]);
        }
        catch(HttpException $e)
        {
            $this->PipeException($e);
        }
	}

	/**
	 * Update exist department by given ID
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Update exist department by given ID, make sure to add Content-Type: application/x-www-form-urlencoded in your request header",
	 *   input = "App\ManagerBundle\Entities\Model\Department",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the department ID given is not exists",
	 *     412 = "Returned when the form has errors"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="Department")
	 * @param Request $request the request object
	 * @return array
	 */
	public function putDepartmentAction(Request $request, $id)
	{
		// Gathering data and handler
		$post = $request->request->all();
		$handler = $this->getHandler('Department', 'Update');

        try {
            return $handler->setData($post, $id)->execute();
        }
        catch(ValidationException $e)
        {
            $this->PipeException($e, [
                'validation' => $e->errors
            ]);
        }
        catch(HttpException $e)
        {
            $this->PipeException($e);
        }
	}
}
