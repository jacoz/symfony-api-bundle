<?php

namespace Jacoz\Symfony\ApiBundle\Response\Interfaces;

interface ApiResponseInterface
{
    /**
     * @return mixed
     */
    public function getData();

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

    /**
     * @return array
     */
    public function getResponseObject();
}
