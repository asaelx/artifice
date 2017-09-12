<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Accesorios',
            'Adornos de pared',
            'Flores',
            'Lámparas',
            'Muebles'
        ];

        foreach ($categories as $category) {
            Category::create([
                'title' => $category,
                'description' => $category
            ]);
        }
    }
}
