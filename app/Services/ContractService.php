<?php

namespace App\Services;

use App\Models\Contract;

class ContractService
{
    private $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * Procesa la creación completa de un contrato, asegurando la existencia del cliente.
     */
    public function createContract(array $data, $userId, $idTecnico = null)
    {
        // 1. Obtener o crear el cliente
        $client = $this->clientService->findOrCreateClient($data['client']);

        $equiposSeleccionados = $data['contract']['equipos'] ?? [];

        $paymentMethod = $data['contract']['payment'] ?? 'direct';
        $rawDatosPago = $data['contract']['datos_pago'] ?? [];
        $datosPago = null;

        if (is_array($rawDatosPago)) {
            if ($paymentMethod === 'auto') {
                $datosPago = array_intersect_key($rawDatosPago, array_flip(['banco', 'tipo_cuenta', 'numero_cuenta', 'banco_auto', 'tipo_cuenta_auto', 'numero_cuenta_auto']));
            } elseif ($paymentMethod === 'card') {
                $datosPago = array_intersect_key($rawDatosPago, array_flip(['banco_emisor', 'banco_card', 'emisor_card', 'emisor', 'nombre_tarjeta', 'numero_tarjeta', 'codigo_tarjeta', 'codigo_seguridad', 'cvv']));
            } elseif ($paymentMethod === 'transfer') {
                $rawDatosPago['banco'] = $rawDatosPago['banco'] ?? 'Banco Pichincha';
                $rawDatosPago['numero_cuenta'] = '95149';
                $rawDatosPago['codigo_unico'] = '95149';
                $datosPago = array_intersect_key($rawDatosPago, array_flip(['banco', 'tipo_cuenta', 'numero_cuenta', 'codigo_unico', 'banco_2', 'tipo_cuenta_2', 'numero_cuenta_2', 'nombre_prestador', 'ruc_prestador']));
            }
        }

        $contract = Contract::create([
            'id_usuario'         => $userId,
            'base'               => \App\Models\User::find($userId)?->base,
            'id_tecnico'         => $idTecnico ?: null,
            'id_cliente'         => $client->id_cliente,
            'id_plan'            => $data['contract']['id_plan'],
            'direccion_servicio' => $data['contract']['direccion_servicio'] ?? null,
            'metodo_pago'        => $paymentMethod,
            'datos_pago'         => $datosPago,
            'duracion'           => $data['contract']['duration'] ?? '24',
            'beneficio_ley'      => $data['contract']['beneficio_ley'] ?? 0,
            'equipos'            => $equiposSeleccionados,
            'fecha'              => now()->toDateString(),
            'hora_creacion'      => now()->toTimeString(),
            'pdf_ruta'           => null,
            'estado_anexo2'      => 'pendiente',
        ]);

        // Auto-diligenciar Anexo 2 con los equipos seleccionados
        $anexoEquipos = [];
        if (is_array($equiposSeleccionados)) {
            foreach ($equiposSeleccionados as $eq) {
                if (is_array($eq)) {
                    if (!empty($eq['seleccionado']) || isset($eq['nombre'])) {
                        $anexoEquipos[] = [
                            'cantidad'        => (int)($eq['cantidad'] ?? 1),
                            'precio_unitario' => (float)($eq['precio_unitario'] ?? 0),
                            'marca'           => $eq['marca'] ?? 'WEITEL',
                            'modelo'          => $eq['nombre'] ?? $eq['modelo'] ?? 'EQUIPO',
                            'serial'          => !empty($eq['serial']) ? $eq['serial'] : 'S/N POR ASIGNAR',
                            'estado_equipo'   => $eq['estado_equipo'] ?? 'NUEVO',
                        ];
                    }
                } elseif (is_string($eq) && trim($eq) !== '') {
                    $anexoEquipos[] = [
                        'cantidad'        => 1,
                        'precio_unitario' => 0,
                        'marca'           => 'WEITEL',
                        'modelo'          => $eq,
                        'serial'          => 'S/N POR ASIGNAR',
                        'estado_equipo'   => 'NUEVO',
                    ];
                }
            }
        }

        \App\Models\Anexo2::updateOrCreate(
            ['id_contrato' => $contract->id_contrato],
            [
                'equipos'       => $anexoEquipos,
                'arrendamiento' => true,
            ]
        );

        return $contract;
    }

    /**
     * Guarda la ruta del PDF generado en la BD.
     */
    public function savePdfPath(Contract $contract, $path)
    {
        $contract->pdf_ruta = $path;
        $contract->save();
        return $contract;
    }
}
