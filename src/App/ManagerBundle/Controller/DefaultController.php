<?php

namespace App\ManagerBundle\Controller;
use App\SourceBundle\Base;

use App\SourceBundle\Helpers\Arr;
use Symfony\Component\HttpFoundation\Request;
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



class DefaultController extends Base\Controller
{
    /**
     * @Route("/")
     * @Template("ManagerBundle:Default:index.html.twig")
     */
    public function indexAction(Request $request)
    {
		$credentials = json_decode($request->cookies->get('user') ?: '{}', TRUE);
		$user = $this->getHandler('Auth', 'Login', 'User')->setCredentials($credentials)->execute();

	    if ( ! $user) return $this->redirect('/login');

		unset($user['password']);

        $defaultSplits = $this->getHandler('User', 'Collect', 'Manager')->setFilters([
            'country' => 'DEFAULT'
        ])->execute();

        $defaultSplitsArr = [];
        foreach($defaultSplits as $split)
        {
            $defaultSplitsArr[$split['product']] = $split['broker'];
        }

        $products = $this->getHandler('Product', 'Collect', 'Manager')
            ->setFilters([ 'active' => 1 ])
            ->setSettings([ 'select' => ['id', 'name', 'display_name', 'default_offer'] ])
            ->execute();

        $brokers = $this->getHandler('Broker', 'Collect', 'Manager')
            ->setFilters([ 'active' => 1 ])
            ->setSettings([ 'select' => ['id', 'name', 'display_name'] ])
            ->execute();

        $defaultProducts = file_get_contents('../../media/products/defaults.json');

	    return [
		    'user' => $user,
            'default_splits' => json_encode($defaultSplitsArr),
            'products' => json_encode($products),
            'brokers' => json_encode($brokers),
            'defaultProducts' => ($defaultProducts)
	    ];
    }

    /**
     * @Route("/test")
     * @Template("ManagerBundle:Default:index.html.twig")
     */
    public function tesstAction() {
        $products = $this->getHandler('Notification', 'Collect')->execute();
        print_r($products); die;
    }
}
