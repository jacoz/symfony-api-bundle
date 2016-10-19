<?php

namespace Jacoz\Symfony\ApiBundle\Mapper\Interfaces;

use Jacoz\Symfony\ApiBundle\Model\Interfaces\SearchInterface;

interface SearchMapperInterface extends RequestMapperInterface
{
    /**
     * @return SearchInterface
     */
    public function getSearchModel();
}
