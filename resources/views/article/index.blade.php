@extends('layouts.app')

@section('content')
    <h1>Список статей</h1>
    @foreach ($articles as $article)
        <h2><a href="{{route('articles.show', $article)}}">{{$article->name}}</a></h2>
        {{-- Str::limit – функция-хелпер, которая обрезает текст до указанной длины --}}
        {{-- Используется для очень длинных текстов, которые нужно сократить --}}
        <div>{{Str::limit($article->body, 200)}}</div>
        <small><a href="{{route('articles.edit', $article)}}">Редактировать статью</a></small>
        <small><a href="{{route('articles.destroy', $article)}}" data-confirm="Вы уверены?" data-method="delete" rel="nofollow">Удалить</a></small>
    @endforeach
    <br>
    <div>
        {{ Form::open(['url' => route('articles.create'), 'method' => 'get']) }}
            {{ Form::submit('Создать новую статью') }}
        {{ Form::close() }}
    </div>
    <br>
    <div class="container mt-4">
        {{ $articles->links() }}
    </div>
@endsection