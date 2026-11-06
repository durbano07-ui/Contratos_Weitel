<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\EmailDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailDomainController extends Controller
{
    // -------------------------------------------------------
    // Extensiones de email disponibles (solo Administrador)
    // -------------------------------------------------------
    public function index()
    {
        $extensiones = EmailDomain::orderBy('dominio')->get()
            ->each(fn ($e) => $e->clientes_count = $e->clientesCount());

        return view('extensiones.index', compact('extensiones'));
    }

    public function store(Request $request)
    {
        $request->merge(['dominio' => EmailDomain::normalizar($request->input('dominio'))]);

        $data = $request->validate([
            'dominio' => [
                'required', 'max:100',
                'regex:/^[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*\.[a-z]{2,}$/',
                'unique:email_domains,dominio',
            ],
        ], [
            'dominio.required' => 'Ingrese una extensión.',
            'dominio.regex'    => 'Formato inválido. Ejemplo: gmail.com',
            'dominio.unique'   => 'Esa extensión ya existe.',
        ]);

        EmailDomain::create($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Extensión Creada',
            'module'  => 'Extensiones de Email',
            'details' => "Extensión @{$data['dominio']} agregada",
        ]);

        return redirect()->route('extensiones.index')->with('success', 'Extensión agregada.');
    }

    public function update(Request $request, $id)
    {
        $extension = EmailDomain::findOrFail($id);
        $request->merge(['dominio' => EmailDomain::normalizar($request->input('dominio'))]);

        $data = $request->validate([
            'dominio' => [
                'required', 'max:100',
                'regex:/^[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*\.[a-z]{2,}$/',
                'unique:email_domains,dominio,' . $extension->id,
            ],
        ], [
            'dominio.required' => 'Ingrese una extensión.',
            'dominio.regex'    => 'Formato inválido. Ejemplo: gmail.com',
            'dominio.unique'   => 'Esa extensión ya existe.',
        ]);

        $anterior = $extension->dominio;
        $extension->update($data);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Extensión Editada',
            'module'  => 'Extensiones de Email',
            'details' => "Extensión @{$anterior} cambiada a @{$data['dominio']}",
        ]);

        return redirect()->route('extensiones.index')->with('success', 'Extensión actualizada.');
    }

    public function destroy($id)
    {
        $extension = EmailDomain::findOrFail($id);

        if (EmailDomain::count() <= 1) {
            return redirect()->route('extensiones.index')
                ->with('error', 'Debe existir al menos una extensión de email.');
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Extensión Eliminada',
            'module'  => 'Extensiones de Email',
            'details' => "Extensión @{$extension->dominio} eliminada",
        ]);

        $extension->delete();

        return redirect()->route('extensiones.index')->with('success', 'Extensión eliminada.');
    }
}
