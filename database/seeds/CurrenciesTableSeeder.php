<?php

use Illuminate\Database\Seeder;
use App\Currency;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create([
            'title' => 'Peso Mexicano',
            'code' => 'MXN',
            'symbol' => '$',
            'precision' => 2
        ]);
    }
}
