<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'           => 'Martin',
            'email'          => 'plateadodev@gmail.com',
            'password'       => bcrypt('prueba'),
            'remember_token' => str_random(10),
        ]);
        DB::table('users')->insert([
            'name'           => 'Ezequiel',
            'email'          => 'plateadodev2@gmail.com',
            'password'       => bcrypt('prueba'),
            'remember_token' => str_random(10),
        ]);
    }
}
