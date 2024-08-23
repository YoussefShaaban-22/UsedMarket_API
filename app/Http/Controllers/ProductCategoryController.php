<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        // $ProductCategory = ProductCategory::all();
        $categories = ProductCategory::with('parent')->get();
        return response()->json($categories);
        // return $ProductCategory;
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required|string',
            "image" => 'required',
            "description" => 'required',
            "parent_id" => 'required',
            "slug" => 'required',
        ]);

        $ProductCategory = ProductCategory::create([
            "name" => $request->name,
            "image" => $request->image,
            "description" => $request->description,
            "parent_id" => $request->parent_id,
            "slug" => $request->slug,
        ]);
        $response = [
            "ProductCategory" => $ProductCategory,
            "message" => "ProductCategory added successfully.",
        ];
        return response($response, 201);
    }

    public function showByID($id)
    {
        $ProductCategory = ProductCategory::find($id);
        return $ProductCategory;
    }
    public function showBySlug($slug)
    {
        $ProductCategory = ProductCategory::where('slug', $slug)->first();
        return $ProductCategory;
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => 'required|string',
            "image" => 'required',
            "description" => 'required',
            "parent_id" => 'required',
            "slug" => 'required',
        ]);
        $ProductCategory = ProductCategory::find($id);
        $ProductCategory->update([
            "name" => $request->name,
            "image" => $request->image,
            "description" => $request->description,
            "parent_id" => $request->parent_id,
            "slug" => $request->slug,
        ]);

        $response = [
            "ProductCategory" => $ProductCategory,
            "message" => "ProductCategory updated successfully.",
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $ProductCategory = ProductCategory::find($id);
        $ProductCategory->delete();
        $response = [
            "message" => "ProductCategory deleted successfully.",
        ];
        return response($response, 201);
    }
}
