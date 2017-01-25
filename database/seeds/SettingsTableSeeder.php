<?php

use Illuminate\Database\Seeder;
use App\Setting;
use App\Currency;
use App\Picture;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currency = Currency::latest()->first();

        Setting::create([
            'title' => 'Artífice',
            'owner' => 'Adriana',
            'email' => 'admin@artificestore.mx',
            'phone' => '9996880240',
            'store_url' => 'artificestore.mx',
            'address' => 'Calle 49 Num. 230 x 28 y 28A Col. San Antonio Cucul Mérida, Yucatán',
            'Observations' => 'Lorem ipsum',
            'tax' => 16,
            'discount_code' => 333,
            'currency_id' => $currency->id
        ]);
    }
}
