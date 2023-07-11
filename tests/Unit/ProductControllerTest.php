<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test store method with valid data.
     *
     * @return void
     */
    public function testStoreMethodWithValidData()
    {
        $response = $this->post(route('products.store'), [
            'name' => 'Test Product',
            'price' => 9.99,
            'description' => 'Test description',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 9.99,
            'description' => 'Test description',
        ]);
    }

    /**
     * Test store method with invalid data.
     *
     * @return void
     */
    public function testStoreMethodWithInvalidData()
    {
        $response = $this->post(route('products.store'), []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'price', 'description']);
    }
}
