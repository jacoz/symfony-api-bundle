<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Models;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @ExclusionPolicy("all")
 */
class Person
{
    /**
     * @Expose()
     */
    private $firstName;

    /**
     * @Expose()
     */
    private $lastName;

    private $age;

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @VirtualProperty()
     * @SerializedName("full_name")
     */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }
}
