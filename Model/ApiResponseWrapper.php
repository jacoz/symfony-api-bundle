<?php

namespace Jacoz\Symfony\ApiBundle\Model;

final class ApiResponseWrapper
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var array|null
     */
    private $meta;

    /**
     * @param mixed $data
     * @param int $statusCode
     * @param array $meta
     */
    public function __construct($data, $statusCode, array $meta = null)
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->meta = $meta;
    }

    /**
     * @return array
     */
    public function getResponseObject()
    {
        return [
            'status_code' => $this->statusCode,
            'data' => $this->data,
            'meta' => $this->meta,
        ];
    }
}
