<?php

namespace App\Http\Controllers;

use App\Models\Edicao;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $edicaoAtiva = Edicao::ativa();
        
        return view('home', compact('edicaoAtiva'));
    }

    public function sobre()
    {
        return view('sobre');
    }

    public function indicados()
    {
        $edicaoAtiva = Edicao::with(['categorias.indicados'])->where('ativa', true)->first();
        
        return view('indicados', compact('edicaoAtiva'));
    }
}
