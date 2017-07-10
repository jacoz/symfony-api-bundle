<?php

namespace Jacoz\Symfony\ApiBundle\EventListener;

use Jacoz\Symfony\ApiBundle\Model\ApiResponseWrapper;
use Jacoz\Symfony\ApiBundle\Response\Interfaces\ApiResponseInterface;
use Jacoz\Symfony\ApiBundle\Response\ErrorResponse;
use Jacoz\Symfony\ApiBundle\Serializer\Interfaces\ApiResponseSerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiResponseListener implements EventSubscriberInterface
{
    /**
     * @var ApiResponseSerializerInterface
     */
    private $apiResponseSerializer;

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

    /**
     * @param ApiResponseSerializerInterface $apiResponseSerializer
     */
    public function __construct(ApiResponseSerializerInterface $apiResponseSerializer)
    {
        $this->apiResponseSerializer = $apiResponseSerializer;
    }

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
        $data = $this->apiResponseSerializer->serialize(
            $controllerResult->getData(),
            'json',
            [
                'groups' => $controllerResult->getSerializationGroups(),
            ]
        );

        if ($controllerResult->useApiResponseWrapperDefaultObjectTemplate()) {
            $apiResponseWrapper = new ApiResponseWrapper(
                $data,
                $controllerResult->getStatusCode(),
                $controllerResult->getMeta()
            );

            $responseObject = $apiResponseWrapper->getResponseObject();
        } else {
            $responseObject = $data;
        }

        $response = new JsonResponse(
            $responseObject,
            $controllerResult->getStatusCode(),
            $controllerResult->getHeaders()
        );

        return $response;
    }
}
