<?php

namespace App\Http\Controllers;

use App\Models\Edicao;
use App\Models\Vencedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VencedorController extends Controller
{
    public function index()
    {
        $edicoes = Edicao::with(['vencedores' => function($query) {
                $query->join('categorias', 'vencedores.categoria_id', '=', 'categorias.id')
                    ->orderBy('categorias.ordem', 'asc')
                    ->select('vencedores.*');
            }, 'vencedores.categoria.indicados', 'vencedores.indicado'])
            ->whereHas('vencedores')
            ->orderBy('ano', 'desc')
            ->get();
        
        // Calcular porcentagem de votos para cada vencedor e buscar detalhes completos
        foreach ($edicoes as $edicao) {
            foreach ($edicao->vencedores as $vencedor) {
                $totalVotosCategoria = DB::table('votos')
                    ->where('categoria_id', $vencedor->categoria_id)
                    ->count();
                
                if ($totalVotosCategoria > 0) {
                    $vencedor->porcentagem = round(($vencedor->total_votos / $totalVotosCategoria) * 100, 1);
                } else {
                    $vencedor->porcentagem = 0;
                }
                
                // Buscar todos os indicados da categoria com contagem de votos
                $vencedor->todosIndicados = $vencedor->categoria->indicados->map(function($indicado) use ($totalVotosCategoria) {
                    $votosIndicado = DB::table('votos')
                        ->where('indicado_id', $indicado->id)
                        ->count();
                    
                    $indicado->total_votos = $votosIndicado;
                    $indicado->porcentagem = $totalVotosCategoria > 0 
                        ? round(($votosIndicado / $totalVotosCategoria) * 100, 1) 
                        : 0;
                    
                    return $indicado;
                })->sortByDesc('total_votos');
                
                $vencedor->total_votos_categoria = $totalVotosCategoria;
            }
        }
        
        return view('vencedores', compact('edicoes'));
    }
}
