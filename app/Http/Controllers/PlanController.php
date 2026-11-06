<?php

namespace App\Http\Controllers;

use App\Models\InternetPlan;
use App\Models\InternetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    // -------------------------------------------------------
    // Vista principal de planes (solo Administrador)
    // -------------------------------------------------------
    public function index()
    {
        $tipos  = InternetType::with('plans')->get();
        $planes = InternetPlan::with('type')->orderBy('precio', 'asc')->paginate(15);

        $total_planes   = InternetPlan::count();
        $total_ingresos = InternetPlan::join('contracts', 'internet_plans.id_plan', '=', 'contracts.id_plan')
                            ->sum('internet_plans.precio');

        return view('planes.index', compact('planes', 'tipos', 'total_planes', 'total_ingresos'));
    }

    public function create()
    {
        $tipos = InternetType::all();
        return view('planes.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_tipo'        => 'required|exists:internet_types,id_tipo',
            'nombre_plan'    => 'required|string|max:100',
            'precio'         => 'required|numeric|min:0',
            'precio_regular' => 'nullable|numeric|min:0',
            'es_promocional' => 'nullable|boolean',
            'velocidad'      => 'required|string|max:50',
        ]);
        $data['es_promocional'] = $request->boolean('es_promocional');

        InternetPlan::create($data);

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Plan Creado',
            'module'  => 'Planes de Internet',
            'details' => "Plan '{$data['nombre_plan']}' creado a \${$data['precio']}",
        ]);

        return redirect()->route('planes.index')->with('success', 'Plan creado exitosamente.');
    }

    public function edit($id)
    {
        $plan  = InternetPlan::findOrFail($id);
        $tipos = InternetType::all();
        return view('planes.edit', compact('plan', 'tipos'));
    }

    public function update(Request $request, $id)
    {
        $plan = InternetPlan::findOrFail($id);

        $data = $request->validate([
            'id_tipo'        => 'required|exists:internet_types,id_tipo',
            'nombre_plan'    => 'required|string|max:100',
            'precio'         => 'required|numeric|min:0',
            'precio_regular' => 'nullable|numeric|min:0',
            'es_promocional' => 'nullable|boolean',
            'velocidad'      => 'required|string|max:50',
        ]);
        $data['es_promocional'] = $request->boolean('es_promocional');

        $plan->update($data);

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Plan Modificado',
            'module'  => 'Planes de Internet',
            'details' => "Plan ID {$id} actualizado a '{$data['nombre_plan']}'",
        ]);

        return redirect()->route('planes.index')->with('success', 'Plan actualizado correctamente.');
    }

    public function destroy($id)
    {
        $plan = InternetPlan::findOrFail($id);

        // Verificar que no tiene contratos activos
        if ($plan->contracts()->count() > 0) {
            return redirect()->route('planes.index')
                ->with('error', "No se puede eliminar: el plan '{$plan->nombre_plan}' tiene contratos asociados.");
        }

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Plan Eliminado',
            'module'  => 'Planes de Internet',
            'details' => "Plan '{$plan->nombre_plan}' eliminado del sistema",
        ]);

        $plan->delete();

        return redirect()->route('planes.index')->with('success', 'Plan eliminado.');
    }

    // -------------------------------------------------------
    // API: obtener planes filtrados por tipo de conexión
    // -------------------------------------------------------
    public function getByTipo($id)
    {
        $planes = InternetPlan::where('id_tipo', $id)
            ->select('id_plan', 'nombre_plan', 'precio', 'precio_regular', 'es_promocional', 'velocidad')
            ->orderBy('precio', 'asc')
            ->get();

        return response()->json($planes);
    }
}
