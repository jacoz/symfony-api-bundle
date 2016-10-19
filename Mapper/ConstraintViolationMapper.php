<?php

namespace Jacoz\Symfony\ApiBundle\Mapper;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationMapper
{
    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     * @return array
     */
    public static function convertFromViolationList(ConstraintViolationListInterface $constraintViolationList)
    {
        $errors = [];

        /** @var ConstraintViolationInterface $error */
        foreach($constraintViolationList as $error) {
            $errors[] = self::convertFromViolation($error);
        }

        return $errors;
    }

    /**
     * @param ConstraintViolationInterface $constraintViolation
     * @return array
     */
    public static function convertFromViolation(ConstraintViolationInterface $constraintViolation)
    {
        return [
            'field' => $constraintViolation->getPropertyPath(),
            'message' => $constraintViolation->getMessage(),
            'invalid_value' => $constraintViolation->getInvalidValue(),
        ];
    }
}
