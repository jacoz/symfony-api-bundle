<?php

namespace Jacoz\Symfony\ApiBundle\Mapper;

use Jacoz\Symfony\ApiBundle\Mapper\Interfaces\SearchMapperInterface;
use Jacoz\Symfony\ApiBundle\Model\Interfaces\SearchInterface;
use Jacoz\Symfony\ApiBundle\Model\Search;
use Symfony\Component\HttpFoundation\Request;

class SearchMapper implements SearchMapperInterface
{
    /**
     * {@inheritdoc}
     */
    public function getSearchModel()
    {
        return new Search();
    }

    /**
     * {@inheritdoc}
     */
    public function convertFromRequest(Request $request)
    {
        $search = $this->getSearchModel();
        $this->mapDefaultParams($request, $search);

        return $search;
    }

    /**
     * @param Request $request
     * @param SearchInterface $search
     */
    private function mapDefaultParams(Request $request, SearchInterface $search)
    {
        $params = [
            SearchInterface::PARAM_LIMIT => 'limit',
            SearchInterface::PARAM_OFFSET => 'offset',
            SearchInterface::PARAM_QUERY => 'query',
            SearchInterface::PARAM_BOOL_STRATEGY => 'boolStrategy',
            SearchInterface::PARAM_ORDER_BY => 'orderBy',
        ];

        foreach($params as $queryParam => $field) {
            if (!is_null($value = $request->get($queryParam))) {
                $method = 'set' . ucfirst($field);

                $search->{$method}($value);
            }
        }
    }
}
