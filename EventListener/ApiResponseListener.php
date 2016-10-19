<?php

namespace Jacoz\Symfony\ApiBundle\EventListener;

use Jacoz\Symfony\ApiBundle\Response\Interfaces\ApiResponseInterface;
use Jacoz\Symfony\ApiBundle\Response\ErrorResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiResponseListener implements EventSubscriberInterface
{
    /**
     * @todo set json response only if request is in json
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $errorResponse = new ErrorResponse($event->getException());

        $event->setResponse($this->createResponse($errorResponse));
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $controllerResult = $event->getControllerResult();

        if (!$controllerResult instanceof ApiResponseInterface) {
            return;
        }

        $event->setResponse($this->createResponse($controllerResult));
    }

    /**
     * @param ApiResponseInterface $controllerResult
     * @return JsonResponse
     */
    private function createResponse(ApiResponseInterface $controllerResult)
    {
        $response = new JsonResponse(
            $controllerResult->getResponseObject(),
            $controllerResult->getStatusCode(),
            $controllerResult->getHeaders()
        );

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 200],
            KernelEvents::VIEW => ['onKernelView', 0]
        ];
    }
}
