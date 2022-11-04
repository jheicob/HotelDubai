<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function test_create_successfully()
    {
        $this->withoutExceptionHandling();
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->postJson(route('Product.create'), [
                'name'                => $name = $this->faker->word(),
                'purchase_price'      => rand(1, 500),
                'sale_price'          => rand(1, 500),
                'description'         => $this->faker->text(),
                'visible'             => $this->faker->randomElement([true, false]),
                'inventory'           => [
                    'stock'     => $stock = $this->faker->randomNumber(),
                    'stock_min' => $stock_min = $this->faker->randomNumber()
                ],
            ]);

        $response->assertCreated()
            // ->assertExactJson([])
        ;
        $product = Product::firstWhere('name', $name);
        $this->assertEquals($product->inventory->stock, $stock);
        $this->assertEquals(
            $product->inventory->stock_min,
            $stock_min
        );
    }


    public function test_edit_successfully()
    {
        $this->withoutExceptionHandling();
        $user = User::find(1);
        $inventory = Inventory::factory()->create();
        $response = $this->actingAs($user)
            ->putJson(route('Product.updated', ['product' => $inventory->product_id]), [
                'name'                => $name = $this->faker->word(),
                'purchase_price'      => rand(1, 500),
                'sale_price'          => rand(1, 500),
                'description'         => $this->faker->text(),
                'visible'             => $this->faker->randomElement([true, false]),
                'inventory'           => [
                    'stock'     => $stock = $this->faker->randomNumber(),
                    'stock_min' => $stock_min = $this->faker->randomNumber()
                ],
            ]);

        $response->assertOk()
            // ->assertExactJson([])
        ;
        $product = Product::find($inventory->product_id);
        $this->assertEquals($product->inventory->stock, $stock);
        $this->assertEquals(
            $product->inventory->stock_min,
            $stock_min
        );
    }
}
