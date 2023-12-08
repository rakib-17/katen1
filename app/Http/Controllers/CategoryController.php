<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //index page (listing page)
    public function index()
    {
        // $categories = Category::with('sub_categories')->get();
        $categories = Category::paginate(5);
        return view('bakend.category.list', compact('categories'));
    }

    //store (store new data)
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:100',
        ]);
        $category_slug = str($request->name)->slug();
        $slug_count = Category::where('slug','LIKE', '%'.$category_slug.'%')->count();
        if($slug_count > 0){
            $category_slug .= '-'.$slug_count + 1;
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $category_slug;
        $category-> save();
        return back();
    }

    //edit page (edit form)
    public function edit($id)
    {
        $categories = Category::paginate(5);
        $edit_data= Category::findOrFail($id, ['id', 'name']);
        return view('bakend.category.list', compact('categories','edit_data'));
    }

    //update (update single data)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=> 'required|string|max:100',
        ]);
        $category_slug = str($request->name)->slug();
        $slug_count = Category::where('slug','LIKE', '%'.$category_slug.'%')->count();
        if($slug_count > 0){
            $category_slug .= '-'.$slug_count + 1;
        }

        $category = Category::find($id);
        $category->name = $request->name;
        $category->slug = $category_slug;
        $category-> save();
        return back();
    }

    //delete (delete single data)
    public function delete($id)
    {
        $category_count = Category::count();
        if($category_count > 1){
            $category = Category::find($id);
            $category->delete();
            return back();
        }
        return back();
    }

}
