<?php

namespace Jacoz\Symfony\ApiBundle\Exception;

class ApiException extends \Exception
{
    /**
     * @var null|array
     */
    private $errors = null;

    /**
     * @param array $errors
     */
    protected function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return array|null
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
