<?php

namespace App\ManagerBundle\Controller\API;

use App\SourceBundle\Base;


use App\SourceBundle\Helpers\Arr;

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


class EmployeeController extends Base\Controller {

	/**
	 * Get single Employee,
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get ",
	 *   output = "Acme\BlogBundle\Entity\Page",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the page is not found"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="Employee")
	 *
	 * @param int     $id      the page id
	 *
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
	 * Get single Employee,
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get an Employee by given ID",
	 *   filters={
	 *      {"name"="Employee", "dataType"="string", "description"="search Employee by name"},
	 *      {"name"="limit", "dataType"="integer"},
	 *      {"name"="offset", "dataType"="integer"},
	 *      {"name"="order", "dataType"="string", "description"="order by column"}
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

        return $handler->setOptions($filters, $paging, $settings)->execute();
	}

	/**
	 * Create a Employee from the submitted data.
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
	 * @Annotations\View(templateVar="Employee")
	 *
	 * @param Request $request the request object
	 *
	 * @return array
	 */
	public function postEmployeeAction(Request $request)
	{
		// Gathering data and handler
		$post = $request->request->all();
        $handler = $this->getHandler('Employee', 'Create');

		return $handler->setData($post)->execute();
	}


	/**
	 * Create a Employee from the submitted data.
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
	 * @Annotations\View(templateVar="Employee")
	 *
	 * @param Request $request the request object
	 *
	 * @return array
	 */
	public function putEmployeeAction(Request $request, $id)
	{
		// Gathering data and handler
		$post = $request->request->all();
		$handler = $this->getHandler('Employee', 'Update');

		return $handler->setData($post, $id)->execute();
	}

    /**
     * Update employee status.
     *
     * @post("/employee/status/{id}")
     * @Annotations\View(templateVar="Employee")
     * @param Request $request the request object
     * @return array
     */
    public function activateEmployeeAction(Request $request, $id)
    {
        $post = $request->request->all();
        // Gathering data and handler
        $handler = $this->getHandler('Employee', 'Update');

        return $handler->setData([ 'active' => Arr::get($post, 'status') ? 1 : 0 ], $id)->execute();
    }
}
