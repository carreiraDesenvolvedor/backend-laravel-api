<?php

namespace App\Library\Api\News\Strategies;

use App\Library\Api\News\QueryBuilder;
use App\Library\Api\News\TransformedArticle;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class NewYorkTimesStrategy extends AbstractApiStrategy {

    public function getEndpointURL(): string
    {
        return 'https://api.nytimes.com/svc/search/v2/articlesearch.json';
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
        return 'pub_date';
    }

    public function getSourceQueryKey(): string
    {
        return 'fq';
    }

    public function getPageSizeQueryKey(): string
    {
        return '';
    }

    public function getApiAuthQueryKey(): string
    {
        return 'api-key';
    }

    public function buildKeywordsQueryParms(array $keywords): string
    {
        return implode(',', $keywords);
    }
}
