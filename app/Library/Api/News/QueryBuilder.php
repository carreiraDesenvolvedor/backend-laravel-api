<?php

namespace App\Library\Api\News;


use App\Enums\ApiNewsEnum;
use App\Library\Api\News\Strategies\AbstractApiStrategy;

class QueryBuilder {

    const PAGE_SIZE = 10;

    private AbstractApiStrategy $_apiStrategy;

    private string $pageKey;
    private string $keywordKey;

    private string $fromDateKey;

    private string $sourceKey;

    private string $pageSizeKey;

    private string $apiAuthKey;



    public function __construct(AbstractApiStrategy $apiStrategy)
    {
        $this->_apiStrategy = $apiStrategy;
    }


    public function buildQuery(int $page, array $keywords, string $fromDate, array $sources): string{

        $query = [
            $this->_apiStrategy->getPageQueryKey() =>self::PAGE_SIZE,
            $this->_apiStrategy->getApiAuthQueryKey() => $this->_apiStrategy->getAuthKey()
        ];

        if($page){
            $query[$this->_apiStrategy->getPageQueryKey()] = $page;
        }
        if($keywords){
            $query[$this->_apiStrategy->getKeywordQueryKey()] = $this->_apiStrategy->buildKeywordsQueryParms($keywords);
        }
        if($fromDate){
            $query[$this->_apiStrategy->getFromDateQueryKey()] = $fromDate;
        }
        if($sources){
            $query[$this->_apiStrategy->getSourceQueryKey()] = $sources;
        }

        return http_build_query($query);

    }


}
