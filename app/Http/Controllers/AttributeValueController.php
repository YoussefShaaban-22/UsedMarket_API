<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index()
    {
        $AttributeValue=AttributeValue::all();
        return $AttributeValue;
    }

    public function store(Request $request)
    {
        $request->validate([
            "attribute_id"=>'required',
            "value"=>'required|string',
        ]);

        $AttributeValue=AttributeValue::create([
            "attribute_id"=>$request->attribute_id,
            "value"=>$request->value,
        ]);
        $response=[
            "AttributeValue"=>$AttributeValue,
            "message"=>"AttributeValue added successfully.",
        ];
        return response($response,201);
    }

    public function show($id)
    {
        $AttributeValue=AttributeValue::find($id);
        return $AttributeValue;
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            "value"=>'required|string',
        ]);
        $AttributeValue=AttributeValue::find($id);
        $AttributeValue->update([
            "value"=>$request->value,
        ]);

        $response=[
            "AttributeValue"=>$AttributeValue,
            "message"=>"AttributeValue updated successfully.",
        ];
        return response($response,201);
    }

    public function destroy($id)
    {
        $AttributeValue=AttributeValue::find($id);
        $AttributeValue->delete();
        $response=[
            "message"=>"AttributeValue deleted successfully.",
        ];
        return response($response,201);
    }
}
