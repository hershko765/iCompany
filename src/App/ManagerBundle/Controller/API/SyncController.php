<?php

namespace App\ManagerBundle\Controller\API;

use App\SourceBundle\Base;


use App\SourceBundle\Helpers\Arr;

use App\SourceBundle\Helpers\Date;
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


class SyncController extends Base\Controller {

	/**
	 * Get single Sync,
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
	 * @Annotations\View(templateVar="Sync")
	 *
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getSyncAction($id)
	{
		$handler = $this->getHandler('Sync:User', 'get');

		return $handler->setID($id)->execute();
	}

	/**
	 * Get single sync,
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Get an Sync by given ID",
	 *   filters={
	 *      {"name"="Sync", "dataType"="string", "description"="search Sync by name"},
	 *      {"name"="limit", "dataType"="integer"},
	 *      {"name"="offset", "dataType"="integer"},
	 *      {"name"="order", "dataType"="string", "description"="order by column"}
	 *   },
	 *   output = "App\ManagerBundle\Entities\Model\Sync",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the Sync is not found"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="Sync")
	 *
	 * @param Request $request the request object
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getSyncsAction(Request $request)
	{
		$query    = $request->query->all();
        $paging   = Arr::extract($query, [ 'limit', 'offset',  'order', 'page', 'sort' ]);
		$filters  = Arr::extract($query, [ 'search' ]);
		$settings = Arr::extract($query, [ 'select', 'index', 'selectBox', 'get_total' ]);

        $filters['ignoreCountry'] = 'Israel';

        $filters = array_filter($filters);
        $filters = array_diff($filters, [ 'null' ]);

		$handler  = $this->getHandler('Sync:User', 'collect');

        return $handler->setOptions($filters, $paging, $settings)->execute();
	}

	/**
	 * Create a Sync from the submitted data.
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
	 * @Annotations\View(templateVar="Sync")
	 *
	 * @param Request $request the request object
	 *
	 * @return array
	 */
	public function postSyncAction(Request $request)
	{
		// Gathering data and handler
		$post = $request->request->all();
        $handler = $this->getHandler('Sync:User', 'Create');

		return $handler->setData($post)->execute();
	}


	/**
	 * Create a Sync from the submitted data.
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
	 * @Annotations\View(templateVar="Sync")
	 *
	 * @param Request $request the request object
	 *
	 * @return array
	 */
	public function putSyncAction(Request $request, $id)
	{
		// Gathering data and handler
		$post = $request->request->all();
		$handler = $this->getHandler('Sync:User', 'Update');

		return $handler->setData($post, $id)->execute();
	}

    /**
     * Sync users from bot and report to synced_users table
     *
     * @Post("/sync_bot")
     * @Annotations\View(templateVar="Sync")
     * @param Request $request the request object
     * @return array
     */
    public function syncBotAction(Request $request)
    {
        $min = 120;
        $minAgo = 0;
        $post = $request->request->all();
        $days = Arr::get($post, 'days');
        $hrs  = Arr::get($post, 'hours');

        $daysAgo = Arr::get($post, 'daysAgo');
        $hoursAgo = Arr::get($post, 'hoursAgo');

        if ($days)
        {
            $total = Date::DAY * $days;
            $totalAgo = Date::DAY * $daysAgo;
            $min = $total / 60;
            $minAgo = $totalAgo / 60;
        }

        if ($hrs)
        {
            $total = Date::HOUR * $hrs;
            $totalAgo = Date::HOUR * $hoursAgo;
            $min = $total / 60;
            $minAgo = $totalAgo / 60;
        }
        
        // Gathering data and handler
        $handler = $this->getHandler('BotAPI', 'Sync', 'Manager');

        return $handler->execute($min, $minAgo);
    }

    /**
     * Sync users from bot and report to synced_users table
     *
     * @Post("/sync/register")
     * @Annotations\View(templateVar="Sync")
     * @param Request $request the request object
     * @return array
     */
    public function registerSyncsAction(Request $request)
    {
        $post = $request->request->all();

        // Gathering data and handler
        $handler = $this->getHandler('Sync:User', 'Register', 'Manager');

        return $handler->setIDs(Arr::get($post, 'ids', []))->execute();
    }
}
