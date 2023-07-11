<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class ProductOrderController extends Controller
{
    /**
     * Display the order details.
     *
     * @param  int  $orderId
     * @return \Illuminate\Http\Response
     */
    public function show($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('orders.show', compact('order'));
    }

    /**
     * Create a new order for the products in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart');

        if (!$cart) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $order = new Order;
        $order->user_id = auth()->user()->id; // Assuming you have user authentication
        $order->status = 'pending';
        $order->save();

        foreach ($cart as $productId => $item) {
            $product = Product::findOrFail($productId);

            $order->products()->attach($product, ['quantity' => $item['quantity']]);
        }

        session()->forget('cart');

        return redirect()->route('orders.show', ['orderId' => $order->id])
                        ->with('success', 'Order placed successfully.');
    }
}
