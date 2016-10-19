<?php

namespace Jacoz\Symfony\ApiBundle\Mapper;

use Jacoz\Symfony\ApiBundle\Model\Interfaces\MappableExistingEntityInterface;

class EntityMapper
{
    /**
     * @param object $entity
     * @param MappableExistingEntityInterface $model
     * @return object
     */
    public function mapExistingEntity($entity, MappableExistingEntityInterface $model)
    {
        $fields = [];

        $reflect = new \ReflectionClass($model);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach($props as $prop) {
            if (!is_null($model->{$prop->getName()})) {
                $fields[$prop->getName()] = $model->{$prop->getName()};
            }
        }

        foreach($fields as $field => $value) {
            $entity->{'set' . ucfirst($field)}($value);
        }

        return $entity;
    }
}
