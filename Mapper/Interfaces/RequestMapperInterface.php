<?php

namespace Jacoz\Symfony\ApiBundle\Mapper\Interfaces;

use Symfony\Component\HttpFoundation\Request;

interface RequestMapperInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function convertFromRequest(Request $request);
}
