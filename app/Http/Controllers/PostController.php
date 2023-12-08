<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //create page
    public function index()
    {
        $posts = Post::with(['user:id,name','category:id,name'])
            ->latest()
            ->select(['id','title','user_id','category_id','featured_image','status','is_featured','created_at'])
            ->paginate(10);
        return view('bakend.post.list', compact('posts'));
    }

    //create page
    public function create()
    {
        $categories = Category::latest()->get(['id','name']);
        return view('bakend.post.create', compact('categories'));
    }

    // post stor page
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|string|max:255',
            'category'=>'required|exists:categories,id',
            'sub_category'=>'required|exists:subcategories,id',
            'short_description'=>'required|string|max:255',
            'description'=>'required|string',
            'featured_image'=>'required|mimes:jpg,png,jpeg,webp'
        ]);
        // Slug Generator
        $post_slug = str($request->title)->slug();
        $slug_count = Category::where('slug','LIKE', '%'.$post_slug.'%')->count();
        if($slug_count > 0){
            $post_slug .= '-'.$slug_count + 1;
        }

        // Featured Image Generator
        if($request->hasFile('featured_image')) {
            $featured_image = str()->random(10) .time().'.'.$request->featured_image->extension();
            $request->featured_image->storeAs('posts', $featured_image,'public');
        }

        $post= new Post();
        $post->title = $request->title;
        $post->slug = $post_slug;
        $post->user_id = auth()->id();
        $post->category_id = $request->category;
        $post->subcategory_id = $request->sub_category;
        $post->featured_image = $featured_image;
        $post->short_description = $request->short_description;
        $post->description = $request->description;
        $post->save();
        return back();
    }

    public function change_status(Request $request)
    {
        $post = Post::find($request->post_id);
        if($post->status) {
            $post->status = false;
        } else{
            $post->status = true;
        }
        $post->save();
    }
}
