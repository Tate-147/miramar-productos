<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paquete;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;

class PaqueteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Limpiamos las tablas relacionadas
        DB::table('paquetes')->delete();
        DB::table('paquete_servicio')->delete();

        // Buscamos los servicios por su código para que sea más claro
        $servicioVueloMiami = Servicio::where('codigo', 'VUE-MIA-01')->first();
        $servicioHotelCancun = Servicio::where('codigo', 'HOT-CUN-05')->first();
        $servicioAutoRoma = Servicio::where('codigo', 'CAR-ROM-02')->first();
        $servicioExcursion = Servicio::where('codigo', 'EXC-BAR-01')->first();

        // Creamos el Paquete 1: "Caribeño"
        if ($servicioVueloMiami && $servicioHotelCancun) {
            $paqueteCaribe = Paquete::create([
                'nombre' => 'Paquete Caribeño Total',
                'descripcion' => 'Disfruta del sol y la playa en Cancún con todo incluido.'
            ]);
            // Asociamos los servicios al paquete
            $paqueteCaribe->servicios()->attach([$servicioVueloMiami->id, $servicioHotelCancun->id]);
        }

        // Creamos el Paquete 2: "Aventura Patagónica"
        if ($servicioExcursion) {
            $paqueteAventura = Paquete::create([
                'nombre' => 'Aventura en la Patagonia',
                'descripcion' => 'Vive la experiencia del sur argentino.'
            ]);
            $paqueteAventura->servicios()->attach($servicioExcursion->id);
        }
    }
}