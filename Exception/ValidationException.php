<?php

namespace Jacoz\Symfony\ApiBundle\Exception;

use Jacoz\Symfony\ApiBundle\Mapper\ConstraintViolationMapper;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends ApiException
{
    const ERROR_MESSAGE = null;

    const DEFAULT_ERROR_CODE = 400;

    /**
     * @param ConstraintViolationListInterface $errors
     */
    public function __construct($errors)
    {
        parent::__construct(self::ERROR_MESSAGE, self::DEFAULT_ERROR_CODE);

        if ($errors instanceof ConstraintViolationListInterface) {
            $errors = $this->transformConstraintViolationListToArray($errors);
        }

        $this->setErrors($errors);
    }

    /**
     * @param ConstraintViolationListInterface $violationList
     * @return array
     */
    private function transformConstraintViolationListToArray(ConstraintViolationListInterface $violationList)
    {
        return ConstraintViolationMapper::convertFromViolationList($violationList);
    }
}
