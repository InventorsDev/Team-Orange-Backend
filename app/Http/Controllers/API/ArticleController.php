<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    private $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }


    public function index(ArticleRequest $request)
    {

        $articles = $this->articleService->getArticles();

        return $this->successResponse('Articles retreived successfully', $articles);
    }
}
