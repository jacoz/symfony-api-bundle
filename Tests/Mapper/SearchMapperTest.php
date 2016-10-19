<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Mapper;

use Jacoz\Symfony\ApiBundle\Mapper\Interfaces\SearchMapperInterface;
use Jacoz\Symfony\ApiBundle\Mapper\SearchMapper;
use Jacoz\Symfony\ApiBundle\Model\Interfaces\SearchInterface;
use Jacoz\Symfony\ApiBundle\Model\Search;
use Jacoz\Symfony\ApiBundle\Tests\Models\CustomSearch;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;

class SearchMapperTest extends TestCase
{
    /**
     * @return array
     */
    public function searchProvider()
    {
        return [
            [
                new SearchMapper(),
                Search::class,
                new Request(),
                [],
            ],
            [
                new SearchMapper(),
                Search::class,
                new Request(
                    [
                        'limit' => '10',
                        'query' => 'foo',
                    ]
                ),
                [
                    'limit' => 10,
                    'query' => 'foo',
                    'offset' => null,
                ]
            ],
            [
                new CustomSearchMapper(),
                CustomSearch::class,
                new Request(
                    [
                        'offset' => '0',
                        'order' => 'id',
                        'foo' => 'bar',
                    ]
                ),
                [
                    'offset' => 0,
                    'orderBy' => 'id',
                    'foo' => 'bar',
                    'query' => null,
                ]
            ],
        ];
    }

    /**
     * @param SearchMapperInterface $searchMapper
     * @param string $searchModelClass
     * @param Request $request
     * @param array $values
     *
     * @dataProvider searchProvider
     */
    public function testMapping(SearchMapperInterface $searchMapper, $searchModelClass, Request $request, array $values)
    {
        $search = $searchMapper->convertFromRequest($request);

        $this->assertInstanceOf($searchModelClass, $search);

        foreach ($values as $key => $value) {
            $this->assertEquals($value, $this->getValue($search, $key));
        }
    }

    /**
     * @param SearchInterface $search
     * @param string $key
     * @return mixed
     */
    private function getValue(SearchInterface $search, $key)
    {
        $method = 'get' . ucfirst($key);

        return $search->{$method}();
    }
}

class CustomSearchMapper extends SearchMapper
{
    /**
     * {@inheritdoc}
     */
    public function convertFromRequest(Request $request)
    {
        $search = parent::convertFromRequest($request);

        if (!empty($foo = $request->get('foo'))) {
            $search->setFoo($foo);
        }

        return $search;
    }

    /**
     * @return CustomSearch
     */
    public function getSearchModel()
    {
        return new CustomSearch();
    }
}
