<?php

namespace App\Library\Api\News\Strategies;

use App\Library\Api\News\QueryBuilder;
use App\Library\Api\News\TransformedArticle;

interface NewsStrategyInterface {

    /**
     * @param int $page
     * @param array $keywords
     * @param string $fromDate
     * @param array $sources
     * @return TransformedArticle[]
     */
    public function fetch(int $page, array $keywords, string $fromDate, array $sources): array;

    public function getQueryBuilder():QueryBuilder;

    public function getAuthKey(): string;

    public function transformResponse($response): array;

    public function getPageQueryKey():string;

    public function getKeywordQueryKey():string;

    public function getFromDateQueryKey():string;

    public function getSourceQueryKey():string;

    public function getPageSizeQueryKey():string;

    public function getApiAuthQueryKey():string;

    public function getEndpointURL():string;

    public function getExtraQueryParms():string;

    public function buildKeywordsQueryParms(array $keywords):string;

}
