<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'username' => 'admin',
            'email' => 'cotizador@artificestore.mx',
            'email_password' => 'artifice2016',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);
    }
}
