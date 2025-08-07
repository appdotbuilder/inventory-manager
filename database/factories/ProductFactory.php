<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cost = fake()->randomFloat(2, 5, 500);
        $selling = $cost * fake()->randomFloat(2, 1.2, 3.0);
        
        return [
            'name' => fake()->words(3, true),
            'sku' => fake()->unique()->regexify('[A-Z]{4}-[A-Z]{4}-[0-9]{3}'),
            'description' => fake()->sentence(),
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
            'cost_price' => $cost,
            'selling_price' => $selling,
            'reorder_level' => fake()->numberBetween(5, 50),
            'current_stock' => fake()->numberBetween(0, 500),
            'unit' => fake()->randomElement(['pcs', 'kg', 'lbs', 'sets', 'boxes']),
            'barcode' => fake()->ean13(),
            'qr_code' => 'QR_' . fake()->regexify('[A-Z0-9]{10}'),
            'specifications' => null,
            'is_active' => true,
        ];
    }
}