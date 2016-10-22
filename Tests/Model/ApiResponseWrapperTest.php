<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Model;

use Jacoz\Symfony\ApiBundle\Model\ApiResponseWrapper;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ApiResponseWrapperTest extends TestCase
{
    public function testResponseObject()
    {
        $apiResponseWrapper = new ApiResponseWrapper(
            'foo',
            200,
            ['foo' => 'bar']
        );

        $responseObject = $apiResponseWrapper->getResponseObject();

        $this->assertArrayHasKey('data', $responseObject);
        $this->assertArrayHasKey('status_code', $responseObject);
        $this->assertArrayHasKey('meta', $responseObject);

        $this->assertEquals('foo', $responseObject['data']);
        $this->assertEquals(200, $responseObject['status_code']);
        $this->assertArraySubset(['foo' => 'bar'], $responseObject['meta'], true);
    }
}
