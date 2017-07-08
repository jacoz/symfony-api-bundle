<?php
namespace Jacoz\Symfony\ApiBundle\Model\Interfaces;

interface SearchInterface
{
    const PARAM_LIMIT = 'limit';
    const PARAM_OFFSET = 'offset';
    const PARAM_QUERY = 'query';
    const PARAM_BOOL_STRATEGY = 'bool_strategy';
    const PARAM_ORDER_BY = 'order';

    const LIMIT = 25;

    const BOOL_STRATEGY_AND = 'AND';
    const BOOL_STRATEGY_OR = 'OR';
    const DEFAULT_BOOL_STRATEGY = self::BOOL_STRATEGY_AND;

    const DEFAULT_ORDER_DIRECTION = 'ASC';

    /**
     * @return int
     */
    public function getLimit();

    /**
     * @return integer
     */
    public function getOffset();

    /**
     * @return string
     */
    public function getQuery();

    /**
     * @return string
     */
    public function getBoolStrategy();

    /**
     * @return string
     */
    public function getOrderBy();

    /**
     * @return bool
     */
    public function hasFilters();
}
