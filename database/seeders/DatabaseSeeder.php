<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // El orden es importante: primero los servicios, luego los paquetes.
        $this->call([
            ServicioSeeder::class,
            PaqueteSeeder::class,
        ]);
    }
}
