<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = \App\Models\Article::paginate(2);
        return view('article.index', compact('articles'));
    }

    public function show($id)
    {
        $article = \App\Models\Article::findOrFail($id);
        return view('article.show', compact('article'));
    }
}
