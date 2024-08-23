<?php

namespace App\Http\Controllers;

use App\Models\inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiry = inquiry::all();
        return $inquiry;
    }

    public function store(Request $request)
    {
        $request->validate([
            "user_email" => 'required|string',
            'product_name' => 'required',
            'user_phone' => 'required',
            'inquiry' => 'required',
        ]);

        $inquiry = inquiry::create([
            "user_email" => $request->user_email,
            "product_name" => $request->product_name,
            "seller_id" => $request->seller_id,
            "user_phone" => $request->user_phone,
            "inquiry" => $request->inquiry,
        ]);
        $response = [
            "inquiry" => $inquiry,
            "message" => "inquiry added successfully.",
        ];
        return response($response, 201);
    }
}
