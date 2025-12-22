<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Indicado;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndicadoController extends Controller
{
    public function index()
    {
        $indicados = Indicado::with('categoria.edicao')
            ->orderBy('categoria_id')
            ->get();
        
        return view('admin.indicados.index', compact('indicados'));
    }

    public function create()
    {
        $categorias = Categoria::with('edicao')
            ->orderBy('edicao_id', 'desc')
            ->get();
        return view('admin.indicados.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['categoria_id', 'nome', 'descricao']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('indicados', 'public');
        }

        Indicado::create($data);

        return redirect()->route('admin.indicados.index')
            ->with('success', 'Indicado criado com sucesso!');
    }

    public function show(Indicado $indicado)
    {
        $indicado->load(['categoria.edicao', 'votos']);
        return view('admin.indicados.show', compact('indicado'));
    }

    public function edit(Indicado $indicado)
    {
        $categorias = Categoria::with('edicao')
            ->orderBy('edicao_id', 'desc')
            ->get();
        return view('admin.indicados.edit', compact('indicado', 'categorias'));
    }

    public function update(Request $request, Indicado $indicado)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['categoria_id', 'nome', 'descricao']);

        if ($request->hasFile('foto')) {
            // Deletar foto antiga
            if ($indicado->foto) {
                Storage::disk('public')->delete($indicado->foto);
            }
            $data['foto'] = $request->file('foto')->store('indicados', 'public');
        }

        $indicado->update($data);

        return redirect()->route('admin.indicados.index')
            ->with('success', 'Indicado atualizado com sucesso!');
    }

    public function destroy(Indicado $indicado)
    {
        if ($indicado->foto) {
            Storage::disk('public')->delete($indicado->foto);
        }
        
        $indicado->delete();

        return redirect()->route('admin.indicados.index')
            ->with('success', 'Indicado excluído com sucesso!');
    }
}
