<?php

namespace App\Services;

use App\Models\Client;

class ClientService
{
    /**
     * Busca un cliente por cédula o nombre/apellido.
     */
    public function searchClient($query)
    {
        return Client::where('cedula', 'like', "%{$query}%")
            ->orWhere('nombre', 'like', "%{$query}%")
            ->orWhere('apellido', 'like', "%{$query}%")
            ->get();
    }

    /**
     * Crea un cliente o lo actualiza si ya existe su cédula.
     */
    public function findOrCreateClient(array $data)
    {
        return Client::updateOrCreate(
            ['cedula' => $data['cedula']],
            [
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'] ?? '',
                'email' => $data['email'] ?? null,
                'direccion' => $data['direccion'] ?? null,
                'ciudad' => $data['ciudad'] ?? null,
                'canton' => $data['canton'] ?? null,
                'parroquia' => $data['parroquia'] ?? null,
                'provincia' => $data['provincia'] ?? null,
                'n_telefono' => $data['n_telefono'] ?? $data['telefono'] ?? null,
            ]
        );
    }
}
