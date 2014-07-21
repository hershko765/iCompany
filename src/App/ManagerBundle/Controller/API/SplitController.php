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
use FOS\RestBundle\Controller\Annotations\Get;

class SplitController extends Base\Controller {

	/**
	 * Get single Split,
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
	 * @Annotations\View(templateVar="Split")
	 *
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getSplitAction($id)
	{
		$handler = $this->getHandler('Split', 'get');

		return $handler->setID($id)->execute();
	}

	/**
	 * Get single Split,
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get an Split by given ID",
	 *   filters={
	 *      {"name"="Split", "dataType"="string", "description"="search Split by name"},
	 *      {"name"="limit", "dataType"="integer"},
	 *      {"name"="offset", "dataType"="integer"},
	 *      {"name"="order", "dataType"="string", "description"="order by column"}
	 *   },
	 *   output = "App\ManagerBundle\Entities\Model\Split",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the Split is not found"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="Split")
	 *
	 * @param Request $request the request object
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getSplitsAction(Request $request)
	{
		$query    = $request->query->all();
        $paging   = Arr::extract($query, [ 'limit', 'offset',  'order', 'page', 'sort' ]);
		$filters  = Arr::extract($query, [ 'free_search', 'search', 'product', 'active_only', 'broker', 'country', 'active_products', 'labels' ]);
		$settings = Arr::extract($query, [ 'select', 'index', 'selectBox', 'get_total' ]);

        $filters = array_filter($filters);
        $filters = array_diff($filters, [ 'null' ]);

		$handler  = $this->getHandler('Split', 'collect');

        return $handler->setOptions($filters, $paging, $settings)->execute();
	}

	/**
	 * Create a Split from the submitted data.
	 *
	 * @Annotations\View(templateVar="Split")
	 *
	 * @param Request $request the request object
	 *
	 * @return array
	 */
	public function postSplitAction(Request $request)
	{
		// Gathering data and handler
		$post = $request->request->all();
        $handler = $this->getHandler('Split', 'Create');

		return $handler->setData($post)->execute();
	}

	/**
	 * Multi split update weights.
	 *
	 * @Annotations\View(templateVar="Split")
	 * @param Request $request the request object
     * @Post("/splits/weights")
	 * @return array
	 */
	public function updateSplitAction(Request $request)
	{
		// Gathering data and handler
		$post = $request->request->all();
		$handler = $this->getHandler('Split', 'Weights');

		return $handler->setWeights($post)->execute();
	}

	/**
	 * Multi split update weights.
	 *
	 * @Annotations\View(templateVar="Split")
	 * @param Request $request the request object
     * @Post("/splits/multiple")
	 * @return array
	 */
	public function createSplitsAction(Request $request)
	{
		// Gathering data and handler
		$post = $request->request->all();
		$handler = $this->getHandler('Split', 'Multiple');
		return $handler->setSplits(Arr::get($post, 'splits'), Arr::get($post, 'product', Arr::get($post, 'broker')))->execute();
	}

    /**
     * Create a Split from the submitted data.
     *
     * @Annotations\View(templateVar="Split")
     *
     * @param Request $request the request object
     *
     * @return array
     */
    public function deleteSplitAction(Request $request, $id)
    {
        $handler = $this->getHandler('Split', 'Delete');

        return $handler->setID($id)->execute();
    }


    /**
     * Check if its safe to delete a split
     *
     * @Annotations\View(templateVar="Split")
     * @param Request $request the request object
     * @Get("/splits/delete/safe/{url_id}")
     * @return array
     */
    public function safeDeleteAction(Request $request, $url_id )
    {
        $result = $this->getHandler('Split', 'Collect')->setFilters([ 'url_id' => $url_id ])->execute();

        return count($result) <= 1;
    }
}
