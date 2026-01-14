<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edicao;
use App\Models\Categoria;
use App\Models\Indicado;
use App\Models\Voto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $edicaoAtiva = Edicao::ativa();
        $totalEdicoes = Edicao::count();
        $totalCategorias = Categoria::count();
        $totalIndicados = Indicado::count();
        $totalVotos = Voto::count();

        return view('admin.dashboard', compact(
            'edicaoAtiva',
            'totalEdicoes',
            'totalCategorias',
            'totalIndicados',
            'totalVotos'
        ));
    }
}
