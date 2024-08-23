<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $Color=Color::all();
        return $Color;
    }

    public function store(Request $request)
    {
        $request->validate([
            "name"=>'required|string',
            "code"=>'required',
        ]);

        $Color=Color::create([
            "name"=>$request->name,
            "code"=>$request->code,
        ]);
        $response=[
            "Color"=>$Color,
            "message"=>"Color added successfully.",
        ];
        return response($response,201);
    }

    public function show($id)
    {
        $Color=Color::find($id);
        return $Color;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name"=>'required|string',
            "code"=>'required',
        ]);
        $Color=Color::find($id);
        $Color->update([
            "name"=>$request->name,
            "code"=>$request->code,
        ]);

        $response=[
            "Color"=>$Color,
            "message"=>"Color updated successfully.",
        ];
        return response($response,201);
    }

    public function destroy($id)
    {
        $Color=Color::find($id);
        $Color->delete();
        $response=[
            "message"=>"Color deleted successfully.",
        ];
        return response($response,201);
    }
}
