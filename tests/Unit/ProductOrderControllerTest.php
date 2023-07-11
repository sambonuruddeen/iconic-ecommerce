<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class ProductOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test displaying the order details.
     *
     * @return void
     */
    public function testShowOrderDetails()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('orders.show', ['orderId' => $order->id]));

        $response->assertStatus(200);
        $response->assertViewIs('orders.show');
        $response->assertViewHas('order', $order);
    }

    /**
     * Test creating a new order for the products in the cart.
     *
     * @return void
     */
    public function testCreateNewOrder()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $cart = [
            $product->id => [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 2,
            ]
        ];

        session()->put('cart', $cart);

        $response = $this->actingAs($user)->post(route('orders.store'));

        $response->assertStatus(302);
        $response->assertRedirect(route('orders.show', ['orderId' => 1])); // Assuming the order ID is 1
        $response->assertSessionMissing('cart');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('order_product', [
            'order_id' => 1, // Assuming the order ID is 1
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }
}
