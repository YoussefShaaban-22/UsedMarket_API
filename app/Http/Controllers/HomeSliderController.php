<?php

namespace App\Http\Controllers;

use App\Models\HomeSlider;
use Illuminate\Http\Request;

class HomeSliderController extends Controller
{
    public function index()
    {
        $HomeSlider = HomeSlider::all();
        return $HomeSlider;
    }

    public function store(Request $request)
    {
        $request->validate([
            "slider_image" => 'required',
            "order" => 'required',
        ]);

        $HomeSlider = HomeSlider::create([
            "slider_image" => $request->slider_image,
            "order" => $request->order,
        ]);
        $response = [
            "HomeSlider" => $HomeSlider,
            "message" => "HomeSlider added successfully.",
        ];
        return response($response, 201);
    }

    public function show($id)
    {
        $HomeSlider = HomeSlider::find($id);
        return $HomeSlider;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "slider_image" => 'required',
            "order" => 'required',
        ]);
        $HomeSlider = HomeSlider::find($id);
        $HomeSlider->update([
            "slider_image" => $request->slider_image,
            "order" => $request->order,
        ]);

        $response = [
            "HomeSlider" => $HomeSlider,
            "message" => "HomeSlider updated successfully.",
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $HomeSlider = HomeSlider::find($id);
        $HomeSlider->delete();
        $response = [
            "message" => "HomeSlider deleted successfully.",
        ];
        return response($response, 201);
    }
}
