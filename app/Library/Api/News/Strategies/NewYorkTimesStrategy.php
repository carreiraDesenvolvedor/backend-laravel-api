<?php

namespace App\Library\Api\News\Strategies;

use App\Library\Api\News\QueryBuilder;
use Illuminate\Support\Facades\Http;

class NewYorkTimesStrategy implements NewsStrategyInterface {
    public function getQueryBuilder(): QueryBuilder{
        return new QueryBuilder('page', 'q','from-date','','page-size','api-key');
    }
    public function fetch(string $queryParms): array
    {
        $response = Http::get('https://api.nytimes.com/svc/search/v2/articlesearch.json?&api-key='.$this->getAuthKey());
        return $response->json();
    }

    public function getAuthKey(): string
    {
        return 'YQPibSFfSHo0cqzlQVe09N0PAmKba67c';
    }
}
