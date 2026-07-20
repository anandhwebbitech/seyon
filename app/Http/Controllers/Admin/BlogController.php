<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\BlogCategory;
use App\Models\BlogSubCategory;
use App\Models\Blog;


class BlogController extends Controller
{
    
    
    //   category

   public function blogCategory(Request $request)
   {
       $category = BlogCategory::latest()->get();
       return view('admin.blog.category.index',compact('category'));
   }
   
   
   public function blogCategoryAdd(Request $request)
    {
        $blogCategory       = new BlogCategory();
        $blogCategory->name = $request['name'];
        
        $blogCategory->save();

        return response()->json(['message' => 'Blog category added successfully']);
    }
    
    
   public function blogCategoryEdit($id)
   {
        $category = BlogCategory::findOrFail($id);
        // print_r($category); exit();
        return view('admin.modal.edit_category_modal', compact('category'));
    }

   public function blogCategoryUpdate(Request $request)
   {
        $category = BlogCategory::findOrFail($request->id);
        $category->name = $request->name;
        $category->save();

        return response()->json(['success' => true, 'message' => 'Category updated successfully']);
    }
    
    
   //   sub category

   public function blogSubCategory(Request $request)
   {
       $subcategory = BlogSubCategory::latest()->get();
       return view('admin.blog.sub_category.index',compact('subcategory'));
   }
   
   
   public function blogSubCategoryAdd(Request $request)
    { 
        // print_r($request['category_id']); exit();
        $blogCategory       = new BlogSubCategory();
        $blogCategory->name = $request['name'];
        $blogCategory->category_id = $request['category_id'];
        
        $blogCategory->save();

        return response()->json(['message' => 'Blog sub category added successfully']);
    }
    
    
   public function blogSubCategoryEdit($id)
   {
        $category = BlogSubCategory::findOrFail($id);
        return view('admin.modal.edit_subcategory_modal', compact('category'));
    }

   public function blogSubCategoryUpdate(Request $request)
   {
        $category = BlogSubCategory::findOrFail($request->id);
        $category->name = $request->name;
        $category->category_id = $request->category_id;
        $category->save();

        return response()->json(['success' => true, 'message' => 'Sub category updated successfully']);
    }
    
    
    // Blog
    
   public function blog(Request $request)
   {
       $blogs = Blog::latest()->get();
       return view('admin.blog.index',compact('blogs'));
   }
    
   public function blogAdd(Request $request)
   {
       $category = BlogCategory::latest()->get();
       $subcategory = BlogSubCategory::latest()->get();
       
       return view('admin.blog.add',compact('category','subcategory'));
   }
    
   
}   