<?php

namespace App\Library\Api\News;


use App\Enums\ApiNewsEnum;

class QueryBuilder {

    const PAGE_SIZE = 10;

    private string $pageKey;
    private string $keywordKey;

    private string $fromDateKey;

    private string $sourceKey;

    private string $pageSizeKey;

    private string $apiAuthKey;



    public function __construct(string $pageKey, string $keywordKey, string $fromDateKey, string $sourceKey,string $pageSizeKey, string $apiAuthKey)
    {
        $this->pageKey = $pageKey;
        $this->keywordKey = $keywordKey;
        $this->fromDateKey = $fromDateKey;
        $this->sourceKey = $sourceKey;
        $this->pageSizeKey = $pageSizeKey;
        $this->apiAuthKey = $apiAuthKey;
    }


    public function buildQuery(int $page, array $keywords, string $fromDate, array $sources, string $apiAuthKey, ApiNewsEnum $apiNewsStrategy ): string{

        $queryParms = [
            $this->pageSizeKey =>self::PAGE_SIZE,
            $this->apiAuthKey => $apiAuthKey
        ];

        if($page){
            $queryParms[$this->pageKey] = $page;
        }
        if($keywords){
            $queryParms[$this->keywordKey] = implode('AND', $keywords);
        }
        if($fromDate){
            $queryParms[$this->fromDateKey] = $fromDate;
        }
        if($sources){
            $queryParms[$this->sourceKey] = $sources;
        }

        return http_build_query($queryParms);

    }


}
