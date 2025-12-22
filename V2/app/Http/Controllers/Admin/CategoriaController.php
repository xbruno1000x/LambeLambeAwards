<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Edicao;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with('edicao')
            ->withCount('indicados')
            ->orderBy('edicao_id', 'desc')
            ->orderBy('ordem')
            ->get();
        
        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        $edicoes = Edicao::orderBy('ano', 'desc')->get();
        return view('admin.categorias.create', compact('edicoes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'edicao_id' => 'required|exists:edicoes,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ordem' => 'nullable|integer|min:0',
        ]);

        Categoria::create($request->only(['edicao_id', 'nome', 'descricao', 'ordem']));

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function show(Categoria $categoria)
    {
        $categoria->load(['indicados.votos', 'edicao']);
        
        // Calcular votos por indicado
        $indicadosComVotos = $categoria->indicados->map(function ($indicado) {
            $indicado->total_votos = $indicado->votos->count();
            return $indicado;
        })->sortByDesc('total_votos');

        return view('admin.categorias.show', compact('categoria', 'indicadosComVotos'));
    }

    public function edit(Categoria $categoria)
    {
        $edicoes = Edicao::orderBy('ano', 'desc')->get();
        return view('admin.categorias.edit', compact('categoria', 'edicoes'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'edicao_id' => 'required|exists:edicoes,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ordem' => 'nullable|integer|min:0',
        ]);

        $categoria->update($request->only(['edicao_id', 'nome', 'descricao', 'ordem']));

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}
