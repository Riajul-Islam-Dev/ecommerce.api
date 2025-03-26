<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_product()
    {
        $payload = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 99.99,
            'category' => 'Test Category',
            'imageUrl' => 'https://example.com/image.jpg'
        ];

        $response = $this->postJson('/api/products', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'description',
                'price',
                'category',
                'imageUrl'
            ])
            ->assertJson([
                'name' => $payload['name'],
                'price' => $payload['price']
            ]);
    }

    /** @test */
    public function it_validates_required_fields_when_creating_product()
    {
        $response = $this->postJson('/api/products', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'description',
                'price',
                'category'
            ]);
    }

    /** @test */
    public function it_can_retrieve_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price
            ]);
    }

    /** @test */
    public function it_returns_404_when_product_not_found()
    {
        $response = $this->getJson('/api/products/999');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create();

        $updateData = [
            'name' => 'Updated Product',
            'price' => 199.99,
            'imageUrl' => 'https://example.com/new-image.jpg'
        ];

        $response = $this->putJson("/api/products/{$product->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Updated Product',
                'price' => 199.99
            ]);
    }

    /** @test */
    public function it_validates_price_when_updating_product()
    {
        $product = Product::factory()->create();

        $response = $this->putJson("/api/products/{$product->id}", [
            'price' => 'invalid-price'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['price']);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function it_handles_imageurl_correctly()
    {
        $payload = [
            'name' => 'Image Test',
            'description' => 'Image Test',
            'price' => 50,
            'category' => 'Test',
            'imageUrl' => 'invalid-url'
        ];

        $response = $this->postJson('/api/products', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['imageUrl']);
    }

    /** @test */
    public function it_allows_partial_updates()
    {
        $product = Product::factory()->create();

        $response = $this->putJson("/api/products/{$product->id}", [
            'category' => 'Updated Category'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'category' => 'Updated Category',
                'name' => $product->name
            ]);
    }
}
