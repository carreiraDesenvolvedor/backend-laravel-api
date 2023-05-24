<?php

namespace App\Http\Controllers\API;

use App\Enums\ApiNewsEnum;
use App\Http\Controllers\Controller;
use App\Library\Api\News\NewsApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function find(Request $request){

        $page = $request->get('page', 1);
        $keywords = $request->get('keywords', []);
        $fromDate = $request->get('fromDate', date('Y-m-d'));
        $sources = $request->get('sources', []);

        $newsApiService = new NewsApiService($page, $keywords, $fromDate, $sources);

        return response()->json([
            'data'=>[
                'news-api'=>$newsApiService->fetchDataByStrategy(ApiNewsEnum::NewsApi),
                'the-guardian'=>$newsApiService->fetchDataByStrategy(ApiNewsEnum::TheGuardian),
                'new-your-times'=>$newsApiService->fetchDataByStrategy(ApiNewsEnum::NewYorkTimes)
            ]
        ]);
    }

}
