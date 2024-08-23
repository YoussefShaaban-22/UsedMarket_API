<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $Attribute=Attribute::all();
        return $Attribute;
    }

    public function store(Request $request)
    {
        $request->validate([
            "name"=>'required|string',
        ]);

        $Attribute=Attribute::create([
            "name"=>$request->name,
        ]);
        $response=[
            "Attribute"=>$Attribute,
            "message"=>"Attribute added successfully.",
        ];
        return response($response,201);
    }

    public function show($id)
    {
        $Attribute=Attribute::find($id);
        return $Attribute;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name"=>'required|string',
        ]);
        $Attribute=Attribute::find($id);
        $Attribute->update([
            "name"=>$request->name,
        ]);

        $response=[
            "Attribute"=>$Attribute,
            "message"=>"Attribute updated successfully.",
        ];
        return response($response,201);
    }

    public function destroy($id)
    {
        $Attribute=Attribute::find($id);
        $Attribute->delete();
        $response=[
            "message"=>"Attribute deleted successfully.",
        ];
        return response($response,201);
    }
}
