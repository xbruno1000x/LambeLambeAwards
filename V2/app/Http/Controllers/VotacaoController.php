<?php

namespace App\Http\Controllers;

use App\Models\Edicao;
use App\Models\Categoria;
use App\Models\Voto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VotacaoController extends Controller
{
    public function index(Request $request)
    {
        $edicaoAtiva = Edicao::with(['categorias.indicados'])->where('ativa', true)->first();
        
        if (!$edicaoAtiva) {
            return view('votacao', ['edicaoAtiva' => null, 'message' => 'Nenhuma edição ativa no momento.']);
        }

        if (!$edicaoAtiva->votacao_aberta) {
            return view('votacao', ['edicaoAtiva' => $edicaoAtiva, 'message' => 'A votação ainda não está aberta.']);
        }

        // Gerar ou recuperar token do votante
        $voterToken = $request->cookie('voter_token');
        if (!$voterToken) {
            $voterToken = Str::uuid()->toString();
        }

        // Votação ilimitada - nenhuma categoria marcada como votada
        $categoriasVotadas = [];

        return response()
            ->view('votacao', compact('edicaoAtiva', 'categoriasVotadas'))
            ->cookie('voter_token', $voterToken, 60 * 24 * 365); // 1 ano
    }

    public function votar(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'indicado_id' => 'required|exists:indicados,id',
        ]);

        $categoria = Categoria::with('edicao')->findOrFail($request->categoria_id);
        
        // Verificar se a votação está aberta
        if (!$categoria->edicao->votacao_aberta) {
            return back()->with('error', 'A votação está fechada.');
        }

        // Recuperar ou gerar token do votante
        $voterToken = $request->cookie('voter_token');
        if (!$voterToken) {
            $voterToken = Str::uuid()->toString();
        }

        // Votação ilimitada - permitir múltiplos votos
        // Registrar voto
        Voto::create([
            'categoria_id' => $request->categoria_id,
            'indicado_id' => $request->indicado_id,
            'voter_token' => $voterToken,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()
            ->with('success', 'Voto registrado com sucesso!')
            ->cookie('voter_token', $voterToken, 60 * 24 * 365);
    }
}
