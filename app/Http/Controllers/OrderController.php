<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $order = new Order();
            $order->status = 'pending';
            $order->total_price = 0;
            $order->save();

            $totalPrice = 0;

            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['id']);
                $price = $product->price * $item['quantity'];
                $totalPrice += $price;

                $order->products()->attach($product->id, [
                    'quantity' => $item['quantity'],
                    'price' => $price,
                ]);
            }

            $order->total_price = $totalPrice;
            $order->save();

            DB::commit();

            return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating order', 'error' => $e->getMessage()], 500);
        }
    }

    public function history()
    {
        $orders = Order::with('products')->orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    }
}
