<?php

namespace Jacoz\Symfony\ApiBundle\Mapper\Traits;

use Jacoz\Symfony\ApiBundle\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait ValidatorTrait
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param mixed $object
     * @param array $groups
     * @throws ValidationException
     */
    public function validateObject($object, $groups = null)
    {
        if (count($errors = $this->validator->validate($object, null, $groups))) {
            throw new ValidationException($errors);
        }
    }
}
