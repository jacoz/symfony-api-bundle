<?php

namespace Jacoz\Symfony\ApiBundle\Serializer\Interfaces;

interface ApiResponseSerializerInterface
{
    public function serialize($data, $format, array $options = null);
}
