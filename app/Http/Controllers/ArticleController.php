<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $articles = Article::with('user', 'tags')->latest()->paginate(10);

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = $this->getCategories();
        $tags = $this->getTags();

        return view('articles.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request): RedirectResponse
    {
        $article = Article::create(
            $request->validated() +
            [
                'user_id' => auth()->user()->id,
                'slug' => Str::slug($request->title)
            ]
        );

        $article->tags()->attach($request->tags);

        return redirect(route('dashboard'))->with('message', 'Article has been successfully been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): View
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = $this->getCategories();
        $tags = $this->getTags();
        return view('articles.edit', compact('article', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        $article->update(
            $request->validated() +
            [
                'slug' => Str::slug($request->title)
            ]
        );

        $article->tags()->sync($request->tags);

        return redirect(route('dashboard'))->with('message', 'Article has been successfully been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();
        return redirect(route('dashboard'))->with('message', 'Article has been successfully been deleted.');
    }

    private function getCategories(): array
    {
        return Category::pluck('name', 'id')->toArray();
    }

    private function getTags(): array
    {
        return Tag::pluck('name', 'id')->toArray();
    }

}
