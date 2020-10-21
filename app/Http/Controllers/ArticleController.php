<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = \App\Models\Article::paginate(5);
        return view('article.index', compact('articles'));
    }

    public function create()
    {
        // Передаём в шаблон вновь созданный объект. Он нужен для вывода формы через Form::model
        $article = new \App\Models\Article();
        return view('article.create', compact('article'));
    }

    public function store(\App\Http\Requests\StoreArticle $request)
    {
        $request->session()->flash('status', 'Проверьте правильность заполнения формы!');
        // Проверка введённых данных
        // Если будут ошибки, то возникнет исключение
        // Иначе возвращаются данные формы
        $data = $this->validate($request, [
            'name' => 'required|unique:articles',
            'body' => 'required|min:10',
        ]);
        // $date = $request->validate();
        
        $article = new \App\Models\Article();
        // Заполнение статьи данными из формы
        $article->fill($data);
        // При ошибках сохранения возникнет исключение
        $article->save();

        // Редирект на указанный маршрут
        return redirect()
            ->route('articles.index');
    }

    public function show($id)
    {
        $article = \App\Models\Article::findOrFail($id);
        return view('article.show', compact('article'));
    }

    public function edit($id)
    {
        $article = \App\Models\Article::findOrFail($id);
        return view('article.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $request->session()->flash('status', 'Проверьте правильность заполнения формы!');
        $article = \App\Models\Article::findOrFail($id);
        $data = $this->validate($request, [
            // У обновления немного изменённая валидация. В проверку уникальности добавляется название поля и id текущего объекта
            // Если этого не сделать, Laravel будет ругаться на то что имя уже существует
            'name' => 'required|unique:articles,name,' . $article->id,
            'body' => 'required|min:10',
        ]);

        $article->fill($data);
        $article->save();
        return redirect()
            ->route('articles.index');
    }

    public function destroy($id)
    {
        // DELETE — идемпотентный метод, поэтому результат операции всегда один и тот же
        $article = \App\Models\Article::find($id);
        if ($article) {
            $article->delete();
        }
        return redirect()->route('articles.index');
    }
}
