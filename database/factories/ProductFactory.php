<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $categoryId = Category::query()->inRandomOrder()->value('id');

        if (!$categoryId) {
            $categoryId = Category::firstOrCreate([
                'name' => 'Lainnya',
            ])->id;
        }

        return [
            'name' => fake()->randomElement([
                'Laptop ASUS',
                'Mouse Wireless',
                'Keyboard Mechanical',
                'Monitor LED',
                'Printer Epson',
                'Flashdisk 64GB',
                'Headset',
                'Webcam',
                'Harddisk Eksternal',
                'Kabel HDMI',
            ]),
            'category_id' => $categoryId,
            'sku' => fake()->unique()->bothify('INV-####-????'),
            'stock' => fake()->numberBetween(0, 100),
            'minimum_stock' => fake()->numberBetween(5, 15),
            'price' => fake()->numberBetween(10000, 10000000),
        ];
    }
}