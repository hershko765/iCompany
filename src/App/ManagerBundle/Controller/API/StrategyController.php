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


class StrategyController extends Base\Controller {

	/**
	 * Get single Strategy,
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
	 * @Annotations\View(templateVar="Strategy")
	 *
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getStrategyAction($id)
	{
		$handler = $this->getHandler('Strategy', 'get');

		return $handler->setID($id)->execute();
	}

	/**
	 * Get single Strategy,
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get an Strategy by given ID",
	 *   filters={
	 *      {"name"="Strategy", "dataType"="string", "description"="search Strategy by name"},
	 *      {"name"="limit", "dataType"="integer"},
	 *      {"name"="offset", "dataType"="integer"},
	 *      {"name"="order", "dataType"="string", "description"="order by column"}
	 *   },
	 *   output = "App\ManagerBundle\Entities\Model\Strategy",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the Strategy is not found"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="Strategy")
	 *
	 * @param Request $request the request object
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getStrategiesAction(Request $request)
	{
		$query    = $request->query->all();
        $paging   = Arr::extract($query, [ 'limit', 'offset',  'order', 'page', 'sort' ]);
		$filters  = Arr::extract($query, [ ]);
		$settings = Arr::extract($query, [ 'select', 'index', 'selectBox', 'get_total' ]);

        $filters = array_filter($filters);
        $filters = array_diff($filters, [ 'null' ]);

		$handler  = $this->getHandler('Strategy', 'collect');

        return $handler->setOptions($filters, $paging, $settings)->execute();
	}
}
