<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Models;

use Jacoz\Symfony\ApiBundle\Model\Interfaces\MappableExistingEntityInterface;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;

class City implements MappableExistingEntityInterface
{
    /**
     * @Exclude()
     */
    public $id;

    /**
     * @Type("string")
     */
    public $name;

    /**
     * @Type("integer")
     */
    public $population;

    private $country;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * @param mixed $population
     */
    public function setPopulation($population)
    {
        $this->population = $population;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}
