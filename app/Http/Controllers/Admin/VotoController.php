<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voto;
use App\Models\Edicao;
use App\Models\Categoria;
use Illuminate\Http\Request;

class VotoController extends Controller
{
    public function index(Request $request)
    {
        $edicaoId = $request->get('edicao_id');
        $categoriaId = $request->get('categoria_id');

        $query = Voto::with(['categoria.edicao', 'indicado']);

        if ($edicaoId) {
            $query->whereHas('categoria', function ($q) use ($edicaoId) {
                $q->where('edicao_id', $edicaoId);
            });
        }

        if ($categoriaId) {
            $query->where('categoria_id', $categoriaId);
        }

        $votos = $query->orderBy('created_at', 'desc')->paginate(50);
        $edicoes = Edicao::orderBy('ano', 'desc')->get();
        $categorias = $edicaoId 
            ? Categoria::where('edicao_id', $edicaoId)->get() 
            : collect();

        return view('admin.votos.index', compact('votos', 'edicoes', 'categorias', 'edicaoId', 'categoriaId'));
    }

    public function resultados(Request $request)
    {
        $edicaoId = $request->get('edicao_id');
        
        if (!$edicaoId) {
            $edicao = Edicao::ativa();
        } else {
            $edicao = Edicao::find($edicaoId);
        }

        $edicoes = Edicao::orderBy('ano', 'desc')->get();
        
        $resultados = [];
        if ($edicao) {
            foreach ($edicao->categorias as $categoria) {
                $indicadosComVotos = $categoria->indicados()
                    ->withCount('votos')
                    ->orderBy('votos_count', 'desc')
                    ->get();
                
                $resultados[$categoria->id] = [
                    'categoria' => $categoria,
                    'indicados' => $indicadosComVotos,
                    'total_votos' => $indicadosComVotos->sum('votos_count'),
                ];
            }
        }

        return view('admin.votos.resultados', compact('edicao', 'edicoes', 'resultados'));
    }
}
