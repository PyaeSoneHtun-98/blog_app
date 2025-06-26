<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
        $this->middleware('role_or_permission:admin|editor|create articles')->only(['add', 'create']);
        $this->middleware('role_or_permission:admin|editor|edit articles')->only(['edit', 'update']);
        $this->middleware('role_or_permission:admin|editor|delete articles')->only('delete');
    }

    public function index(Request $request)
    {
        $query = Article::latest();

        // Apply price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $data = $query->paginate(8)->withQueryString();

        return view('articles.index', [
            'articles' => $data
        ]);
    }

    public function detail($id)
    {
        $article = Article::find($id);
        
        if (!$article) {
            return back()->with('error', 'Article not found');
        }

        return view('articles.detail', [
            'article' => $article
        ]);
    }

    public function add()
    {
        $categories = Category::all();
        return view('articles.add', ['categories' => $categories]);
    }

    public function create(Request $request)
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->price = request()->price;
        $article->user_id = auth()->id();

        // Handle multiple photos
        if($request->hasFile('photos')) {
            $paths = [];
            foreach($request->file('photos') as $photo) {
                $filename = time() . '_' . $photo->getClientOriginalName();
                $path = $photo->storeAs('articles', $filename, 'public');
                $paths[] = $path;
            }
            $article->photos = json_encode($paths);
        }

        $article->save();

        return redirect('/')->with('info', 'Article created successfully');
    }

    public function delete($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return back()->with('error', 'Article not found');
        }

        // Check if user owns the article or has admin/editor role
        if ($article->user_id == auth()->id() || auth()->user()->hasRole(['admin', 'editor'])) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $article->delete();
            return redirect()->route('articles.index')->with('info', 'Article deleted successfully');
        }

        return back()->with('error', 'You do not have permission to delete this article');
    }

    public function edit($id)
    {
        $article = Article::find($id);
        $categories = Category::all();

        if (!$article) {
            return back()->with('error', 'Article not found');
        }

        // Check if user owns the article or has admin/editor role
        if ($article->user_id == auth()->id() || auth()->user()->hasRole(['admin', 'editor'])) {
            return view('articles.edit', [
                'article' => $article,
                'categories' => $categories
            ]);
        }

        return back()->with('error', 'You do not have permission to edit this article');
    }

    public function update(Request $request)
    {
        $validator = validator($request->all(), [
            'id' => 'required|exists:articles,id',
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = Article::find($request->id);

        if (!$article) {
            return back()->with('error', 'Article not found');
        }

        // Check if user owns the article or has admin/editor role
        if ($article->user_id != auth()->id() && !auth()->user()->hasRole(['admin', 'editor'])) {
            return back()->with('error', 'You do not have permission to edit this article');
        }

        try {
            $article->title = $request->title;
            $article->body = $request->body;
            $article->category_id = $request->category_id;
            $article->price = $request->price;

            if($request->hasFile('photos')) {
                $paths = [];
                foreach($request->file('photos') as $photo) {
                    $filename = time() . '_' . $photo->getClientOriginalName();
                    $path = $photo->storeAs('articles', $filename, 'public');
                    $paths[] = $path;
                }
                $article->photos = json_encode($paths);
            }

            $article->save();
            return redirect('/')->with('info', 'Article updated successfully');        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error updating article: ' . $e->getMessage()]);
        }
    }
}