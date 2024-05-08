<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;


class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }
    
    public function index()
    {
        $data = Article::latest()->paginate(5);

        return view('articles.index', [
            'articles' => $data
        ]);
    }

    public function detail($id)
    {
        $article = Article::find($id);

        return view("articles.detail", [
            'article' => $article
        ]);
    }

    public function delete($id)
    {
        $article = Article::find($id);
        if (Gate::allows('delete-article', $article)) {
            $article->delete();
            return redirect('/articles')->with('info', 'Deleted an article');
        }
        return back()->with('info', 'Unauthorize');
    }

    public function add()
    {
        $categories = Category::all();
        return view('/articles.add', ['categories' => $categories]);
    }

    public function create()
{
    $validator = validator(request()->all(), [
        'title' => 'required',
        'category_id' => 'required',
        "body" => "required",
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator);
    }

    try {
        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;

        $article->save();

        if (request()->hasFile('photo')) {
            $photo = request()->file('photo');
            $photoPath = 'articles'; 
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('public/' . $photoPath, $photoName);
            $article->photo = 'storage/' . $photoPath . '/' . $photoName;
            $article->save();
        }

        return redirect('/articles')->with('success', 'Article created successfully!');
    } catch (\Exception $e) {
        return back()->withErrors(['photo' => 'Error uploading photo: ' . $e->getMessage()]);
    }
}

    
    

    public function edit($id)
    {

        $article = Article::find($id);

        $categories = Category::all();

        return view('articles.update', [

            'article' => $article,

            'categories' => $categories,

        ]);
    }



    public function update(Request $request)    {

        $validator = validator(request()->all(), [

            'title' => 'required',

            'body' => 'required',

            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

            'category_id' => 'required',

        ]);

        if ($validator->fails()) back()->withErrors($validator);
        try {
            $article = Article::find($request->id);
            $article->title = $request->title;
            $article->body = $request->body;
            $article->category_id = $request->category_id;
    
            // Handle photo upload (if provided)
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoPath = 'articles'; // Set your desired storage path
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photo->storeAs('public/' . $photoPath, $photoName);
                $article->photo = 'storage/' . $photoPath . '/' . $photoName;
            }
    
            $article->save();
    
            return redirect('/articles')->with('success', 'Article updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['photo' => 'Error updating article: ' . $e->getMessage()]);
        }
    }
}