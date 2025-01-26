<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }
    
    public function index()
    {
        $data = Article::latest()->paginate(8);
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
            return redirect('/article')->with('info', 'Deleted a product');
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
        "price" => "required",
        'photos.*' => 'required|image|mimes:jpg,jpeg,png,gif,webp',
    ], [
        'photos.*.required' => 'Please upload an image.',
        'photos.*.image' => 'The photos field must be an image.',
        'photos.*.mimes' => 'Only jpeg, png, jpg, and gif images are allowed.',
        'photos.*.max' => 'The image size must not exceed 2MB.',
    ]);
    if ($validator->fails()) {
        return back()->withErrors($validator);
    }

    try {
        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->price = request()->price;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;

        $article->save();

        if (request()->hasFile('photos')) {
            $photos = request()->file('photos');
            $photoUrls = [];

            foreach ($photos as $photo) {
                $photoPath = 'articles';
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photo->storeAs('public/' . $photoPath, $photoName);
                $photoUrls[] = 'storage/' . $photoPath . '/' . $photoName;
            }

            $article->photos = json_encode($photoUrls); 
        }

        $article->save();
        return redirect('/article')->with('info', 'Product created successfully!');
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



    public function update(Request $request)
    {
      $validator = validator(request()->all(), [
        'title' => 'required',
        'body' => 'required',
        'price' => 'required',
        'category_id' => 'required',
        'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
      ], [
        'photos.*.image' => 'The photos field must be an image.',
        'photos.*.mimes' => 'Only jpeg, png, jpg, webp and gif images are allowed.',
      ]);
    
      if ($validator->fails()) {
        return back()->withErrors($validator);
      }
    
      try {
        $article = Article::find($request->id);
        $article->title = $request->title;
        $article->body = $request->body;
        $article->price = $request->price;
        $article->category_id = $request->category_id;
    
        $previousPhotoPath = $article->photos;
        $photoUrls = []; 
    
        if ($request->hasFile('photos')) {
          $photos = $request->file('photos');
    
          foreach ($photos as $photo) {
            $photoPath = 'articles';
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('public/' . $photoPath, $photoName);
            $photoUrls[] = 'storage/' . $photoPath . '/' . $photoName;
          }
        } else {
          if ($previousPhotoPath) {
            $photoUrls = json_decode($previousPhotoPath, true);
          }
        }
    
        $article->photos = json_encode($photoUrls, JSON_UNESCAPED_UNICODE);
        $article->save();
    
        if ($request->hasFile('photos') && $previousPhotoPath) {
          $previousPhotos = json_decode($previousPhotoPath, true);
          foreach ($previousPhotos as $photoPath) {
            Storage::delete(str_replace('storage/', '', $photoPath));
          }
        }
    
        return redirect('/article')->with('info', 'Product updated successfully!');
      } catch (\Exception $e) {
        return back()->withErrors(['photo' => 'Error updating product: ' . $e->getMessage()]);
      }
    }
     
    
}