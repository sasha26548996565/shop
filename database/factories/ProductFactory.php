<?php

namespace Database\Factories;

use App\Models\Category;
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
    public function definition()
    {
        return [
            'name' => 'iphoneX',
            'slug' => 'iphoneX',
            'description' => 'good phone',
            'image' => 'products/iphoneX.jpg',
            'category_id' => Category::where('id', 1)->first()->id
        ];
    }
}
