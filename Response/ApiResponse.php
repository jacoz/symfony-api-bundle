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
        parent::__construct($data, $statusCode);

        $this->setSerializationGroups($groups);
    }
}
