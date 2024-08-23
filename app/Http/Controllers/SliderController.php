<?php

namespace App\Http\Controllers;

use App\Models\slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $slider = slider::all();
        return $slider;
    }

    public function store(Request $request)
    {
        $request->validate([
            "image" => 'required',
        ]);

        $slider = slider::create([
            "image" => $request->image,
        ]);
        $response = [
            "slider" => $slider,
            "message" => "slider added successfully.",
        ];
        return response($response, 201);
    }

    public function show($id)
    {
        $slider = slider::find($id);
        return $slider;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "image" => 'required|string',
        ]);
        $slider = slider::find($id);
        $slider->update([
            "image" => $request->image,
        ]);

        $response = [
            "slider" => $slider,
            "message" => "slider updated successfully.",
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $slider = slider::find($id);
        $slider->delete();
        $response = [
            "message" => "slider deleted successfully.",
        ];
        return response($response, 201);
    }
}
