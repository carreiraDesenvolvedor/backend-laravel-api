<?php

namespace App\Library\Api\News\Strategies;

use App\Library\Api\News\QueryBuilder;
use App\Library\Api\News\TransformedArticle;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class TheGuardianStrategy implements NewsStrategyInterface
{

    public function getQueryBuilder(): QueryBuilder{
        return new QueryBuilder('page', 'q','from-date','','page-size','api-key');
    }
    public function fetch(string $queryParms): array
    {
        $response = Http::get('https://content.guardianapis.com/search?'.$queryParms.$this->getExtraQueryParms());
        return $response->json();
    }

    public function getAuthKey(): string
    {
        return 'e6478f0e-980d-4e93-9be3-7303e286a36d';
    }

    public function transformResponse($response): array
    {
        if(Arr::get($response, 'response.status') !== 'ok')
            return [];

        $result = [];
        foreach(Arr::get($response, 'response.results') as $article){
            $transformedArticle = new TransformedArticle();
            $transformedArticle->setSource(Arr::get($article, 'fields.publication'));
            $transformedArticle->setTitle(Arr::get($article, 'webTitle'));
            $transformedArticle->setDescription(Arr::get($article, 'fields.body'));
            $transformedArticle->setUrlArticle(Arr::get($article, 'apiUrl'));
            $transformedArticle->setUrlThumbnail(Arr::get($article, 'fields.thumbnail'));
            $transformedArticle->setPublishedAt(Arr::get($article, 'webPublicationDate'));

            $result[] = $transformedArticle->__toArray();
        }

        return $result;
    }

    public function getExtraQueryParms(): string{
        return '&'.http_build_query([
            'show-fields'=>'thumbnail,publication,body'
        ]);
    }
}
