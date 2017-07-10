<?php

namespace Jacoz\Symfony\ApiBundle\Response;

use Jacoz\Symfony\ApiBundle\Response\Interfaces\ApiResponseInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractResponse implements ApiResponseInterface
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var array
     */
    private $serializationGroups = [];

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $meta;

    /**
     * @param mixed $data
     * @param int $statusCode
     */
    public function __construct($data, $statusCode = Response::HTTP_OK)
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function getSerializationGroups()
    {
        return $this->serializationGroups;
    }

    /**
     * @param array $serializationGroups
     */
    public function setSerializationGroups(array $serializationGroups)
    {
        $this->serializationGroups = $serializationGroups;
    }

    /**
     * @param int $statusCode
     */
    public function setStatuCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param array $meta
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function useApiResponseWrapperDefaultObjectTemplate()
    {
        return true;
    }
}
