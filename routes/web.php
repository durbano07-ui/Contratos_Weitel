<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\DurationController;
use App\Http\Controllers\EmailDomainController;

Route::get('/', function () {
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login');
    }

    return redirect()->route($user->isTecnico() ? 'tecnico.index' : 'contracts.index');
});

// -------------------------------------------------------
// Autenticación (solo usuarios no logueados)
// -------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// -------------------------------------------------------
// Rutas compartidas (SOLO ADMINISTRADOR Y ADMINISTRATIVO)
// -------------------------------------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Estas rutas NO son para el técnico.
    Route::middleware(['role:administrador,administrativo'])->group(function () {
        // Contratos: ambos roles pueden ver y crear
        Route::get('/contratos', [ContractController::class, 'index'])->name('contracts.index');
        Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
        Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
        Route::get('/contracts/{id}/pdf', [ContractController::class, 'downloadPdf'])->name('contracts.pdf');
        Route::get('/contracts/{id}/pdf-anexos', [ContractController::class, 'downloadAnexosPdf'])->name('contracts.anexos.pdf');

        // Contratos: ambos roles pueden editar (el administrativo solo los suyos)
        Route::get('/contracts/{id}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
        Route::put('/contracts/{id}', [ContractController::class, 'update'])->name('contracts.update');

        // Clientes: ambos roles pueden ver
        Route::get('/clientes', [ClientController::class, 'index'])->name('clientes.index');
    });
});


// -------------------------------------------------------
// Rutas EXCLUSIVAS del Administrador
// -------------------------------------------------------
Route::middleware(['auth', 'role:administrador'])->group(function () {

    // Contratos: eliminar solo para administrador
    Route::delete('/contracts/{id}', [ContractController::class, 'destroy'])->name('contracts.destroy');

    // Clientes: editar/actualizar/dar de baja (solo Administrador)
    Route::get('/clientes/{id}/edit', [ClientController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{id}', [ClientController::class, 'update'])->name('clientes.update');
    Route::post('/clientes/{id}/baja', [ClientController::class, 'darDeBaja'])->name('clientes.baja');
    Route::post('/clientes/{id}/reactivar', [ClientController::class, 'reactivar'])->name('clientes.reactivar');

    // Personal (Gestión de Personal de Trabajo)
    Route::get('/personal', [PersonalController::class, 'index'])->name('personal.index');
    Route::get('/personal/create', [PersonalController::class, 'create'])->name('personal.create');
    Route::post('/personal', [PersonalController::class, 'store'])->name('personal.store');
    Route::get('/personal/{id}/edit', [PersonalController::class, 'edit'])->name('personal.edit');
    Route::put('/personal/{id}', [PersonalController::class, 'update'])->name('personal.update');
    Route::delete('/personal/{id}', [PersonalController::class, 'destroy'])->name('personal.destroy');

    // Planes de Internet (CRUD)
    Route::get('/planes', [PlanController::class, 'index'])->name('planes.index');
    Route::get('/planes/create', [PlanController::class, 'create'])->name('planes.create');
    Route::post('/planes', [PlanController::class, 'store'])->name('planes.store');
    Route::get('/planes/{id}/edit', [PlanController::class, 'edit'])->name('planes.edit');
    Route::put('/planes/{id}', [PlanController::class, 'update'])->name('planes.update');
    Route::delete('/planes/{id}', [PlanController::class, 'destroy'])->name('planes.destroy');

    // Duraciones de contrato (meses disponibles)
    Route::get('/duraciones', [DurationController::class, 'index'])->name('duraciones.index');
    Route::post('/duraciones', [DurationController::class, 'store'])->name('duraciones.store');
    Route::delete('/duraciones/{id}', [DurationController::class, 'destroy'])->name('duraciones.destroy');

    // Extensiones de email (dominios disponibles para el correo del cliente)
    Route::get('/extensiones', [EmailDomainController::class, 'index'])->name('extensiones.index');
    Route::post('/extensiones', [EmailDomainController::class, 'store'])->name('extensiones.store');
    Route::put('/extensiones/{id}', [EmailDomainController::class, 'update'])->name('extensiones.update');
    Route::delete('/extensiones/{id}', [EmailDomainController::class, 'destroy'])->name('extensiones.destroy');

    // Inventario de Equipos (CRUD)
    Route::get('/equipos', [EquipmentController::class, 'index'])->name('equipos.index');
    Route::get('/equipos/create', [EquipmentController::class, 'create'])->name('equipos.create');
    Route::post('/equipos', [EquipmentController::class, 'store'])->name('equipos.store');
    Route::get('/equipos/{id}/edit', [EquipmentController::class, 'edit'])->name('equipos.edit');
    Route::put('/equipos/{id}', [EquipmentController::class, 'update'])->name('equipos.update');
    Route::delete('/equipos/{id}', [EquipmentController::class, 'destroy'])->name('equipos.destroy');

    // Auditoría
    Route::get('/auditoria', [AuditoriaController::class, 'index'])->name('auditoria.index');
    Route::get('/auditoria/export', [AuditoriaController::class, 'exportCsv'])->name('auditoria.export');
});

// -------------------------------------------------------
// API para listados dinámicos
// -------------------------------------------------------
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/api/plans/by-type/{id}', [PlanController::class, 'getByTipo'])
        ->whereNumber('id')
        ->name('api.plans.by-type');

    Route::get('/api/clientes/search', [ClientController::class, 'search'])
        ->name('api.clientes.search');
});

// -------------------------------------------------------
// Rutas EXCLUSIVAS del Técnico (jefe de grupo)
// -------------------------------------------------------
Route::middleware(['auth', 'role:tecnico'])->group(function () {
    Route::get('/tecnico/instalaciones', [TecnicoController::class, 'index'])->name('tecnico.index');
    Route::get('/tecnico/instalaciones/{id}/anexo2', [TecnicoController::class, 'editAnexo2'])->name('tecnico.anexo2');
    Route::post('/tecnico/instalaciones/{id}/anexo2', [TecnicoController::class, 'storeAnexo2'])->name('tecnico.anexo2.store');
    Route::get('/tecnico/instalaciones/{id}/pdf', [TecnicoController::class, 'downloadAnexosPdf'])->name('tecnico.pdf');
});
