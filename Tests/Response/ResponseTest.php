<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Response;

use Jacoz\Symfony\ApiBundle\Response\AbstractResponse;
use Jacoz\Symfony\ApiBundle\Response\Interfaces\ApiResponseInterface;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ResponseTest extends TestCase
{
    /**
     * @return array
     */
    public function responsesProvider()
    {
        return [
            [
                new MyResponse('foo'),
                'foo',
                200,
                null,
            ], [
                new MyResponse(['foo' => 'bar'], 400),
                ['foo' => 'bar'],
                400,
                null,
            ],
        ];
    }

    /**
     * @param ApiResponseInterface $response
     * @param mixed $data
     * @param int $statusCode
     * @param mixed $meta
     *
     * @dataProvider responsesProvider
     */
    public function testData(
        ApiResponseInterface $response,
        $data,
        $statusCode,
        $meta
    ) {
        $this->assertArrayHasKey('status_code', $response->getResponseObject());
        $this->assertArrayHasKey('data', $response->getResponseObject());
        $this->assertArrayHasKey('meta', $response->getResponseObject());

        $this->assertEquals($data, $response->getData());
        $this->assertEquals($statusCode, $response->getStatusCode());
        $this->assertEquals($meta, $response->getMeta());
    }
}

class MyResponse extends AbstractResponse
{
}
