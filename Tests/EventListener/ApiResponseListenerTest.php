<?php

namespace Jacoz\Symfony\ApiBundle\Tests\EventListener;

use Jacoz\Symfony\ApiBundle\EventListener\ApiResponseListener;
use Jacoz\Symfony\ApiBundle\Response\ApiResponse;
use Jacoz\Symfony\ApiBundle\Serializer\Interfaces\ApiResponseSerializerInterface;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ApiResponseListenerTest extends TestCase
{
    const MASTER_REQUEST = 1;

    public function testExceptionResponse()
    {
        $event = new GetResponseForExceptionEvent(
            new TestKernelThatThrowsException(),
            new Request(),
            self::MASTER_REQUEST,
            new \Exception()
        );

        $listener = new ApiResponseListener($this->getApiResponseSerializerMock(['error' => 'foo']));
        $listener->onKernelException($event);

        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());

        $response = json_decode($event->getResponse()->getContent());

        $this->assertObjectHasAttribute('status_code', $response);
        $this->assertObjectHasAttribute('data', $response);
        $this->assertObjectHasAttribute('error', $response->data);
    }

    public function testApiResponse()
    {
        $event = $this->getResponseForControllerResultEvent(
            new ApiResponse(1)
        );

        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());

        $response = json_decode($event->getResponse()->getContent());

        $this->assertObjectHasAttribute('status_code', $response);
        $this->assertObjectHasAttribute('data', $response);
    }

    public function testUncaughtResponse()
    {
        $event = $this->getResponseForControllerResultEvent(
            new JsonResponse(['foo' => 'bar'])
        );

        $this->assertNull($event->getResponse());
    }

    /**
     * @param mixed $response
     * @return GetResponseForControllerResultEvent
     */
    private function getResponseForControllerResultEvent($response)
    {
        $event = new GetResponseForControllerResultEvent(
            new TestKernel(),
            new Request(),
            self::MASTER_REQUEST,
            $response
        );

        $listener = new ApiResponseListener($this->getApiResponseSerializerMock('foo'));
        $listener->onKernelView($event);

        return $event;
    }

    /**
     * @param mixed $object
     * @return \PHPUnit_Framework_MockObject_MockObject|ApiResponseSerializerInterface
     */
    private function getApiResponseSerializerMock($object)
    {
        $apiResponseSerializer = $this
            ->getMockBuilder(ApiResponseSerializerInterface::class)
            ->setMethods(['serialize'])
            ->disableOriginalConstructor()
            ->getMock();

        $apiResponseSerializer->expects($this->any())
            ->method('serialize')
            ->will($this->returnValue($object));

        return $apiResponseSerializer;
    }
}

class TestKernel implements HttpKernelInterface
{
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        return new Response();
    }
}

class TestKernelThatThrowsException implements HttpKernelInterface
{
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        throw new \Exception();
    }
}
