<?php

namespace App\Http\Controllers\API;

use App\Enums\ApiNewsEnum;
use App\Http\Controllers\Controller;
use App\Library\Api\News\NewsApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function find(Request $request): JsonResponse
    {

        $this->validateRequest($request, [
            'keywords' => 'required|string',
        ]);

        $page = $request->get('page', 1);
        $keywords = explode(',', $request->get('keywords', ''));
        $fromDate = $request->get('fromDate', date('Y-m-d', strtotime("-7 day")));
        $sources = $request->get('sources', []);

        $newsApiService = new NewsApiService($page, $keywords, $fromDate, $sources);

        return response()->json([
            'data' => $newsApiService->getArticles()
        ]);
    }

}