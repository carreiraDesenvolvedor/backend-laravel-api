<?php

namespace App\Library\Api\News\Strategies;

use App\Library\Api\News\QueryBuilder;
use App\Library\Api\News\TransformedArticle;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class NewYorkTimesStrategy implements NewsStrategyInterface {
    public function getQueryBuilder(): QueryBuilder{
        return new QueryBuilder('page', 'q','from-date','','page-size','api-key');
    }
    public function fetch(string $queryParms): array
    {
        //"https://api.nytimes.com/svc/search/v2/articlesearch.json?page-size=10&api-key=YQPibSFfSHo0cqzlQVe09N0PAmKba67c&page=1&q=brazil&from-date=2023-05-01" // app/Library/Api/News/Strategies/NewYorkTimesStrategy.php:16
        $response = Http::get('https://api.nytimes.com/svc/search/v2/articlesearch.json?'.$queryParms);
        return $response->json();
    }

    public function getAuthKey(): string
    {
        return 'YQPibSFfSHo0cqzlQVe09N0PAmKba67c';
    }
    public function transformResponse($response): array
    {
        if(Arr::get($response, 'status') !== 'OK')
            return [];
        $result = [];
        foreach(Arr::get($response, 'response.docs') as $article){

            $transformedArticle = new TransformedArticle();
            $transformedArticle->setSource(Arr::get($article, 'source'));
            $transformedArticle->setAuthor(Arr::get($article, 'byline.original'));
            $transformedArticle->setTitle(Arr::get($article, 'headline.main'));
            $transformedArticle->setDescription(Arr::get($article, 'lead_paragraph'));
            $transformedArticle->setUrlArticle(Arr::get($article, 'web_url'));
            $transformedArticle->setPublishedAt(Arr::get($article, 'pub_date'));

            $result[] = $transformedArticle->__toArray();

        }

        return $result;
    }
}
