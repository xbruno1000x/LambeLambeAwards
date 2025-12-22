<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VotacaoController;
use App\Http\Controllers\VencedorController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EdicaoController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\IndicadoController;
use App\Http\Controllers\Admin\VotoController;

// Rotas Públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sobre', [HomeController::class, 'sobre'])->name('sobre');
Route::get('/indicados', [HomeController::class, 'indicados'])->name('indicados');
Route::get('/vencedores', [VencedorController::class, 'index'])->name('vencedores');

// Votação
Route::get('/votacao', [VotacaoController::class, 'index'])->name('votacao');
Route::post('/votacao', [VotacaoController::class, 'votar'])->name('votacao.votar');

// Admin - Login
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin - Rotas Protegidas
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Edições
    Route::resource('edicoes', EdicaoController::class)->parameters(['edicoes' => 'edicao']);
    Route::post('edicoes/{edicao}/toggle-ativa', [EdicaoController::class, 'toggleAtiva'])->name('edicoes.toggle-ativa');
    Route::post('edicoes/{edicao}/toggle-votacao', [EdicaoController::class, 'toggleVotacao'])->name('edicoes.toggle-votacao');
    Route::post('edicoes/{edicao}/finalizar', [EdicaoController::class, 'finalizarVotacao'])->name('edicoes.finalizar');
    
    // Categorias
    Route::resource('categorias', CategoriaController::class);
    
    // Indicados
    Route::resource('indicados', IndicadoController::class);
    
    // Votos
    Route::get('votos', [VotoController::class, 'index'])->name('votos.index');
    Route::get('votos/resultados', [VotoController::class, 'resultados'])->name('votos.resultados');
});
