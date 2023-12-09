<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class FrontendCategoryController extends Controller
{
    public function category($slug){
        $posts = Post::latest()
            ->where('status', true)
            ->with(['category:id,name,slug','user:id,name,profile'])
            ->whereHas('category', function($query) use($slug){
                $query->where('slug', $slug);
            })
            ->orwhereHas('subcategory', function($query) use($slug){
                $query->where('slug', $slug);
            })
            ->select(['id','user_id','category_id','slug','subcategory_id','title','featured_image','short_description','created_at'])
            ->paginate(8);

        $categories = Category::latest()
            ->withCount(['posts'])
            ->take(6)
            ->get();
        return view('frontend.category', compact('posts','categories'));
    }
}
