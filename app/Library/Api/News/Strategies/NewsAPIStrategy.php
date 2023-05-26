<?php

namespace App\Library\Api\News\Strategies;

use App\Enums\ApiNewsQueryFiltersEnum;
use App\Library\Api\News\QueryBuilder;
use App\Library\Api\News\TransformedArticle;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;

class NewsApiStrategy implements NewsStrategyInterface {

    public function getQueryBuilder(): QueryBuilder{
        return new QueryBuilder('page', 'q','from','source','pagesize','apiKey');
    }

    public function fetch(string $queryParms): array{

        $response = Http::get('https://newsapi.org/v2/everything?'.$queryParms);
        return $response->json();
    }


    public function getAuthKey(): string
    {
        return '5e5b74d55a4148bea24f7c00b1422c61';
    }

    public function transformResponse($response): array
    {
        if(Arr::get($response, 'status') !== 'ok')
            return [];

        $result = [];
        foreach(Arr::get($response, 'articles') as $article){
            $transformedArticle = new TransformedArticle();
            $transformedArticle->setSource(Arr::get($article, 'source.name'), Arr::get($article, 'source.id'));
            $transformedArticle->setAuthor(Arr::get($article, 'author'));
            $transformedArticle->setTitle(Arr::get($article, 'title'));
            $transformedArticle->setDescription(Arr::get($article, 'description'));
            $transformedArticle->setUrlArticle(Arr::get($article, 'url'));
            $transformedArticle->setUrlThumbnail(Arr::get($article, 'urlToImage'));
            $transformedArticle->setPublishedAt(Arr::get($article, 'publishedAt'));

            $result[] = $transformedArticle->__toArray();
        }

        return $result;
    }
}
