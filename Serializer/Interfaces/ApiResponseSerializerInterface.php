<?php

namespace Jacoz\Symfony\ApiBundle\Serializer\Interfaces;

interface ApiResponseSerializerInterface
{
    /**
     * @param mixed $data
     * @param string $format
     * @param array|null $options
     * @return mixed
     */
    public function serialize($data, $format, array $options = null);
}
