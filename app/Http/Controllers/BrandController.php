<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $Brand = Brand::all();
        return $Brand;
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required|string',
            "logo" => 'required|string',
            "slug" => 'required|string',
        ]);

        $Brand = Brand::create([
            "name" => $request->name,
            "logo" => $request->logo,
            "slug" => $request->slug,
        ]);
        $response = [
            "Brand" => $Brand,
            "message" => "Brand added successfully.",
        ];
        return response($response, 201);
    }

    public function show($slug)
    {
        $Brand = Brand::where('slug', $slug)->first();
        return $Brand;
    }

    public function showById($id){
        $Brand = Brand::find($id);
        return $Brand;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => 'required|string',
            "logo" => 'required|string',
            "slug" => 'required|string',
        ]);
        $Brand = Brand::find($id);
        $Brand->update([
            "name" => $request->name,
            "logo" => $request->logo,
            "slug" => $request->slug,
        ]);

        $response = [
            "Brand" => $Brand,
            "message" => "Brand updated successfully.",
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $Brand = Brand::find($id);
        $Brand->delete();
        $response = [
            "message" => "Brand deleted successfully.",
        ];
        return response($response, 201);
    }
}
