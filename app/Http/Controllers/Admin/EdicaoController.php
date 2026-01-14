<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edicao;
use App\Models\Vencedor;
use Illuminate\Http\Request;

class EdicaoController extends Controller
{
    public function index()
    {
        $edicoes = Edicao::withCount(['categorias', 'vencedores'])
            ->orderBy('ano', 'desc')
            ->get();
        
        return view('admin.edicoes.index', compact('edicoes'));
    }

    public function create()
    {
        return view('admin.edicoes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ano' => 'required|integer|min:2000|max:2100|unique:edicoes,ano',
            'titulo' => 'nullable|string|max:255',
        ]);

        Edicao::create($request->only(['ano', 'titulo']));

        return redirect()->route('admin.edicoes.index')
            ->with('success', 'Edição criada com sucesso!');
    }

    public function show(Edicao $edicao)
    {
        $edicao->load(['categorias.indicados', 'categorias.votos']);
        
        return view('admin.edicoes.show', compact('edicao'));
    }

    public function edit(Edicao $edicao)
    {
        return view('admin.edicoes.edit', compact('edicao'));
    }

    public function update(Request $request, Edicao $edicao)
    {
        $request->validate([
            'ano' => 'required|integer|min:2000|max:2100|unique:edicoes,ano,' . $edicao->id,
            'titulo' => 'nullable|string|max:255',
        ]);

        $edicao->update($request->only(['ano', 'titulo']));

        return redirect()->route('admin.edicoes.index')
            ->with('success', 'Edição atualizada com sucesso!');
    }

    public function destroy(Edicao $edicao)
    {
        $edicao->delete();

        return redirect()->route('admin.edicoes.index')
            ->with('success', 'Edição excluída com sucesso!');
    }

    public function toggleAtiva(Edicao $edicao)
    {
        // Desativar todas as outras edições
        if (!$edicao->ativa) {
            Edicao::where('id', '!=', $edicao->id)->update(['ativa' => false]);
        }
        
        $edicao->update(['ativa' => !$edicao->ativa]);

        return back()->with('success', 'Status da edição atualizado!');
    }

    public function toggleVotacao(Edicao $edicao)
    {
        $edicao->update(['votacao_aberta' => !$edicao->votacao_aberta]);

        return back()->with('success', 'Status da votação atualizado!');
    }

    public function finalizarVotacao(Edicao $edicao)
    {
        // Fechar votação
        $edicao->update(['votacao_aberta' => false]);

        // Calcular vencedores
        foreach ($edicao->categorias as $categoria) {
            $indicadoVencedor = $categoria->indicados()
                ->withCount('votos')
                ->orderBy('votos_count', 'desc')
                ->first();

            if ($indicadoVencedor) {
                Vencedor::updateOrCreate(
                    [
                        'edicao_id' => $edicao->id,
                        'categoria_id' => $categoria->id,
                    ],
                    [
                        'indicado_id' => $indicadoVencedor->id,
                        'total_votos' => $indicadoVencedor->votos_count,
                    ]
                );
            }
        }

        return back()->with('success', 'Votação finalizada e vencedores calculados!');
    }
}
