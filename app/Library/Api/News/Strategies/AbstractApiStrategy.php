<?php

namespace App\Library\Api\News\Strategies;

use App\Library\Api\News\QueryBuilder;
use Illuminate\Support\Facades\Http;

abstract class AbstractApiStrategy implements NewsStrategyInterface
{
    protected ?QueryBuilder $_queryBuilder = null;

    public function getQueryBuilder(): QueryBuilder{
        if(!$this->_queryBuilder){
            $this->_queryBuilder = new QueryBuilder($this);
        }
        return $this->_queryBuilder;
    }
    public function fetch(int $page, array $keywords, string $fromDate, array $sources): array
    {
        $endpoint = $this->getEndpointURL();
        $endpoint.='?';
        $endpoint.=$this->getQueryBuilder()->buildQuery($page, $keywords, $fromDate, $sources);
        $endpoint.=$this->getExtraQueryParms();
        return $this->transformResponse(Http::get($endpoint)->json());
    }

    public function getExtraQueryParms(): string{
        return '';
    }

    public function buildKeywordsQueryParms(array $keywords): string
    {
        return implode('OR', $keywords);
    }
}
