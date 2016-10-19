<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Mapper;

use Jacoz\Symfony\ApiBundle\Mapper\Traits\ValidatorTrait;
use Jacoz\Symfony\ApiBundle\Request\ParamConverter\AbstractApiConverter;
use Jacoz\Symfony\ApiBundle\Tests\Models\City;
use Jacoz\Symfony\ApiBundle\Tests\Traits\ConstraintViolationTrait;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiConverterTest extends TestCase
{
    /**
     * @var CityParamConverter
     */
    private $converter;

    public function setUp()
    {
        $object = new City();
        $serializer = $this->getSerializer($object);

        $this->converter = new CityParamConverter($serializer);
    }

    /**
     * @return array
     */
    public function supportsProvider()
    {
        return [
            [City::class, true],
            [__CLASS__, false],
            [null, false],
        ];
    }

    /**
     * @param $class
     * @param $isSupported
     *
     * @dataProvider supportsProvider
     */
    public function testSupports($class, $isSupported)
    {
        $config = $this->createConfiguration($class, 'city');
        $this->assertSame($isSupported, $this->converter->supports($config));
    }

    public function testApply()
    {
        $request = new Request();
        $config = $this->createConfiguration(City::class, 'city');

        $this->converter->apply($request, $config);

        $this->assertInstanceOf(City::class, $request->attributes->get('city'));
    }

    /**
     * @param object $object
     * @return SerializerInterface
     */
    private function getSerializer($object)
    {
        $serializer = $this
            ->getMockBuilder(SerializerInterface::class)
            ->setMethods(['serialize', 'deserialize'])
            ->disableOriginalConstructor()
            ->getMock();

        $serializer->expects($this->any())
            ->method('deserialize')
            ->will($this->returnValue($object));

        return $serializer;
    }

    public function createConfiguration($class, $name)
    {
        $config = $this
            ->getMockBuilder(ParamConverter::class)
            ->setMethods(['getClass', 'getAliasName', 'getOptions', 'getName', 'allowArray', 'isOptional'])
            ->disableOriginalConstructor()
            ->getMock();

        $config->expects($this->any())
            ->method('getName')
            ->will($this->returnValue($name));

        $config->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue($class));

        return $config;
    }
}

class CityParamConverter extends AbstractApiConverter
{
    public function apply(Request $request, ParamConverter $configuration)
    {
        $city = $this->getDocument($request, City::class);

        $request->attributes->set($configuration->getName(), $city);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        return ($configuration->getClass() === City::class);
    }
}
