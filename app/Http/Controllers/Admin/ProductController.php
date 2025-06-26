<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Article::with(['category'])
            ->select('id', 'title', 'price', 'category_id', 'created_at')
            ->withCount('comments')
            ->latest()
            ->paginate(10);
        
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        return view('admin.products.create', compact('categories', 'sizes'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|max:255',
                'body' => 'required',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'sizes' => 'nullable|array',
                'sizes.*' => 'exists:sizes,id'
            ]);

            // Create the article with the authenticated user
            $article = new Article();
            $article->title = $request->title;
            $article->body = $request->body;
            $article->price = $request->price;
            $article->category_id = $request->category_id;
            $article->user_id = auth()->id();

            if (!$article->save()) {
                return back()->with('error', 'Failed to save product')->withInput();
            }

            // Attach sizes if provided
            if ($request->has('sizes')) {
                $article->sizes()->attach($request->sizes);
            }

            // Handle photo uploads
            if ($request->hasFile('photos')) {
                $paths = [];
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('articles', 'public');
                    if ($path) {
                        $paths[] = $path;
                    }
                }
                if (!empty($paths)) {
                    $article->photos = json_encode($paths);
                    $article->save();
                }
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully');

        } catch (\Exception $e) {
            \Log::error('Product creation failed: ' . $e->getMessage());
            return back()
                ->with('error', 'Failed to create product: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $product = Article::findOrFail($id);
        $categories = Category::all();
        $sizes = Size::all();
        return view('admin.products.edit', compact('product', 'categories', 'sizes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $article = Article::findOrFail($id);
        $article->update($request->except('photos', 'sizes'));

        // Update sizes if provided
        if ($request->has('sizes')) {
            $article->sizes()->sync($request->sizes);
        } else {
            $article->sizes()->detach();
        }

        if ($request->hasFile('photos')) {
            $paths = [];
            foreach ($request->file('photos') as $photo) {
                $paths[] = $photo->store('articles', 'public');
            }
            $article->photos = json_encode($paths);
            $article->save();
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
} 