<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Super Admin por defecto
            [
                'name'   => 'Admin Weitel',
                'cedula' => '1710034065',
                'role'   => 'administrador',
            ],
            // Foto 1
            [
                'name'   => 'ASERO TIPANLUISA MÓNICA CRISTINA',
                'cedula' => '1717797896',
                'role'   => 'administrativo', // Rol jefe cambiado a administrativo
            ],
            [
                'name'   => 'BAYAS PATÍN CESAR VINICIO',
                'cedula' => '0201920972',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'BETANCOUR MAYER JOHN JAIRO',
                'cedula' => '0804177806',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'CACHIMUEL RAMOS JAIME ENRIQUE',
                'cedula' => '1712611969',
                'role'   => 'administrador',
            ],
            [
                'name'   => 'CACHIMUEL URBANO LEONARDO DAVID',
                'cedula' => '1750915587',
                'role'   => 'tecnico',
            ],
            // Foto 2
            [
                'name'   => 'CACHIMUEL URBANO TAMIA BELEN',
                'cedula' => '1750915611',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'CAIZA PUNINA DUBAL LIZANDRO',
                'cedula' => '0202472288',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'CHELA MILÁN ELVIS CRISTIAN',
                'cedula' => '0202135356',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'CUELLO GUERRERO DAVID ISRAEL',
                'cedula' => '0202188322',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'GARCIA ZURITA PATRICIA MARISOL',
                'cedula' => '1207234566',
                'role'   => 'administrativo',
            ],
            // Foto 3
            [
                'name'   => 'MANOBANDA MANOBANDA ÉRIKA MISHELL',
                'cedula' => '0202349585',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'MOPOSITA ROCHINA CRISTIAN DANILO',
                'cedula' => '0202005286',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'PAGUAY JUAN CARLOS',
                'cedula' => '1717486532',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'PARCO CARVAJAL DARWIN RODRIGO',
                'cedula' => '0202320776',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'PARCO CARVAJAL JOHANA MARIBEL',
                'cedula' => '0250132610',
                'role'   => 'tecnico',
            ],
            // Foto 4
            [
                'name'   => 'PILCO SORIA DARWIN PATRICIO',
                'cedula' => '1725692071',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'PRADO MAYER LEONEL JOHAO',
                'cedula' => '0803810522',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'PUNINA PUNINA FREDDY GONZALO',
                'cedula' => '0202358826',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'QUIÑONEZ DIAZ JEAN CARLOS',
                'cedula' => '0803810183',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'RAMOS PURCACHI JHOMAYRA LILIBHET',
                'cedula' => '0202101762',
                'role'   => 'administrativo',
            ],
            // Foto 5
            [
                'name'   => 'TANDAPILCO MUÑOZ MICHAEL EDUARDO',
                'cedula' => '0250210796',
                'role'   => 'administrativo',
            ],
            [
                'name'   => 'TÉCNICO AUXILIAR',
                'cedula' => '0123456789',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'TINITANA GAVILANES JORGE LUIS',
                'cedula' => '0201708625',
                'role'   => 'administrativo',
            ],
            [
                'name'   => 'URBANO BORJA DIEGO JESÚS',
                'cedula' => '0250180700',
                'role'   => 'administrador',
            ],
            [
                'name'   => 'URBANO URBANO LUCÍA',
                'cedula' => '0201657897',
                'role'   => 'administrativo', // Rol cambiado de admin a administrativo
            ],
            // Indicados en texto
            [
                'name'   => 'VARGAS ROBERTO ALFREDO',
                'cedula' => '0201355468',
                'role'   => 'tecnico',
            ],
            [
                'name'   => 'YANZA YANZA EDWIN JOEL',
                'cedula' => '0202404638',
                'role'   => 'tecnico',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['cedula' => $userData['cedula']],
                [
                    'name' => $userData['name'],
                    'role' => $userData['role'],
                ]
            );
        }
    }
}
