<?php

namespace App\SourceBundle\Base;

use Symfony\Bundle\FrameworkBundle;
use App\SourceBundle\Base;
use App\SourceBundle\Helpers\Arr;
use Symfony\Component\Config\Definition\Exception\Exception;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use App\SourceBundle\Base\HandlerManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Controller extends FOSRestController {

	/**
	 * @param $entity
	 * @param bool $handler
	 * @param bool $bundle
	 * @return mixed
	 * @throws \Symfony\Component\Config\Definition\Exception\Exception
	 * @throws \Symfony\Component\Form\Exception\InvalidArgumentException
	 * @return HandlerManager
	 */
	public function getHandler($entity, $handler = FALSE, $bundle = FALSE)
	{
		if ( ! $handler)
		{
			$params = explode('|', $entity);
			$entity = Arr::get($params, 0);
			$handler = Arr::get($params, 1);

			if( ! $handler)
				throw new InvalidArgumentException('Could not resolve handler name, please provide it');
		}

		// If bundle wasn't provided, trying to extract the name by the called controller
		if ( ! $bundle)
		{
			preg_match('/(?<BUNDLE>[\w]+)Bundle/', get_called_class(), $match);
			if ( ! Arr::get($match, 'BUNDLE'))
				throw new Exception('Could not extract bundle name, you should provide it in this case');

			$bundle = Arr::get($match, 'BUNDLE');
		}

		$gateway = $this->container->get('handler_gateway');

		return $gateway->getHandler($entity, $handler, $bundle);
	}

    /**
     * Create JSON response from exception
     * error
     *
     * @param $code
     * @param array $content
     */
    public function PipeException(\Exception $e, $additionalInfo = [])
    {
        $response = new JsonResponse();
        $response->setStatusCode($e->getStatusCode());
        $response->setContent(json_encode(array_merge([
            'error' => [
                'code' => $e->getStatusCode(),
                'message' => $e->getMessage()
            ]
        ], $additionalInfo)));
        $response->send();
    }

}