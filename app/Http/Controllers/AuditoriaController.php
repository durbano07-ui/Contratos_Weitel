<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;
use App\Models\Contract;
use App\Models\User;
use Carbon\Carbon;

class AuditoriaController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        // Totales de auditoria pura
        $eventos_totales = AuditLog::count();
        
        // Usuarios dados de baja en el periodo seleccionado (o en general si se prefiere, pero el usuario pidió por mes)
        $bajas_periodo = AuditLog::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('action', 'like', '%Baja%')
            ->count();

        $usuarios_activos = User::count() ?: 1;
        
        $ultima_actividad = AuditLog::latest()->first()->created_at ?? now();
        $diff = now()->diff($ultima_actividad);
        $ultima_actividad_formatted = "Hace " . ($diff->h > 0 ? $diff->h.'h ' : '') . $diff->i . "m";

        // Ingresos Mensuales
        $ingresos_mensuales = Contract::join('internet_plans', 'contracts.id_plan', '=', 'internet_plans.id_plan')->sum('internet_plans.precio');
        if ($ingresos_mensuales >= 1000) {
            $ingresos_mensuales_str = number_format($ingresos_mensuales / 1000, 1) . 'k';
        } else {
            $ingresos_mensuales_str = number_format($ingresos_mensuales, 2);
        }

        // Logs filtrados
        $query = AuditLog::with('user')->latest();
        
        if ($month) {
            $query->whereMonth('created_at', $month);
        }
        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $logs = $query->paginate(15)->appends($request->all());

        // Años disponibles para el filtro
        $years = AuditLog::selectRaw('YEAR(created_at) as year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('auditoria.index', compact(
            'eventos_totales', 
            'bajas_periodo', 
            'usuarios_activos', 
            'ultima_actividad_formatted', 
            'ingresos_mensuales_str', 
            'logs',
            'month',
            'year',
            'years'
        ));
    }

    public function exportCsv(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $query = AuditLog::with('user')->latest();
        
        if ($month) {
            $query->whereMonth('created_at', $month);
        }
        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $logs = $query->get();

        $filename = "logs_auditoria_{$year}_{$month}.csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Fecha', 'Hora', 'Usuario', 'Accion', 'Modulo', 'Detalles'];

        $callback = function() use($logs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('Y-m-d'),
                    $log->created_at->format('H:i:s'),
                    $log->user->name ?? 'Sistema',
                    $log->action,
                    $log->module,
                    $log->details
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
