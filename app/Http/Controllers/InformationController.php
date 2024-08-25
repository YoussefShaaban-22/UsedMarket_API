<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function index()
    {
        $Information = Information::all();
        return $Information;
    }

    public function store(Request $request)
    {
        $request->validate([
            "logo" => 'required',
            'about_company' => 'required',
        ]);

        $Information = Information::create([
            "logo" => $request->logo,
            "about_company" => $request->about_company,
        ]);
        $response = [
            "Information" => $Information,
            "message" => "Information added successfully.",
        ];
        return response($response, 201);
    }
    public function showById($id)
    {
        $Information = Information::find($id);
        return $Information;
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            "logo" => 'required',
            "about_company" => 'required',
        ]);
        $Information = Information::find($id);
        $Information->update([
            "logo" => $request->logo,
            "about_company" => $request->about_company,
        ]);

        $response = [
            "Information" => $Information,
            "message" => "Information updated successfully.",
        ];
        return response($response, 201);
    }
}
