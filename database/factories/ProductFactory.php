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
            'name_en' => 'iphoneX',
            'slug' => 'iphoneX',
            'description' => 'good phone',
            'description_en' => 'good phone',
            'image' => 'products/iphoneX.png',
            'category_id' => Category::where('id', 1)->first()->id
        ];
    }
}
