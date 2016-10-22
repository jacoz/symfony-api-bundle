<?php

namespace Jacoz\Symfony\ApiBundle\Response\Interfaces;

interface ApiResponseInterface
{
    /**
     * @param mixed $data
     */
    public function setData($data);

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return array
     */
    public function getSerializationGroups();

    /**
     * @return integer
     */
    public function getStatusCode();

    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @return array
     */
    public function getMeta();
}
