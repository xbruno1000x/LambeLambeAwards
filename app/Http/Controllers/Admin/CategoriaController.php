<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Edicao;
use App\Models\Indicado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function create(Request $request)
    {
        $edicoes = Edicao::orderBy('ano', 'desc')->get();
        $edicaoSelecionada = $request->query('edicao_id');
        
        // Buscar categorias de edições anteriores para copiar
        $categoriasAnteriores = Categoria::with('edicao')
            ->orderBy('edicao_id', 'desc')
            ->orderBy('nome')
            ->get()
            ->groupBy(function($cat) {
                return $cat->edicao->ano . ' - ' . ($cat->edicao->titulo ?? 'Sem título');
            });
        
        // Buscar todos os indicados únicos por nome para reaproveitar
        $indicadosExistentes = Indicado::select('nome', DB::raw('MAX(id) as id'), DB::raw('MAX(foto) as foto'))
            ->groupBy('nome')
            ->orderBy('nome')
            ->get();
        
        return view('admin.categorias.create', compact('edicoes', 'edicaoSelecionada', 'categoriasAnteriores', 'indicadosExistentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'edicao_id' => 'required|exists:edicoes,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ordem' => 'nullable|integer|min:0',
            'indicados' => 'nullable|array',
            'indicados.*.nome' => 'required_with:indicados|string|max:255',
            'indicados.*.descricao' => 'nullable|string',
            'indicados.*.indicado_existente_id' => 'nullable|exists:indicados,id',
        ]);

        DB::transaction(function () use ($request) {
            $categoria = Categoria::create($request->only(['edicao_id', 'nome', 'descricao', 'ordem']));
            
            // Criar indicados se fornecidos
            if ($request->has('indicados')) {
                foreach ($request->indicados as $indicadoData) {
                    if (!empty($indicadoData['nome'])) {
                        $fotoPath = null;
                        
                        // Se está reaproveitando um indicado existente, copiar a foto
                        if (!empty($indicadoData['indicado_existente_id'])) {
                            $indicadoExistente = Indicado::find($indicadoData['indicado_existente_id']);
                            if ($indicadoExistente && $indicadoExistente->foto) {
                                $fotoPath = $indicadoExistente->foto;
                            }
                        }
                        
                        Indicado::create([
                            'categoria_id' => $categoria->id,
                            'nome' => $indicadoData['nome'],
                            'descricao' => $indicadoData['descricao'] ?? null,
                            'foto' => $fotoPath,
                        ]);
                    }
                }
            }
        });

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
        $categoria->load('indicados');
        
        // Buscar todos os indicados únicos por nome para reaproveitar
        $indicadosExistentes = Indicado::select('nome', DB::raw('MAX(id) as id'), DB::raw('MAX(foto) as foto'))
            ->groupBy('nome')
            ->orderBy('nome')
            ->get();
        
        return view('admin.categorias.edit', compact('categoria', 'edicoes', 'indicadosExistentes'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'edicao_id' => 'required|exists:edicoes,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ordem' => 'nullable|integer|min:0',
            'indicados' => 'nullable|array',
            'indicados.*.id' => 'nullable|exists:indicados,id',
            'indicados.*.nome' => 'required_with:indicados|string|max:255',
            'indicados.*.descricao' => 'nullable|string',
            'indicados.*.remover' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request, $categoria) {
            $categoria->update($request->only(['edicao_id', 'nome', 'descricao', 'ordem']));
            
            // Atualizar/criar/remover indicados
            if ($request->has('indicados')) {
                $indicadosIds = [];
                
                foreach ($request->indicados as $indicadoData) {
                    if (!empty($indicadoData['remover']) && !empty($indicadoData['id'])) {
                        // Remover indicado
                        Indicado::where('id', $indicadoData['id'])->delete();
                        continue;
                    }
                    
                    if (!empty($indicadoData['nome'])) {
                        if (!empty($indicadoData['id'])) {
                            // Atualizar indicado existente
                            $indicado = Indicado::find($indicadoData['id']);
                            if ($indicado) {
                                $indicado->update([
                                    'nome' => $indicadoData['nome'],
                                    'descricao' => $indicadoData['descricao'] ?? null,
                                ]);
                                $indicadosIds[] = $indicado->id;
                            }
                        } else {
                            // Criar novo indicado
                            $indicado = Indicado::create([
                                'categoria_id' => $categoria->id,
                                'nome' => $indicadoData['nome'],
                                'descricao' => $indicadoData['descricao'] ?? null,
                            ]);
                            $indicadosIds[] = $indicado->id;
                        }
                    }
                }
            }
        });

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
    
    /**
     * Duplicar uma categoria de uma edição anterior para a nova edição
     */
    public function duplicar(Request $request)
    {
        $request->validate([
            'categoria_origem_id' => 'required|exists:categorias,id',
            'edicao_destino_id' => 'required|exists:edicoes,id',
            'copiar_indicados' => 'nullable|boolean',
        ]);
        
        $categoriaOrigem = Categoria::with('indicados')->find($request->categoria_origem_id);
        $edicaoDestino = Edicao::find($request->edicao_destino_id);
        
        DB::transaction(function () use ($categoriaOrigem, $edicaoDestino, $request) {
            // Criar nova categoria
            $novaCategoria = Categoria::create([
                'edicao_id' => $edicaoDestino->id,
                'nome' => $categoriaOrigem->nome,
                'descricao' => $categoriaOrigem->descricao,
                'ordem' => $categoriaOrigem->ordem,
            ]);
            
            // Copiar indicados se solicitado
            if ($request->boolean('copiar_indicados')) {
                foreach ($categoriaOrigem->indicados as $indicado) {
                    Indicado::create([
                        'categoria_id' => $novaCategoria->id,
                        'nome' => $indicado->nome,
                        'descricao' => $indicado->descricao,
                        'foto' => $indicado->foto,
                    ]);
                }
            }
        });
        
        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria duplicada com sucesso para a edição ' . $edicaoDestino->ano . '!');
    }
}
