<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $Feedback = Feedback::all();
        return $Feedback;
    }

    public function store(Request $request)
    {
        $request->validate([
            "user_id" => 'required',
            "user_name" => 'required',
            "product_id" => 'required',
            "feedback" => 'required',
            "rating" => 'required',
        ]);
        $existingCart = Feedback::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();

            if ($existingCart) {
                $response = [
                    "message" => "Your feedback already exist.",
                ];
            } else {
                $Feedback = Feedback::create([
                    "user_id" => $request->user_id,
                    "user_name" => $request->user_name,
                    "product_id" => $request->product_id,
                    "feedback" => $request->feedback,
                    "rating" => $request->rating,
                ]);
                $response = [
                    "Feedback" => $Feedback,
                    "message" => "Feedback added successfully.",
                ];
            }

        return response($response, 201);
    }

    public function show($id)
    {
        $Feedback = Feedback::find($id);
        return $Feedback;
    }

    public function showproductId($product_id)
    {
        $Feedback = Feedback::where('product_id', $product_id)->get();
        return $Feedback;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "user_id" => 'required',
            "product_id" => 'required',
            "feedback" => 'required',
            "rating" => 'required',
        ]);
        $Feedback = Feedback::find($id);
        $Feedback->update([
            "user_id" => $request->user_id,
            "product_id" => $request->product_id,
            "feedback" => $request->feedback,
            "rating" => $request->rating,
        ]);

        $response = [
            "Feedback" => $Feedback,
            "message" => "Feedback updated successfully.",
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $Feedback = Feedback::find($id);
        $Feedback->delete();
        $response = [
            "message" => "Feedback deleted successfully.",
        ];
        return response($response, 201);
    }
}
