<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        $Seller = Seller::all();
        return $Seller;
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required|string',
            'logo' => 'required',
            'description' => 'required',
            'slide_image' => 'required',
            'phone' => 'required',
            'whatsappLink' => 'required',
            'map' => 'required',
            'showData' => 'required',
            'slug' => 'required',
        ]);

        $Seller = Seller::create([
            "name" => $request->name,
            "logo" => $request->logo,
            "description" => $request->description,
            "slide_image" => $request->slide_image,
            "phone" => $request->phone,
            "whatsappLink" => $request->whatsappLink,
            "map" => $request->map,
            "showData"=>$request->showData,
            "slug" => $request->slug,
        ]);
        $response = [
            "Seller" => $Seller,
            "message" => "Seller added successfully.",
        ];
        return response($response, 201);
    }

    public function show($slug)
    {
        $Seller = Seller::where('slug', $slug)->first();
        return $Seller;
    }
    public function showById($id)
    {
        $Seller = Seller::find($id);
        return $Seller;
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => 'required|string',
            'logo' => 'required',
            'description' => 'required',
            'slide_image' => 'required',
            'phone' => 'required',
            'whatsappLink' => 'required',
            'map' => 'required',
            'showData' => 'required',
            'slug' => 'required',
        ]);
        $Seller = Seller::find($id);
        $Seller->update([
            "name" => $request->name,
            "logo" => $request->logo,
            "description" => $request->description,
            "slide_image" => $request->slide_image,
            "phone" => $request->phone,
            "whatsappLink" => $request->whatsappLink,
            "map" => $request->map,
            "showData"=>$request->showData,
            "slug" => $request->slug,

        ]);

        $response = [
            "Seller" => $Seller,
            "message" => "Seller updated successfully.",
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $Seller = Seller::find($id);
        $Seller->delete();
        $response = [
            "message" => "Seller deleted successfully.",
        ];
        return response($response, 201);
    }
}
