<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'cedula' => ['required', 'digits:10'],
        ], [
            'cedula.required' => 'El número de cédula es obligatorio.',
            'cedula.digits'   => 'La cédula debe tener exactamente 10 dígitos.',
        ]);

        $cedula = $request->cedula;

        // Buscar usuario por cédula
        $user = User::where('cedula', $cedula)->first();

        if (!$user) {
            if (!$this->validarCedulaEcuatoriana($cedula)) {
                return back()->withErrors([
                    'cedula' => 'El número de cédula ingresado no es válido.',
                ])->onlyInput('cedula');
            }

            return back()->withErrors([
                'cedula' => 'No existe un usuario registrado con ese número de cédula.',
            ])->onlyInput('cedula');
        }

        // Iniciar sesión
        Auth::login($user);
        $request->session()->regenerate();

        // Registrar evento de auditoría
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Inicio de Sesión',
            'module'  => 'Sistema / Auth',
            'details' => 'Acceso correcto al panel administrativo mediante cédula',
        ]);

        // Redirigir según rol
        if ($user->isTecnico()) {
            return redirect()->route('tecnico.index');
        }

        return redirect()->route('contracts.index');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            \App\Models\AuditLog::create([
                'user_id' => Auth::id(),
                'action'  => 'Cierre de Sesión',
                'module'  => 'Sistema / Auth',
                'details' => 'Usuario cerró su sesión de forma segura',
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Valida una cédula ecuatoriana usando el algoritmo oficial.
     * - 10 dígitos
     * - 2 primeros dígitos: provincia válida (01-24)
     * - 3er dígito: menor a 6
     * - Dígito verificador (posición 10) calculado con módulo 10
     */
    private function validarCedulaEcuatoriana(string $cedula): bool
    {
        if (strlen($cedula) !== 10 || !ctype_digit($cedula)) {
            return false;
        }

        $provincia = (int) substr($cedula, 0, 2);
        if ($provincia < 1 || $provincia > 24) {
            return false;
        }

        $tercerDigito = (int) $cedula[2];
        if ($tercerDigito >= 6) {
            return false;
        }

        // Cálculo del dígito verificador
        $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
        $suma = 0;

        for ($i = 0; $i < 9; $i++) {
            $valor = (int) $cedula[$i] * $coeficientes[$i];
            if ($valor >= 10) {
                $valor -= 9;
            }
            $suma += $valor;
        }

        $digitoVerificador = ($suma % 10 === 0) ? 0 : (10 - ($suma % 10));

        return $digitoVerificador === (int) $cedula[9];
    }
}
