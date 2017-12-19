<?php

use Illuminate\Database\Seeder;
use App\Picture;

class PicturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Picture::create(['original_name' => 'nophoto', 'url' => 'products/photo.jpg']);
    }
}
