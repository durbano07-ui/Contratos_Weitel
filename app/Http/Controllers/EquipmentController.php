<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $search    = $request->get('search');
        $categoria = $request->get('categoria');

        $query = Equipment::query();

        if ($search) {
            $query->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
        }

        if ($categoria) {
            $query->where('categoria', $categoria);
        }

        $equipos        = $query->orderBy('categoria')->orderBy('nombre')->paginate(15)->withQueryString();
        $total_equipos  = Equipment::count();
        $stock_bajo     = Equipment::whereColumn('stock', '<=', 'stock_minimo')->count();
        $categorias     = Equipment::select('categoria')->distinct()->orderBy('categoria')->pluck('categoria');

        return view('equipos.index', compact('equipos', 'total_equipos', 'stock_bajo', 'categorias', 'search', 'categoria'));
    }

    public function create()
    {
        $categorias = Equipment::select('categoria')->distinct()->orderBy('categoria')->pluck('categoria');
        return view('equipos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'       => 'required|string|max:150',
            'categoria'    => 'required|string|max:80',
            'stock'        => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'unidad'       => 'required|string|max:30',
            'descripcion'  => 'nullable|string|max:500',
        ]);

        $equipo = Equipment::create($data);

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Equipo Creado',
            'module'  => 'Inventario',
            'details' => "Equipo '{$equipo->nombre}' agregado con stock inicial de {$equipo->stock} {$equipo->unidad}",
        ]);

        return redirect()->route('equipos.index')->with('success', 'Equipo registrado exitosamente.');
    }

    public function edit($id)
    {
        $equipo     = Equipment::findOrFail($id);
        $categorias = Equipment::select('categoria')->distinct()->orderBy('categoria')->pluck('categoria');
        return view('equipos.edit', compact('equipo', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $equipo = Equipment::findOrFail($id);

        $data = $request->validate([
            'nombre'       => 'required|string|max:150',
            'categoria'    => 'required|string|max:80',
            'stock'        => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'unidad'       => 'required|string|max:30',
            'descripcion'  => 'nullable|string|max:500',
        ]);

        $stockAnterior = $equipo->stock;
        $equipo->update($data);

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Equipo Actualizado',
            'module'  => 'Inventario',
            'details' => "'{$equipo->nombre}': stock {$stockAnterior} → {$equipo->stock} {$equipo->unidad}",
        ]);

        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $equipo = Equipment::findOrFail($id);

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Equipo Eliminado',
            'module'  => 'Inventario',
            'details' => "Equipo '{$equipo->nombre}' eliminado del inventario",
        ]);

        $equipo->delete();

        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado del inventario.');
    }
}
