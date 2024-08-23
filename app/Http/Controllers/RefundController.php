<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index()
    {
        $Refund = Refund::all();
        return $Refund;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function showuserId($user_id)
    {
        $Refund = Refund::where('user_id', $user_id)->get();
        return $Refund;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function showRefundorderId($order_id)
    {
        $Refund = Refund::where('order_id', $order_id)->get();
        return $Refund;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function store(Request $request)
    {
        $request->validate([
            "user_id" => 'required',
            "product_id" => 'required',
            "seller_id" => 'required',
            "order_id" => 'required',
            "reason" => 'required',
        ]);

        $existingCart = Refund::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->where('order_id', $request->order_id)
            ->first();

        if ($existingCart) {
            $response = [
                "message" => "Your Refund Order already exist.",
            ];
        } else {
            $Refund = Refund::create([
                "user_id" => $request->user_id,
                "order_id" => $request->order_id,
                "product_id" => $request->product_id,
                "seller_id" => $request->seller_id,
                "reason" => $request->reason,
                "status" => "pending",
            ]);
            $response = [
                "Refund" => $Refund,
                "message" => "Refund added successfully.",
            ];
        }

        return response($response, 201);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function show($id)
    {
        $Refund = Refund::find($id);
        return $Refund;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function cancel(Request $request, $id)
    {
        $Refund = Refund::find($id);
        if (!$Refund) {
            return response()->json([
                'message' => 'Refund order not found.'
            ], 404);
        }

        $Refund->update(['status' => 'Cancelled']);

        $response = [
            'Refund' => $Refund,
            'message' => 'Orders updated successfully.',
        ];

        return response($response, 200);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function accept(Request $request, $id)
    {
        $Refund = Refund::find($id);

        if (!$Refund) {
            return response()->json([
                'message' => 'Refund order not found.'
            ], 404);
        }

        $Refund->update(['status' => 'Accepted']);
        $response = [
            'Refund' => $Refund,
            'message' => 'Refund order updated successfully.',
        ];

        return response($response, 200);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function destroy($id)
    {
        $Refund = Refund::find($id);
        $Refund->delete();
        $response = [
            "message" => "Refund deleted successfully.",
        ];
        return response($response, 201);
    }
}
