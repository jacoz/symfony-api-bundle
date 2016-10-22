<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Serializer;

use Jacoz\Symfony\ApiBundle\Response\ApiResponse;
use Jacoz\Symfony\ApiBundle\Response\Interfaces\ApiResponseInterface;
use Jacoz\Symfony\ApiBundle\Serializer\JmsApiResponseSerializer;
use Jacoz\Symfony\ApiBundle\Tests\Models\City;
use Jacoz\Symfony\ApiBundle\Tests\Models\Person;
use JMS\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class JmsApiResponseSerializerTest extends TestCase
{
    /**
     * @var JmsApiResponseSerializer
     */
    private $jmsApiResponseSerializer;

    public function setUp()
    {
        $this->jmsApiResponseSerializer = new JmsApiResponseSerializer($this->getJmsSerializerMock());
    }

    public function testStringData()
    {
        $data = 'foo';
        $response = $this->jmsApiResponseSerializer->serialize($data, 'json');

        $this->assertEquals($response, 'foo');
    }

    public function testArrayData()
    {
        $data = ['foo' => 'bar'];
        $response = $this->jmsApiResponseSerializer->serialize($data, 'json');

        $this->assertArraySubset($response, ['foo' => 'bar'], true);
    }

    public function testObjectData()
    {
        $data = new City();
        $response = $this->jmsApiResponseSerializer->serialize($data, 'json');

        $this->assertEquals($response, []);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Serializer
     */
    private function getJmsSerializerMock()
    {
        $jmsSerializer = $this
            ->getMockBuilder(Serializer::class)
            ->setMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();

        $jmsSerializer->expects($this->any())
            ->method('toArray')
            ->will($this->returnValue([]));

        return $jmsSerializer;
    }
}
