<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    private array $categories;

    public function __construct()
    {
        $this->categories = [
            ['name' => 'Мобильная техника', 'slug' => 'Mobile', 'description' => 'Категория мобильной техники',
                'image' => 'categories/mobile.png'],
            ['name' => 'Бытовая техника', 'slug' => 'appliances', 'description' => 'Категория бытовой техники',
                'image' => 'categories/appliances.png'],
            ['name' => 'Портативная техника', 'slug' => 'portable', 'description' => 'Категория портативной техники',
                'image' => 'categories/portable.png']
        ];
    }

    public function run()
    {
        DB::table('categories')->insert($this->categories);
    }
}
