<?php

namespace App\Library\Api\News\Strategies;

use Illuminate\Support\Facades\Http;

class NewYorkTimesStrategy implements NewsStrategyInterface {
    public function fetch(): array
    {
        $response = Http::get('https://api.nytimes.com/svc/search/v2/articlesearch.json?&api-key='.$this->getAuthKey());
        return $response->json();
    }

    public function getAuthKey(): string|null
    {
        return 'YQPibSFfSHo0cqzlQVe09N0PAmKba67c';
    }
}
