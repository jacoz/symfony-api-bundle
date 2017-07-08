<?php

namespace Jacoz\Symfony\ApiBundle\Model;

use Jacoz\Symfony\ApiBundle\Model\Interfaces\SearchInterface;

class Search implements SearchInterface
{
    /**
     * @var integer
     */
    protected $limit;

    /**
     * @var integer
     */
    protected $offset;

    /**
     * @var string
     */
    protected $query;

    /**
     * @var string
     */
    protected $boolStrategy = SearchInterface::DEFAULT_BOOL_STRATEGY;

    /**
     * @var string
     */
    protected $orderBy;

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return integer
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param integer $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery($query)
    {
        $this->query = trim($query);
    }

    /**
     * @return string
     */
    public function getBoolStrategy()
    {
        return $this->boolStrategy;
    }

    /**
     * @param string $boolStrategy
     */
    public function setBoolStrategy($boolStrategy)
    {
        $this->boolStrategy = $boolStrategy;
    }

    /**
     * @return string
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return bool
     */
    public function hasFilters()
    {
        return !empty($this->query);
    }
}
