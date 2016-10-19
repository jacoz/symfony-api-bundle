<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Mapper;

use Jacoz\Symfony\ApiBundle\Mapper\Traits\ValidatorTrait;
use Jacoz\Symfony\ApiBundle\Tests\Traits\ConstraintViolationTrait;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MapperValidatorTest extends TestCase
{
    use ConstraintViolationTrait;

    const VALIDATE_WITH_ERRORS = true;
    const VALIDATE_WITHOUT_ERRORS = false;

    public function testWithoutErrors()
    {
        $cityMapper = new CityMapper();
        $cityMapper->setValidator($this->getValidator());

        $cityMapper->validateObject('whatever');
    }

    /**
     * @expectedException \Jacoz\Symfony\ApiBundle\Exception\ValidationException
     */
    public function testWithErrors()
    {
        $cityMapper = new CityMapper();
        $cityMapper->setValidator($this->getValidator(self::VALIDATE_WITH_ERRORS));

        $cityMapper->validateObject('whatever');
    }

    /**
     * @param bool $withErrors
     * @return ValidatorInterface
     */
    private function getValidator($withErrors = self::VALIDATE_WITHOUT_ERRORS)
    {
        $validator = $this
            ->getMockBuilder(ValidatorInterface::class)
            ->setMethods(['validate', 'getMetadataFor', 'hasMetadataFor', 'validateProperty', 'validatePropertyValue', 'startContext', 'inContext'])
            ->disableOriginalConstructor()
            ->getMock();

        $errors = [];
        if ($withErrors) {
            $errors = $this->getViolationList([
                $this->getViolation('param', 'error message')
            ]);
        }

        $validator->expects($this->any())
            ->method('validate')
            ->will($this->returnValue($errors));

        return $validator;
    }
}

class CityMapper
{
    use ValidatorTrait;
}
