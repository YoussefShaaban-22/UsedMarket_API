<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blog = Blog::all();
        return $blog;
    }
    public function newBlog()
    {
        $blog = Blog::orderBy('created_at', 'desc')->take(10)->get();
        return $blog;
    }
    public function getBlogsByCategories(Request $request)
    {
        $categoryIds = $request->input('categories');
        if (empty($categoryIds)) {
            return Blog::all();
        }
        return Blog::whereIn('blog_category_id', $categoryIds)->get();
    }
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        $file = $request->file('file');
        $filePath = 'uploads/';
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path($filePath), $fileName);
        return response()->json(['path' => asset($filePath . $fileName)]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required|string',
            'blog_category_id' => 'required',
            'image' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'slug' => 'required',
            'status' => 'required',
            'top_blog' => 'required',
        ]);

        $blog = Blog::create([
            "name" => $request->name,
            "blog_category_id" => $request->blog_category_id,
            "image" => $request->image,
            "short_description" => $request->short_description,
            "description" => $request->description,
            "slug" => $request->slug,
            "status" => $request->status,
            "top_blog" => $request->top_blog,
        ]);
        $response = [
            "blog" => $blog,
            "message" => "Blog added successfully.",
        ];
        return response($response, 201);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        return $blog;
    }
    public function showById($id)
    {
        $blog = Blog::find($id);
        return $blog;
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => 'required|string',
            'blog_category_id' => 'required',
            'image' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'slug' => 'required',
            'status' => 'required',
            'top_blog' => 'required',
        ]);
        $blog = Blog::find($id);
        $blog->update([
            "name" => $request->name,
            "blog_category_id" => $request->blog_category_id,
            "image" => $request->image,
            "short_description" => $request->short_description,
            "description" => $request->description,
            "slug" => $request->slug,
            "status" => $request->status,
            "top_blog" => $request->top_blog,
        ]);

        $response = [
            "blog" => $blog,
            "message" => "Blog updated successfully.",
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        $response = [
            "message" => "Blog deleted successfully.",
        ];
        return response($response, 201);
    }
}
