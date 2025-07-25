<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Limpiamos la tabla antes de insertar para evitar duplicados si se corre varias veces
        DB::table('servicios')->delete();

        Servicio::create([
            'codigo' => 'VUE-MIA-01',
            'nombre' => '✈️ Vuelo a Miami',
            'descripcion' => 'Vuelo directo desde Buenos Aires a Miami.',
            'destino' => 'Miami, USA',
            'fecha' => '2025-10-20',
            'costo' => 750.00
        ]);

        Servicio::create([
            'codigo' => 'HOT-CUN-05',
            'nombre' => '🏨 Hotel en Cancún',
            'descripcion' => 'Estadía de 7 noches en hotel 5 estrellas frente al mar.',
            'destino' => 'Cancún, México',
            'fecha' => '2025-11-15',
            'costo' => 1200.50
        ]);

        Servicio::create([
            'codigo' => 'CAR-ROM-02',
            'nombre' => '🚗 Alquiler de Auto en Roma',
            'descripcion' => 'Alquiler de Fiat 500 por 5 días.',
            'destino' => 'Roma, Italia',
            'fecha' => '2025-09-05',
            'costo' => 300.00
        ]);
        
        Servicio::create([
            'codigo' => 'EXC-BAR-01',
            'nombre' => '🌴 Excursión a la Patagonia',
            'descripcion' => 'Trekking de día completo por el glaciar Perito Moreno.',
            'destino' => 'El Calafate, Argentina',
            'fecha' => '2025-12-01',
            'costo' => 150.00
        ]);
    }
}