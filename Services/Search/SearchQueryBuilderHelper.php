<?php

namespace Jacoz\Symfony\ApiBundle\Services\Search;

use Doctrine\ORM\QueryBuilder;
use Jacoz\Symfony\ApiBundle\Model\Interfaces\SearchInterface;

class SearchQueryBuilderHelper
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @var SearchInterface
     */
    private $search;

    /**
     * @var string
     */
    private $orderBy;

    /**
     * @var array
     */
    private $orderByParts;

    /**
     * @param QueryBuilder $queryBuilder
     * @return $this
     */
    public function setQueryBuilder(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;

        return $this;
    }

    /**
     * @param SearchInterface $search
     * @return $this
     */
    public function setSearch(SearchInterface $search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * @param array $whereFields
     * @return $this
     */
    public function buildQuery(array $whereFields = [])
    {
        $this->buildWhereQuery($whereFields);
        $this->buildOrderByQuery();
        $this->buildResultsLimitQuery();

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function buildWhereQuery(array $fields = [])
    {
        if (empty($fields)) {
            return $this;
        }

        $alias = $this->getAlias();

        $whereMethod = $this->getDoctrineMethodNameByBoolStrategy();

        foreach($fields as $field) {
            $itemSearchMethodName = 'get' . ucfirst($field);

            $value = $this->search->{$itemSearchMethodName}();
            if (is_null($value)) {
                continue;
            }

            $this->queryBuilder
                ->{$whereMethod}($alias . '.' . $field . ' = :' . $field)
                ->setParameter($field, $value)
            ;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function buildOrderByQuery()
    {
        if ($this->orderBy = $this->search->getOrderBy()) {
            $alias = $this->getAlias();

            $this->queryBuilder->orderBy(
                $alias . '.' . $this->getOrderField(),
                $this->getOrderDirection())
            ;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function buildResultsLimitQuery()
    {
        if (!is_null($this->search->getOffset())) {
            $this->queryBuilder->setFirstResult($this->search->getOffset());
        }

        if (!is_null($this->search->getLimit())) {
            $this->queryBuilder->setMaxResults($this->search->getLimit());
        }

        return $this;
    }

    /**
     * @return string
     */
    private function getDoctrineMethodNameByBoolStrategy()
    {
        $methods = [
            SearchInterface::BOOL_STRATEGY_AND => 'andWhere',
            SearchInterface::BOOL_STRATEGY_OR => 'orWhere',
        ];

        if (!isset($methods[$this->search->getBoolStrategy()])) {
            return $methods[SearchInterface::DEFAULT_BOOL_STRATEGY];
        }

        return $methods[$this->search->getBoolStrategy()];
    }

    /**
     * @return array|null
     */
    private function getOrderByParts()
    {
        if (!empty($this->orderBy) && !empty($this->orderByParts)) {
            return $this->orderByParts;
        }

        return $this->orderByParts = explode(':', $this->orderBy);
    }

    /**
     * @return string|null
     */
    private function getOrderField()
    {
        return ($parts = $this->getOrderByParts()) ? $parts[0] : null;
    }

    /**
     * @return string|null
     */
    private function getOrderDirection()
    {
        return ($parts = $this->getOrderByParts()) ? (isset($parts[1]) ? $parts[1] : SearchInterface::DEFAULT_ORDER_DIRECTION) : null;
    }

    /**
     * @return string
     */
    private function getAlias()
    {
        return $this->queryBuilder->getRootAliases()[0];
    }
}
