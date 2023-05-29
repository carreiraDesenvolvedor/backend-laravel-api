<?php

namespace App\Library\Api\News\Strategies;

use App\Library\Api\News\TransformedArticle;
use Illuminate\Support\Arr;

class NewsAPIStrategy extends  AbstractApiStrategy {

    public function getAuthKey(): string
    {
        return '5e5b74d55a4148bea24f7c00b1422c61';
    }

    /**
     * @param $response
     * @return TransformedArticle[]
     */
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
    public function getPageQueryKey(): string
    {
        return 'page';
    }

    public function getKeywordQueryKey(): string
    {
        return 'q';
    }

    public function getFromDateQueryKey(): string
    {
        return 'from';
    }

    public function getSourceQueryKey(): string
    {
        return 'source';
    }

    public function getPageSizeQueryKey(): string
    {
        return 'pagesize';
    }

    public function getApiAuthQueryKey(): string
    {
        return 'apiKey';
    }

    public function getEndpointURL(): string
    {
        return 'https://newsapi.org/v2/everything';
    }
}
