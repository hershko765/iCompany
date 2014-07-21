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

class CategoryController extends Base\Controller {

	/**
	 * Get single Category,
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
	 * @Annotations\View(templateVar="category")
	 *
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getCategoryAction($id)
	{
		$handler = $this->getHandler('category', 'get');

		return $handler->setData($id)->execute();
	}

	/**
	 * Get single Category,
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get an category by given ID",
	 *   filters={
	 *      {"name"="category", "dataType"="string", "description"="search category by name"},
	 *      {"name"="limit", "dataType"="integer"},
	 *      {"name"="offset", "dataType"="integer"},
	 *      {"name"="order", "dataType"="string", "description"="order by column"}
	 *   },
	 *   output = "App\ManagerBundle\Entities\Model\Category",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the category is not found"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="category")
	 *
	 * @param Request $request the request object
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getCategoriesAction(Request $request)
	{
		$query    = $request->query->all();
		$paging   = Arr::extract($query, [ 'limit', 'offset', 'page', 'order' ]);
		$filters  = Arr::extract($query, [ 'search', 'parent' ]);
		$settings = Arr::extract($query, [ 'select', 'index', 'selectBox' ]);

		$handler  = $this->getHandler('category', 'collect');
		return $handler->setData($filters, $paging, $settings)->execute();
	}

	/**
	 * Create a category from the submitted data.
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
	 * @Annotations\View(templateVar="category")
	 *
	 * @param Request $request the request object
	 *
	 * @return array
	 */
	public function postCategoryAction(Request $request)
	{
		// Gathering data and handler
		$post = $request->request->all();
		$handler = $this->getHandler('category', 'create');

		return $handler->setData($post)->execute();
	}
}
