<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Limpiamos los seeders previos y llamamos a los necesarios
        $this->call([
            AdminSeeder::class,         // Crea los 3 usuarios (Admin, Operador, Técnico)
            InternetTypeSeeder::class,  // Tipos de conexión (Fibra, Inalámbrico, etc)
            InternetPlanSeeder::class,  // Catálogo de planes
            EquipmentSeeder::class,     // Inventario inicial de equipos
        ]);
    }
}
