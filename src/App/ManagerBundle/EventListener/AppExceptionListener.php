<?php

namespace App\ManagerBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AppExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();
        if ($exception instanceof MethodNotAllowedHttpException)
        {
            // Customize your response object to display the exception details
            $response = new Response();
            $response->setContent(json_encode([
                'error' => [
                    'code' => Response::HTTP_METHOD_NOT_ALLOWED,
                    'message' => $exception->getMessage()
                ]
            ]));

            $response->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);

            $event->setResponse($response);
        }

        else if($exception instanceof NotFoundHttpException)
        {
            // Customize your response object to display the exception details
            $response = new Response();
            $response->setContent(json_encode([
                'error' => [
                    'code' => Response::HTTP_NOT_FOUND,
                    'message' => $exception->getMessage()
                ]
            ]));

            $response->setStatusCode(Response::HTTP_NOT_FOUND);

            $event->setResponse($response);
        }
    }
}