<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test adding a product to the cart.
     *
     * @return void
     */
    public function testAddProductToCart()
    {
        $product = Product::factory()->create();

        $response = $this->post(route('cart.add', ['productId' => $product->id]));

        $response->assertStatus(302);
        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('cart.' . $product->id);

        $this->assertEquals(1, session('cart.' . $product->id . '.quantity'));
    }

    /**
     * Test updating the quantity of a product in the cart.
     *
     * @return void
     */
    public function testUpdateProductQuantityInCart()
    {
        $product = Product::factory()->create();

        $this->post(route('cart.add', ['productId' => $product->id]));

        $response = $this->post(route('cart.update', ['productId' => $product->id]), [
            'quantity' => 5,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('cart.' . $product->id);

        $this->assertEquals(5, session('cart.' . $product->id . '.quantity'));
    }

    /**
     * Test removing a product from the cart.
     *
     * @return void
     */
    public function testRemoveProductFromCart()
    {
        $product = Product::factory()->create();

        $this->post(route('cart.add', ['productId' => $product->id]));

        $response = $this->post(route('cart.remove', ['productId' => $product->id]));

        $response->assertStatus(302);
        $response->assertRedirect(route('cart.index'));
        $response->assertSessionMissing('cart.' . $product->id);
    }

    /**
     * Test clearing the cart.
     *
     * @return void
     */
    public function testClearCart()
    {
        $product = Product::factory()->create();

        $this->post(route('cart.add', ['productId' => $product->id]));

        $response = $this->post(route('cart.clear'));

        $response->assertStatus(302);
        $response->assertRedirect(route('cart.index'));
        $response->assertSessionMissing('cart');

        $this->assertEmpty(session('cart'));
    }
}
