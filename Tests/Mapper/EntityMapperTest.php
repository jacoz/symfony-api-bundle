<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Mapper;

use Jacoz\Symfony\ApiBundle\Mapper\EntityMapper;
use Jacoz\Symfony\ApiBundle\Tests\Models\City;
use Jacoz\Symfony\ApiBundle\Tests\Models\CityEntity;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class EntityMapperTest extends TestCase
{
    public function testExistingEntityMapper()
    {
        $model = new City();
        $model->setId(1);
        $model->setName('Milan');
        $model->setPopulation(3204601);
        $model->setCountry('Italy');

        $entity = new CityEntity();

        $entityMapper = new EntityMapper();
        $entityMapper->mapExistingEntity($entity, $model);

        $this->assertEquals(1, $entity->getId());
        $this->assertEquals('Milan', $entity->getName());
        $this->assertEquals(3204601, $entity->getPopulation());
        $this->assertNull($entity->getCountry());
    }
}
