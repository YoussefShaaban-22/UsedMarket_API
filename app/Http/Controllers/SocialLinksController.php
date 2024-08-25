<?php

namespace App\Http\Controllers;

use App\Models\SocialLinks;
use Illuminate\Http\Request;

class SocialLinksController extends Controller
{
    public function index()
    {
        $SocialLinks = SocialLinks::all();
        return $SocialLinks;
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required',
            'link' => 'required',
            'status' => 'required',
        ]);

        $SocialLinks = SocialLinks::create([
            "name" => $request->name,
            "link" => $request->link,
            "status" => $request->status,
        ]);
        $response = [
            "SocialLinks" => $SocialLinks,
            "message" => "SocialLink added successfully.",
        ];
        return response($response, 201);
    }
    public function showById($id)
    {
        $SocialLinks = SocialLinks::find($id);
        return $SocialLinks;
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => 'required',
            'link' => 'required',
            'status' => 'required',
        ]);
        $SocialLinks = SocialLinks::find($id);
        $SocialLinks->update([
            "name" => $request->name,
            "link" => $request->link,
            "status" => $request->status,
        ]);

        $response = [
            "SocialLinks" => $SocialLinks,
            "message" => "SocialLink updated successfully.",
        ];
        return response($response, 201);
    }
}
