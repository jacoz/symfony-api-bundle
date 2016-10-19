<?php

namespace Jacoz\Symfony\ApiBundle\Response;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse extends AbstractResponse
{
    /**
     * @param mixed $data
     * @param int $statusCode
     * @param array $groups
     */
    public function __construct($data, $statusCode = Response::HTTP_OK, array $groups = ['Default'])
    {
        $data = $this->serializeData($data, $groups);

        parent::__construct($data, $statusCode);
    }

    /**
     * @param mixed $data
     * @param array $groups
     * @return array
     */
    private function serializeData($data, array $groups = [])
    {
        if (is_scalar($data)) {
            return $data;
        }

        $serializationContext = new SerializationContext();
        $serializationContext->setSerializeNull(true);
        $serializationContext->enableMaxDepthChecks();
        if (!empty($groups)) {
            $serializationContext->setGroups($groups);
        }

        $serializer = SerializerBuilder::create()->build();
        $data = $serializer->toArray($data, $serializationContext);

        return $data;
    }
}
