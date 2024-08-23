<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{

    public function index()
    {
        $blogCategory = BlogCategory::all();
        return $blogCategory;
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required|string',
        ]);

        $blogCategory = BlogCategory::create([
            "name" => $request->name,
        ]);
        $response = [
            "blogCategory" => $blogCategory,
            "message" => "BlogCategory added successfully.",
        ];
        return response($response, 201);
    }

    public function show($id)
    {
        $blogCategory = BlogCategory::find($id);
        return $blogCategory;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => 'required|string',
        ]);
        $blogCategory = BlogCategory::find($id);
        $blogCategory->update([
            "name" => $request->name,
        ]);

        $response = [
            "blogCategory" => $blogCategory,
            "message" => "BlogCategory updated successfully.",
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $blogCategory = BlogCategory::find($id);
        $blogCategory->delete();
        $response = [
            "message" => "BlogCategory deleted successfully.",
        ];
        return response($response, 201);
    }
}
