<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $Order = Order::all();
        return $Order;
    }

    public function showuserId($user_id)
    {
        $Order = Order::where('user_id', $user_id)->get();
        return $Order;
    }

    public function showorderId($order_id)
    {
        $Order = Order::where('order_id', $order_id)->get();
        return $Order;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function store(Request $request)
    {
        $request->validate([
            "user_id" => 'required|integer',
            "product_id" => 'required|array',
            "product_id.*" => 'integer',
            "seller_id" => 'required|array',
            "seller_id.*" => 'integer',
            "quantity" => 'required|array',
            "quantity.*" => 'integer',
            "color" => 'required|array',
            "color.*" => '',
            "product_price" => 'required|array',
            "product_price.*" => 'numeric',
            "total_product_price" => 'required|array',
            "total_product_price.*" => 'numeric',
            "total_price" => 'required|numeric',
            "paid" => 'required',
        ]);

        $orders = [];
        $lastOrderId = Order::getLastOrderId();
        $order_id = $lastOrderId === 0 ? 1 : $lastOrderId + 1;

        foreach ($request->product_id as $key => $product_id) {
            $orders[] = Order::create([
                "order_id" => $order_id,
                "user_id" => $request->user_id,
                "product_id" => $product_id,
                "seller_id" => $request->seller_id[$key],
                "quantity" => $request->quantity[$key],
                "color" => $request->color[$key],
                "product_price" => $request->product_price[$key],
                "total_product_price" => $request->total_product_price[$key],
                "total_price" => $request->total_price,
                "paid" => $request->paid,
                "status" => "pending",
            ]);
        }
        $response = [
            "Orders" => $orders,
            "message" => "Orders added successfully.",
        ];
        return response($response, 201);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function show($id)
    {
        $Order = Order::find($id);
        return $Order;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function update(Request $request, $id)
    {
        $request->validate([
            "user_id" => 'required',
            "product_id" => 'required',
            "seller_id" => 'required',
            "quantity" => 'required',
            "color" => 'required',
            "product_price" => 'required',
            "total_product_price" => 'required',
            "total_price" => 'required',
            "status" => 'required',
        ]);
        $Order = Order::find($id);
        $Order->update([
            "user_id" => $request->user_id,
            "product_id" => $request->product_id,
            "seller_id" => $request->seller_id,
            "quantity" => $request->quantity,
            "color" => $request->color,
            "product_price" => $request->product_price,
            "total_product_price" => $request->total_product_price,
            "total_price" => $request->total_price,
            "status" => $request->total_price,
        ]);

        $response = [
            "Order" => $Order,
            "message" => "Order updated successfully.",
        ];
        return response($response, 201);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function cancel(Request $request, $id)
    {
        $order = Order::where('order_id', $id)->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found.'
            ], 404);
        }

        $order_id = $order->order_id;
        $updatedRows = Order::where('order_id', $order_id)
            ->update(['status' => 'Cancelled']);

        $response = [
            'updated_rows' => $updatedRows,
            'message' => 'Orders updated successfully.',
        ];

        return response($response, 200);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function accept(Request $request, $id)
    {
        $order = Order::where('order_id', $id)->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found.'
            ], 404);
        }

        $order_id = $order->order_id;
        $updatedRows = Order::where('order_id', $order_id)
            ->update(['status' => 'Accepted']);

        $response = [
            'updated_rows' => $updatedRows,
            'message' => 'Orders updated successfully.',
        ];

        return response($response, 200);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function paid(Request $request, $id)
    {
        $order = Order::where('order_id', $id)->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found.'
            ], 404);
        }

        $order_id = $order->order_id;
        $updatedRows = Order::where('order_id', $order_id)
            ->update(['paid' => 'paid']);

        $response = [
            'updated_rows' => $updatedRows,
            'message' => 'Orders updated successfully.',
        ];

        return response($response, 200);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function comment(Request $request, $id)
    {
        $request->validate([
            "comment" => 'required',
        ]);
        $order = Order::where('order_id', $id)->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found.'
            ], 404);
        }

        $order_id = $order->order_id;
        $updatedRows = Order::where('order_id', $order_id)
            ->update(["comment" => $request->comment,]);

        $response = [
            'updated_rows' => $updatedRows,
            'message' => 'Orders updated successfully.',
        ];

        return response($response, 200);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function user_required(Request $request, $id)
    {
        $request->validate([
            "user_required" => 'required',
        ]);
        $order = Order::where('order_id', $id)->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found.'
            ], 404);
        }

        $order_id = $order->order_id;
        $updatedRows = Order::where('order_id', $order_id)
            ->update(["user_required" => $request->user_required,]);

        $response = [
            'updated_rows' => $updatedRows,
            'message' => 'Orders updated successfully.',
        ];

        return response($response, 200);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function updateOrderTotalPrice(Request $request, $id)
    {
        // Find the order by its ID
        $order = Order::where('id', $id)->first();
        if (!$order) {
            return response()->json([
                'message' => 'Order not found.'
            ], 404);
        }

        // Validate the incoming request
        $request->validate([
            'total_price' => 'required|numeric',
            'quantity' => 'required',

        ]);
        $order_id = $order->order_id;
        $updatedRows = Order::where('order_id', $order_id)
        ->update(["total_price" => $request->input('total_price')]);

        $product_id = $order->product_id;
        $updatedProduct = Product::where('id', $product_id)
        ->update(["quantity" => $request->input('quantity')]);

        // Return a success response
        return response()->json([
            'order' => $updatedRows,
            'product' => $updatedProduct,
            'message' => 'Order total price and product quantity updated successfully.',
        ], 200);
    }

    public function destroy($id)
    {
        $order = Order::where('order_id', $id)->first();
        $order_id = $order->order_id;
        $DeletedRows = Order::where('order_id', $order_id)
            ->delete();
        $response = [
            'Deleted Rows' => $DeletedRows,
            "message" => "Order deleted successfully.",
        ];
        return response($response, 201);
    }
}
