<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Response;

use Jacoz\Symfony\ApiBundle\Exception\ApiException;
use Jacoz\Symfony\ApiBundle\Exception\ValidationException;
use Jacoz\Symfony\ApiBundle\Response\ErrorResponse;
use Jacoz\Symfony\ApiBundle\Response\Interfaces\ApiResponseInterface;
use Jacoz\Symfony\ApiBundle\Tests\Traits\ConstraintViolationTrait;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ErrorResponseTest extends TestCase
{
    use ConstraintViolationTrait;

    /**
     * @return array
     */
    public function responsesProvider()
    {
        return [
            [
                new ErrorResponse(new TestException('error')),
                ErrorResponse::DEFAULT_ERROR_CODE,
                'error',
                'TestException',
            ], [
                new ErrorResponse(new ApiException('error')),
                ErrorResponse::DEFAULT_ERROR_CODE,
                'error',
                'ApiException',
            ], [
                new ErrorResponse(new NotFoundHttpException('error')),
                404,
                'error',
                'NotFoundHttpException',
            ], [
                new ErrorResponse(new ValidationException(
                    $this->getViolationList([
                        $this->getViolation('param', 'error'),
                        $this->getViolation('param 2', 'error 2'),
                    ])
                )),
                ValidationException::DEFAULT_ERROR_CODE,
                null,
                'ValidationException',
                ['message', 'exception_class', 'errors'],
            ],
        ];
    }

    /**
     * @param ApiResponseInterface $response
     * @param int $statusCode
     * @param string $errorMessage
     * @param string $exceptionClass
     *
     * @dataProvider responsesProvider
     */
    public function testResponse(
        ApiResponseInterface $response,
        $statusCode,
        $errorMessage,
        $exceptionClass,
        $errorFields = ['message', 'exception_class']
    ) {
        $data = $response->getData();

        $this->assertArrayHasKey('status_code', $response->getResponseObject());
        $this->assertArrayHasKey('data', $response->getResponseObject());
        $this->assertArrayHasKey('meta', $response->getResponseObject());

        $this->assertEquals($statusCode, $response->getStatusCode());

        $this->assertArrayHasKey('error', $data);
        $this->assertArraySubset($errorFields, array_keys($data['error']));

        $this->assertEquals($errorMessage, $data['error']['message']);
        $this->assertEquals($exceptionClass, $data['error']['exception_class']);
    }
}

class TestException extends \Exception
{
}
