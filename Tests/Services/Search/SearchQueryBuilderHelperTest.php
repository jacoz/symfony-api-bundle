<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Services\Search;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Jacoz\Symfony\ApiBundle\Model\Interfaces\SearchInterface;
use Jacoz\Symfony\ApiBundle\Model\Search;
use Jacoz\Symfony\ApiBundle\Services\Search\SearchQueryBuilderHelper;
use Jacoz\Symfony\ApiBundle\Tests\Models\CustomSearch;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class SearchQueryBuilderHelperTest extends TestCase
{
    /**
     * @var SearchQueryBuilderHelper
     */
    private $searchQueryBuilderHelper;

    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @var SearchInterface
     */
    private $search;

    public function setUp()
    {
        $this->queryBuilder = $this->getQueryBuilder();
        $this->queryBuilder->from('foo', 'f');

        $this->search = $this->getSearch();

        $this->searchQueryBuilderHelper = new SearchQueryBuilderHelper();
        $this->searchQueryBuilderHelper->setQueryBuilder($this->queryBuilder);
        $this->searchQueryBuilderHelper->setSearch($this->search);
    }

    /**
     * @return array
     */
    public function conditionsProvider()
    {
        return [
            [
                ['foo', 'bar'],
                null,
                [
                    'foo' => 'baz',
                    'bar' => 'doe',
                ],
                'f.foo = :foo ' . SearchInterface::DEFAULT_BOOL_STRATEGY . ' f.bar = :bar',
            ],
            [
                ['foo', 'bar'],
                SearchInterface::BOOL_STRATEGY_AND,
                [
                    'foo' => 'baz',
                    'bar' => 'doe',
                ],
                'f.foo = :foo ' . SearchInterface::BOOL_STRATEGY_AND . ' f.bar = :bar',
            ],
            [
                ['foo', 'bar'],
                SearchInterface::BOOL_STRATEGY_OR,
                [
                    'foo' => 'baz',
                    'bar' => 'doe',
                ],
                'f.foo = :foo ' . SearchInterface::BOOL_STRATEGY_OR . ' f.bar = :bar',
            ],
            [
                ['foo'],
                null,
                [
                    'foo' => 'baz',
                ],
                'f.foo = :foo',
            ],
        ];
    }

    /**
     * @param array $fields
     * @param string $boolStrategy
     * @param array $parameters
     * @param string $expectedValue
     *
     * @dataProvider conditionsProvider
     */
    public function testWhereConditions(array $fields, $boolStrategy, array $parameters, $expectedValue)
    {
        $search = $this->getCustomSearch();
        $search->setBoolStrategy($boolStrategy);
        foreach($parameters as $parameterKey => $parameterValue) {
            $search->{'set' . ucfirst($parameterKey)}($parameterValue);
        }

        $this->searchQueryBuilderHelper->setSearch($search);
        $this->searchQueryBuilderHelper->buildWhereQuery($fields);

        foreach($parameters as $parameterKey => $parameterValue) {
            $this->assertEquals($parameterValue, $this->queryBuilder->getParameter($parameterKey)->getValue());
        }

        $where = $this->queryBuilder->getDQLPart('where');
        $this->assertEquals($expectedValue, $where->__toString());
    }

    public function testEmptyWhereConditions()
    {
        $this->searchQueryBuilderHelper->buildWhereQuery();

        $where = $this->queryBuilder->getDQLPart('where');
        $this->assertEmpty($where);
    }

    /**
     * @return array
     */
    public function orderBysProvider()
    {
        return [
            ['id', 'f.id ' . SearchInterface::DEFAULT_ORDER_DIRECTION],
            ['id:ASC', 'f.id ASC'],
            ['id:DESC', 'f.id DESC'],
        ];
    }

    /**
     * @param string $orderBy
     * @param string $expectedValue
     *
     * @dataProvider orderBysProvider
     */
    public function testSorting($orderBy, $expectedValue)
    {
        $this->search->setOrderBy($orderBy);

        $this->searchQueryBuilderHelper->buildOrderByQuery();

        $orderBy = $this->queryBuilder->getDQLPart('orderBy');
        $this->assertEquals($expectedValue, $orderBy[0]->__toString());
    }

    public function testEmptySorting()
    {
        $this->searchQueryBuilderHelper->buildOrderByQuery();

        $orderBy = $this->queryBuilder->getDQLPart('orderBy');
        $this->assertEmpty($orderBy);
    }

    /**
     * @return array
     */
    public function limitsProvider()
    {
        return [
            [],
            [0],
            [0, null],
            [1, 1],
            [null, 1],
        ];
    }

    /**
     * @param integer $offset
     * @param integer $limit
     *
     * @dataProvider limitsProvider
     */
    public function testLimits($offset = null, $limit = null)
    {
        $this->search->setOffset($offset);
        $this->search->setLimit($limit);

        $this->searchQueryBuilderHelper->buildResultsLimitQuery();

        $this->assertSame($offset, $this->queryBuilder->getFirstResult());
        $this->assertSame($limit, $this->queryBuilder->getMaxResults());
    }

    /**
     * @return EntityManagerInterface
     */
    private function mockEntityManager()
    {
        $entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $entityManager;
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder()
    {
        return new QueryBuilder($this->mockEntityManager());
    }

    /**
     * @return Search
     */
    private function getSearch()
    {
        return new Search();
    }

    /**
     * @return CustomSearch
     */
    private function getCustomSearch()
    {
        return new CustomSearch();
    }
}
