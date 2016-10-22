<?php

namespace Jacoz\Symfony\ApiBundle\Serializer;

use Jacoz\Symfony\ApiBundle\Serializer\Interfaces\ApiResponseSerializerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer as JmsSerializer;

final class JmsApiResponseSerializer implements ApiResponseSerializerInterface
{
    /**
     * @var JmsSerializer
     */
    private $jmsSerializer;

    /**
     * @param JmsSerializer $jmsSerializer
     */
    public function __construct(JmsSerializer $jmsSerializer)
    {
        $this->jmsSerializer = $jmsSerializer;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize($data, $format, array $options = null)
    {
        if (is_scalar($data)) {
            return $data;
        }

        $serializationContext = new SerializationContext();
        $serializationContext->setSerializeNull(true);
        $serializationContext->enableMaxDepthChecks();
        if (!empty($options['groups'])) {
            $serializationContext->setGroups($options['groups']);
        }

        return $this->jmsSerializer->toArray($data, $serializationContext);
    }
}
