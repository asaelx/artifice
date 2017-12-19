<?php

use Illuminate\Database\Seeder;
use App\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            'Arteriors',
            'Hooker Furniture',
            'Interlude',
            'New Growth Desings',
            'Phillips Collection',
            'Regina Andrew'
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'title' => $brand,
                'description' => $brand
            ]);
        }
    }
}
