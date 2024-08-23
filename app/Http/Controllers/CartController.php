<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $Cart = Cart::all();
        return $Cart;
    }

    public function store(Request $request)
    {
        $request->validate([
            "user_id" => 'required',
            "product_id" => 'required',
            "seller_id" => 'required',
            "quantity" => 'required',
            "color" => 'required',
            "product_price" => 'required',
            "total_price" => 'required',
        ]);

        $existingCart = Cart::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->where('color', $request->color)
            ->first();

        if ($existingCart) {
            $existingCart->quantity = $request->quantity;
            $existingCart->product_price = $request->product_price;
            $existingCart->total_price = $existingCart->quantity * $request->product_price;
            $existingCart->save();

            $response = [
                "Cart" => $existingCart,
                "message" => "Cart updated successfully.",
            ];
        } else {
            $Cart = Cart::create([
                "user_id" => $request->user_id,
                "product_id" => $request->product_id,
                "seller_id" => $request->seller_id,
                "quantity" => $request->quantity,
                "color" => $request->color,
                "product_price" => $request->product_price,
                "total_price" => $request->total_price,
            ]);

            $response = [
                "Cart" => $Cart,
                "message" => "Cart added successfully.",
            ];
        }

        return response($response, 201);
    }
    public function show($id)
    {
        $Cart = Cart::find($id);
        return $Cart;
    }
    public function showuserId($user_id)
    {
        $Cart = Cart::where('user_id', $user_id)->get();
        return $Cart;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "user_id" => 'required',
            "product_id" => 'required',
            "seller_id" => 'required',
            "quantity" => 'required',
            "color" => 'required',
            "product_price" => 'required',
            "total_price" => 'required',
        ]);
        $Cart = Cart::find($id);
        $Cart->update([
            "user_id" => $request->user_id,
            "product_id" => $request->product_id,
            "seller_id" => $request->seller_id,
            "quantity" => $request->quantity,
            "color" => $request->color,
            "product_price" => $request->product_price,
            "total_price" => $request->quantity * $request->product_price,
        ]);

        $response = [
            "Cart" => $Cart,
            "message" => "Cart updated successfully.",
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $Cart = Cart::find($id);
        $Cart->delete();
        $response = [
            "message" => "Cart deleted successfully.",
        ];
        return response($response, 201);
    }
    
}
