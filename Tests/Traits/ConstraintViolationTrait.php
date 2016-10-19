<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Traits;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

trait ConstraintViolationTrait
{
    /**
     * @param string $propertyPath
     * @param string $errorMessage
     * @param string $invalidValue
     * @return ConstraintViolationInterface
     */
    private function getViolation($propertyPath, $errorMessage, $invalidValue = '')
    {
        return new ConstraintViolation($errorMessage, $errorMessage, [], 'obj', $propertyPath, $invalidValue);
    }

    /**
     * @param ConstraintViolationInterface[] $violations
     * @return ConstraintViolationListInterface
     */
    private function getViolationList(array $violations)
    {
        return new ConstraintViolationList($violations);
    }
}
