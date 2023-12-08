<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class FrontendHomeController extends Controller
{
    public function index()
    {
        $featured_posts = Post::latest()
            ->where('is_featured', true)
            ->where('status', true)
            ->with(['category:id,name,slug','user:id,name'])
            ->select(['id','title','user_id','category_id','created_at','featured_image'])
            ->take(3)
            ->get();

        $posts = Post::latest()
            ->where('status', true)
            ->with(['category:id,name,slug','user:id,name,profile'])
            ->select(['id','title','user_id','category_id','created_at','featured_image','short_description'])
            ->paginate(1);

        return view('frontend.index', compact('featured_posts','posts'));
    }

    // singel post show
    public function showPost($slug)
    {
        $post = Post::where('slug', $slug)
            ->with(['category:id,name,slug','user:id,name,profile'])
            ->first();
        return view('frontend.blog-single', compact('post'));
    }
}
