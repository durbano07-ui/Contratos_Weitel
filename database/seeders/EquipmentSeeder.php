<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $equipos = [
            [
                'nombre'       => 'Router Wi-Fi Dual Band',
                'categoria'    => 'Routers',
                'stock'        => 50,
                'stock_minimo' => 10,
                'unidad'       => 'unidad',
                'descripcion'  => 'Router inalámbrico de alta velocidad con 4 antenas gigabit.',
            ],
            [
                'nombre'       => 'ONU GPON / ONT Óptica',
                'categoria'    => 'ONU / ONT',
                'stock'        => 60,
                'stock_minimo' => 15,
                'unidad'       => 'unidad',
                'descripcion'  => 'Terminal de red óptica GPON con puerto Ethernet Gigabit.',
            ],
            [
                'nombre'       => 'Regulador de Voltaje (1000VA / 8 Tomas)',
                'categoria'    => 'Protección Eléctrica',
                'stock'        => 40,
                'stock_minimo' => 8,
                'unidad'       => 'unidad',
                'descripcion'  => 'Regulador automático de voltaje para protección de equipos.',
            ],
            [
                'nombre'       => 'Cable UTP Categoría 6 Exterior',
                'categoria'    => 'Cableado',
                'stock'        => 300,
                'stock_minimo' => 50,
                'unidad'       => 'metro',
                'descripcion'  => 'Cable de red para intemperie multifilar de alto desempeño.',
            ],
        ];

        foreach ($equipos as $eq) {
            Equipment::updateOrCreate(
                ['nombre' => $eq['nombre']],
                $eq
            );
        }
    }
}
