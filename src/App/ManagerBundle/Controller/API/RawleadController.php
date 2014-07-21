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


class RawleadController extends Base\Controller {

	/**
	 * Get single Rawlead,
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
	 * @Annotations\View(templateVar="Rawlead")
	 *
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getRawleadAction($id)
	{
		$handler = $this->getHandler('Rawlead', 'get');

		return $handler->setID($id)->execute();
	}

	/**
	 * Get single Rawlead,
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get an Rawlead by given ID",
	 *   filters={
	 *      {"name"="Rawlead", "dataType"="string", "description"="search Rawlead by name"},
	 *      {"name"="limit", "dataType"="integer"},
	 *      {"name"="offset", "dataType"="integer"},
	 *      {"name"="order", "dataType"="string", "description"="order by column"}
	 *   },
	 *   output = "App\ManagerBundle\Entities\Model\Rawlead",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the Rawlead is not found"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="Rawlead")
	 *
	 * @param Request $request the request object
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getRawleadsAction(Request $request)
	{
		$query    = $request->query->all();
		$paging   = Arr::extract($query, [ 'limit', 'offset',  'order', 'page' ]);
		$filters  = Arr::extract($query, [ 'search', 'rawlead', 'active', 'country', 'group_click_id', 'product', 'broker', 'date_start', 'date_end' ]);
		$settings = Arr::extract($query, [ 'select', 'index', 'selectBox' ]);

        if(Arr::get($query, 'get_total'))
            $filters['get_rows'] = 1;

        $filters = array_filter($filters);
        $filters = array_diff($filters, [ 'null' ]);

        if( Arr::get($filters, 'date_start') && Arr::get($filters, 'date_end'))
        {
            $filters['date_range'] = [
                date( 'Y-m-d H:i:s', Arr::get($filters, 'date_start')),
                date( 'Y-m-d H:i:s', Arr::get($filters, 'date_end')),
            ];

            unset($filters['date_start']);
            unset($filters['date_end']);
        }

		$handler  = $this->getHandler('Rawlead', 'collect');

        return $handler->setOptions($filters, $paging, $settings)->execute();
	}

	/**
	 * Create a Rawlead from the submitted data.
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
	 * @Annotations\View(templateVar="Rawlead")
	 *
	 * @param Request $request the request object
	 *
	 * @return array
	 */
	public function postRawleadAction(Request $request)
	{
		// Gathering data and handler
		$post = $request->request->all();
        $handler = $this->getHandler('Rawlead', 'Create');

		return $handler->setData($post)->execute();
	}


	/**
	 * Create a Rawlead from the submitted data.
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
	 * @Annotations\View(templateVar="Rawlead")
	 *
	 * @param Request $request the request object
	 *
	 * @return array
	 */
	public function putRawleadAction(Request $request, $id)
	{
		// Gathering data and handler
		$post = $request->request->all();
		$handler = $this->getHandler('Rawlead', 'Update');

		return $handler->setData($post, $id)->execute();
	}

    /**
     * Update rawlead status.
     *
     * @post("/rawlead/status/{id}")
     * @Annotations\View(templateVar="Rawlead")
     * @param Request $request the request object
     * @return array
     */
    public function activateRawleadAction(Request $request, $id)
    {
        $post = $request->request->all();
        // Gathering data and handler
        $handler = $this->getHandler('Rawlead', 'Update');

        return $handler->setData([ 'active' => Arr::get($post, 'status') ? 1 : 0 ], $id)->execute();
    }

    /**
     * Update rawlead status.
     *
     * @get("/sentry/errors")
     * @Annotations\View(templateVar="Rawlead")
     * @param Request $request the request object
     * @return array
     */
    public function getSentryLogAction(Request $request)
    {
        $query = $request->query->all();
        // Gathering data and handler
        $handler = $this->getHandler('Rawlead', 'Sentry');

        // Apply Filters
        $filters = [];
        if ( Arr::get($query, 'dataRange')) {
            $filters['date_range'] = [
                date( 'Y-m-d H:i:s', Arr::get($query['dataRange'], 0)),
                date( 'Y-m-d H:i:s', Arr::get($query['dataRange'], 1)),
            ];
        }

        return $handler->setFilters($filters)->execute();
    }
}
