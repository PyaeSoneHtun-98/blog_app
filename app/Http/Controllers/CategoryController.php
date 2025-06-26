<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::all();
        return view('categories.index', [
            'categories' => $categories
        ]);
    }

    public function add()
    {
        return view('categories.add');
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            'name' => 'required|unique:categories|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $category = new Category;
        $category->name = request()->name;
        $category->save();

        return redirect('/categories')->with('info', 'Category created successfully!');
    }

    public function delete($id)
    {
        $category = Category::find($id);
        
        // Check if category has articles
        if ($category->articles()->count() > 0) {
            return back()->with('error', 'Cannot delete category that has articles');
        }

        $category->delete();
        return redirect('/categories')->with('info', 'Category deleted successfully');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit', ['category' => $category]);
    }

    public function update($id)
    {
        $validator = validator(request()->all(), [
            'name' => 'required|unique:categories,name,' . $id . '|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $category = Category::find($id);
        $category->name = request()->name;
        $category->save();

        return redirect('/categories')->with('info', 'Category updated successfully!');
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails()) {
            return back()->with('info', 'Name required');
        }

        $category = new Category;
        $category->name = $request->name;
        $category->save();

        return back()->with('info', 'Category added successfully');
    }
} 