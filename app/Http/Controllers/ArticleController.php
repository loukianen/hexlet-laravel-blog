<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = \App\Models\Article::simplePaginate(5);
        return view('article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $article = new \App\Models\Article();
        return view('article.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->session()->flash('status', 'Проверьте правильность заполнения формы!');
        $this->validate($request, [
            'name' => 'required|unique:articles',
            'body' => 'required|min:10',
        ]);
        $article = new \App\Models\Article();
        $article->fill($request->all());
        $article->save();
        return redirect()
            ->route('articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $article = \App\Models\Article::findOrFail($article->id);
        return view('article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $article = \App\Models\Article::findOrFail($article->id);
        return view('article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request->session()->flash('status', 'Проверьте правильность заполнения формы!');
        $this->validate($request, [
            'name' => 'required|unique:articles,name,' . $article->id,
            'body' => 'required|min:10',
        ]);
        $article = \App\Models\Article::findOrFail($article->id);
        $article->fill($request->all());
        $article->save();
        return redirect()
            ->route('articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article = \App\Models\Article::find($article->id);
        if ($article) {
            $article->delete();
        }
        return redirect()
        ->route('articles.index');
    }
}
