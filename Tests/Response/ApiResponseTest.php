<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Response;

use Jacoz\Symfony\ApiBundle\Response\ApiResponse;
use Jacoz\Symfony\ApiBundle\Response\Interfaces\ApiResponseInterface;
use Jacoz\Symfony\ApiBundle\Tests\Models\City;
use Jacoz\Symfony\ApiBundle\Tests\Models\Person;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ApiResponseTest extends TestCase
{
    /**
     * @return array
     */
    public function nonObjectDataResponsesProvider()
    {
        return [
            [
                new ApiResponse('foo'),
                'foo',
                200,
                null,
            ], [
                new ApiResponse(['foo' => 'bar'], 400),
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
     * @dataProvider nonObjectDataResponsesProvider
     */
    public function testNonObjectData(
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

    /**
     * @return array
     */
    public function objectDataResponsesProvider()
    {
        return [
            [
                new ApiResponse($this->getCity('Milano', 3204601)),
                200,
                ['name', 'population'],
                [
                    'name' => 'Milano',
                    'population' => 3204601,
                ]
            ], [
                new ApiResponse($this->getPerson('Jacopo', 'Nuzzi', 27)),
                200,
                ['full_name', 'first_name', 'last_name'],
                [
                    'full_name' => 'Jacopo Nuzzi'
                ]
            ],
        ];
    }

    /**
     * @param ApiResponseInterface $response
     * @param int $statusCode
     * @param array $returnedFields
     * @param array $objectValues
     *
     * @dataProvider objectDataResponsesProvider
     */
    public function testObjectData(
        ApiResponseInterface $response,
        $statusCode,
        array $returnedFields,
        array $objectValues
    ) {
        $this->assertArrayHasKey('status_code', $response->getResponseObject());
        $this->assertArrayHasKey('data', $response->getResponseObject());
        $this->assertArrayHasKey('meta', $response->getResponseObject());

        $this->assertEquals($statusCode, $response->getStatusCode());

        $this->assertArraySubset($returnedFields, array_keys($response->getData()));

        foreach ($objectValues as $key => $value) {
            $this->assertSame($value, $response->getData()[$key]);
        }
    }

    /**
     * @param string $name
     * @param int $population
     * @return City
     */
    public function getCity($name, $population)
    {
        $city = new City();
        $city->setId(1);
        $city->setName($name);
        $city->setPopulation($population);

        return $city;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param int $age
     * @return Person
     */
    public function getPerson($firstName, $lastName, $age)
    {
        $person = new Person();
        $person->setFirstName($firstName);
        $person->setLastName($lastName);
        $person->setAge($age);

        return $person;
    }
}
