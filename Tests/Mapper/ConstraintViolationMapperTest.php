<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Mapper;

use Jacoz\Symfony\ApiBundle\Mapper\ConstraintViolationMapper;
use Jacoz\Symfony\ApiBundle\Tests\Traits\ConstraintViolationTrait;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationMapperTest extends TestCase
{
    use ConstraintViolationTrait;

    /**
     * @return array
     */
    public function violationProvider()
    {
        return [
            [
                $this->getViolation('param', 'error message'),
                'param',
                'error message',
                '',
            ], [
                $this->getViolation('param 2', 'error message 2', 'foo'),
                'param 2',
                'error message 2',
                'foo',
            ],
        ];
    }

    /**
     * @param ConstraintViolationInterface $violation
     * @param string $propertyPath
     * @param string $errorMessage
     * @param string $invalidValue
     *
     * @dataProvider violationProvider
     */
    public function testConvertFromViolation(
        ConstraintViolationInterface $violation,
        $propertyPath,
        $errorMessage,
        $invalidValue
    ) {
        $mappedViolation = ConstraintViolationMapper::convertFromViolation($violation);

        $this->assertArrayHasKey('field', $mappedViolation);
        $this->assertArrayHasKey('message', $mappedViolation);
        $this->assertArrayHasKey('invalid_value', $mappedViolation);

        $this->assertEquals($propertyPath, $mappedViolation['field']);
        $this->assertEquals($errorMessage, $mappedViolation['message']);
        $this->assertEquals($invalidValue, $mappedViolation['invalid_value']);
    }

    /**
     * @return array
     */
    public function violationListProvider()
    {
        return [
            [
                $this->getViolationList([
                    $this->getViolation('param', 'error message'),
                    $this->getViolation('param 2', 'error message 2'),
                    $this->getViolation('param 3', 'error message 3'),
                ]),
                3
            ], [
                $this->getViolationList([
                    $this->getViolation('param', 'error message'),
                ]),
                1
            ], [
                $this->getViolationList([]),
                0,
            ]
        ];
    }

    /**
     * @param ConstraintViolationListInterface $violationList
     * @param int $itemsCount
     *
     * @dataProvider violationListProvider
     */
    public function testConvertFromViolationList(
        ConstraintViolationListInterface $violationList,
        $itemsCount
    ) {
        $mappedViolationList = ConstraintViolationMapper::convertFromViolationList($violationList);

        $this->assertCount($itemsCount, $mappedViolationList);
    }
}
