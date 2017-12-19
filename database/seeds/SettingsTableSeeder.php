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
            'email' => 'info@artificestore.mx',
            'phone' => '54 1 (999) 6 88 02 40',
            'store_url' => 'www.artificestore.mx',
            'address' => 'Plaza Victory Platz. Local 19, Calle 32 No.352 Av. García Lavín y 36 Diagonal, Mérida, Yucatán.',
            'observations' => 'En PEDIDOS, el anticipo será del 70% del TOTAL y el saldo el 30% contra entrega de la mercancía.'.'
'.'En APARTADOS, el anticipo será del 50% del TOTAL y el saldo contra entrega de la mercancia.'.'
'.'El tiempo máximo de apartado será de 2 meses. En caso de haber cumplido el plazo ó la mercancia sea cancelada después de este período, tendrá una penalización del 5% sobre el total del apartado.'.'
'.'Precios sujetos a cambios sin previo aviso. Toda vez efectuado el pago del anticipo, el precio del articulo no variará.'.'
'.'Los precios son en MXN y NO INCLUYEN IVA.'.'
'.'NO se aceptan cambios ni devoluciones.'.'
'.'La válidez de esta cotización es por 5 días y dependerá de la disponibilidad de las piezas.',
            'subject' => 'Cotización Artífice Store',
            'message' => 'Mensaje del correo',
            'tax' => 16,
            'discount_code' => 333,
            'currency_id' => $currency->id
        ]);
    }
}
