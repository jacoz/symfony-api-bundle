<?php

namespace Jacoz\Symfony\ApiBundle\Services\Search;

trait SearchQueryBuilderHelperTrait
{
    /**
     * @var SearchQueryBuilderHelper
     */
    protected $searchQueryBuilderHelper;

    /**
     * @return SearchQueryBuilderHelper
     */
    public function getSearchQueryBuilderHelper()
    {
        return $this->searchQueryBuilderHelper;
    }

    /**
     * @param SearchQueryBuilderHelper $searchQueryBuilderHelper
     */
    public function setSearchQueryBuilderHelper(SearchQueryBuilderHelper $searchQueryBuilderHelper)
    {
        $this->searchQueryBuilderHelper = $searchQueryBuilderHelper;
    }
}
