<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PersonalController extends Controller
{
    public function index()
    {
        $personal = User::orderBy('id', 'desc')->get();
        return view('personal.index', compact('personal'));
    }

    public function create()
    {
        return view('personal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cedula' => 'required|string|digits:10|unique:users',
            'role' => 'required|in:administrador,administrativo,tecnico',
            'base' => ['nullable', 'required_unless:role,administrador', Rule::in(User::BASES)],
        ], [
            'base.required_unless' => 'La base es obligatoria para administrativos y técnicos.',
            'cedula.unique' => 'Esta cédula ya está registrada.',
            'cedula.digits' => 'La cédula debe tener 10 dígitos.'
        ]);

        User::create([
            'name' => $request->name,
            'cedula' => $request->cedula,
            'role' => $request->role,
            'base' => $request->base ?: null,
        ]);

        return redirect()->route('personal.index')->with('success', 'Personal creado exitosamente.');
    }

    public function edit($id)
    {
        $persona = User::findOrFail($id);
        return view('personal.edit', compact('persona'));
    }

    public function update(Request $request, $id)
    {
        $persona = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'cedula' => ['required', 'string', 'digits:10', Rule::unique('users')->ignore($persona->id)],
            'role' => 'required|in:administrador,administrativo,tecnico',
            'base' => ['nullable', 'required_unless:role,administrador', Rule::in(User::BASES)],
        ], [
            'base.required_unless' => 'La base es obligatoria para administrativos y técnicos.',
            'cedula.unique' => 'Esta cédula ya está registrada.',
            'cedula.digits' => 'La cédula debe tener 10 dígitos.'
        ]);

        $persona->update([
            'name' => $request->name,
            'cedula' => $request->cedula,
            'role' => $request->role,
            'base' => $request->base ?: null,
        ]);

        // Los contratos antiguos de este usuario que aún no tienen base heredan la asignada
        if ($persona->base) {
            $persona->contracts()->whereNull('base')->update(['base' => $persona->base]);
        }

        return redirect()->route('personal.index')->with('success', 'Personal actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $persona = User::findOrFail($id);

        // Evitar que el administrador se elimine a sí mismo
        if ($persona->id == auth()->id()) {
            return redirect()->route('personal.index')->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $persona->delete();

        return redirect()->route('personal.index')->with('success', 'Personal eliminado exitosamente.');
    }
}
