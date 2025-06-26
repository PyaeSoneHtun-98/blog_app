<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Comment::with(['article:id,title', 'user:id,name'])
            ->select('id', 'article_id', 'user_id', 'content', 'created_at')
            ->latest()
            ->paginate(10);
        
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy($id)
    {
        $review = Comment::findOrFail($id);
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully');
    }
} 