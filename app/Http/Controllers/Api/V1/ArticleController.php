<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ArticleResource::collection(
            Article::with(['author'])->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleStoreRequest $request)
    {
        $article = auth('sanctum')->user()->articles()->create(
            $request->validated()
        );

        return ArticleResource::make($article);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return ArticleResource::make(
            Article::with('author')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleUpdateRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        $article->update($request->validated());

        return ArticleResource::make($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();

        return response()->noContent();
    }
}
