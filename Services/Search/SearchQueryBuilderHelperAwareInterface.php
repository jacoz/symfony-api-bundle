<?php

namespace Jacoz\Symfony\ApiBundle\Services\Search;

interface SearchQueryBuilderHelperAwareInterface
{
    /**
     * @return SearchQueryBuilderHelper
     */
    public function getSearchQueryBuilderHelper();

    /**
     * @param SearchQueryBuilderHelper $searchQueryBuilderHelper
     */
    public function setSearchQueryBuilderHelper(SearchQueryBuilderHelper $searchQueryBuilderHelper);
}
