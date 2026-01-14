<?php

namespace Database\Seeders;

use App\Models\Edicao;
use App\Models\Categoria;
use App\Models\Indicado;
use App\Models\Vencedor;
use App\Models\Voto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PrimeiraEdicaoSeeder extends Seeder
{
    /**
     * Criar votos simulados para um indicado
     */
    private function criarVotos($categoriaId, $indicadoId, $quantidade)
    {
        for ($i = 0; $i < $quantidade; $i++) {
            Voto::create([
                'categoria_id' => $categoriaId,
                'indicado_id' => $indicadoId,
                'voter_token' => Str::uuid(),
                'ip_address' => '127.0.0.' . rand(1, 255),
                'user_agent' => 'Seeder',
            ]);
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar ou buscar a edição 2024
        $edicao = Edicao::firstOrCreate(
            ['ano' => 2024],
            [
                'titulo' => 'Lambe Lambe Awards 2024 - 1ª Edição',
                'ativa' => false,
                'votacao_aberta' => false,
            ]
        );

        // Limpar dados existentes desta edição
        Voto::whereIn('categoria_id', Categoria::where('edicao_id', $edicao->id)->pluck('id'))->delete();
        Vencedor::where('edicao_id', $edicao->id)->delete();
        $categorias = Categoria::where('edicao_id', $edicao->id)->get();
        foreach ($categorias as $categoria) {
            Indicado::where('categoria_id', $categoria->id)->delete();
        }
        Categoria::where('edicao_id', $edicao->id)->delete();

        // ORDEM CORRETA: 1. Babaca, 2. Babaquice, 3. Casal, 4. Torcedor, 5-10. Resto

        // Categoria 1: Maior babaca do ano (PRINCIPAL PREMIAÇÃO)
        $categoria1 = Categoria::create([
            'edicao_id' => $edicao->id,
            'nome' => 'Maior babaca do ano',
            'ordem' => 1,
        ]);

        $indicados = [
            ['nome' => 'Bruno', 'descricao' => '', 'votos' => 11],
            ['nome' => 'Amaduro', 'descricao' => '', 'votos' => 7],
            ['nome' => 'André', 'descricao' => '', 'votos' => 2],
            ['nome' => 'Luiza', 'descricao' => '', 'votos' => 0],
        ];

        $vencedor = null;
        foreach ($indicados as $i) {
            $indicado = Indicado::create([
                'categoria_id' => $categoria1->id,
                'nome' => $i['nome'],
                'descricao' => $i['descricao'],
            ]);
            $this->criarVotos($categoria1->id, $indicado->id, $i['votos']);
            if ($i['votos'] == 11) $vencedor = $indicado;
        }

        Vencedor::create([
            'edicao_id' => $edicao->id,
            'categoria_id' => $categoria1->id,
            'indicado_id' => $vencedor->id,
            'total_votos' => 11,
        ]);

        // Categoria 2: Maior babaquice do ano
        $categoria2 = Categoria::create([
            'edicao_id' => $edicao->id,
            'nome' => 'Maior babaquice do ano',
            'ordem' => 2,
        ]);

        $indicados = [
            ['nome' => 'Luiza', 'descricao' => 'Por fingir estar grávida e fazer o Amaduro chorar', 'votos' => 5],
            ['nome' => 'Frank', 'descricao' => 'Nem pai você tem Bruno', 'votos' => 4],
            ['nome' => 'Bruno', 'descricao' => 'Ninguém está interessado nas suas tristezas não, para de jogar o clima lá em baixo', 'votos' => 3],
            ['nome' => 'Amaduro', 'descricao' => 'Por ligar para a Isabela no trabalho após o Fluminense perder para o Botafogo', 'votos' => 1],
        ];

        $vencedor = null;
        foreach ($indicados as $i) {
            $indicado = Indicado::create([
                'categoria_id' => $categoria2->id,
                'nome' => $i['nome'],
                'descricao' => $i['descricao'],
            ]);
            $this->criarVotos($categoria2->id, $indicado->id, $i['votos']);
            if ($i['votos'] == 5) $vencedor = $indicado;
        }

        Vencedor::create([
            'edicao_id' => $edicao->id,
            'categoria_id' => $categoria2->id,
            'indicado_id' => $vencedor->id,
            'total_votos' => 5,
        ]);

        // Categoria 3: Melhor casal do ano
        $categoria3 = Categoria::create([
            'edicao_id' => $edicao->id,
            'nome' => 'Melhor casal do ano',
            'ordem' => 3,
        ]);

        $indicados = [
            ['nome' => 'Alencar e Gabriela', 'descricao' => '', 'votos' => 9],
            ['nome' => 'Israel e Luiza', 'descricao' => '', 'votos' => 7],
            ['nome' => 'Frank e Livian', 'descricao' => '', 'votos' => 4],
            ['nome' => 'Nathan e Nicolle', 'descricao' => '', 'votos' => 2],
            ['nome' => 'Emanoel e Isabela', 'descricao' => '', 'votos' => 1],
        ];

        $vencedor = null;
        foreach ($indicados as $i) {
            $indicado = Indicado::create([
                'categoria_id' => $categoria3->id,
                'nome' => $i['nome'],
                'descricao' => $i['descricao'],
            ]);
            $this->criarVotos($categoria3->id, $indicado->id, $i['votos']);
            if ($i['votos'] == 9) $vencedor = $indicado;
        }

        Vencedor::create([
            'edicao_id' => $edicao->id,
            'categoria_id' => $categoria3->id,
            'indicado_id' => $vencedor->id,
            'total_votos' => 9,
        ]);

        // Categoria 4: Torcedor mais insuportável do ano
        $categoria4 = Categoria::create([
            'edicao_id' => $edicao->id,
            'nome' => 'Torcedor mais insuportável do ano',
            'ordem' => 4,
        ]);

        $indicados = [
            ['nome' => 'Amaduro', 'descricao' => '', 'votos' => 14],
            ['nome' => 'Alencar', 'descricao' => '', 'votos' => 1],
            ['nome' => 'Luiza', 'descricao' => '', 'votos' => 1],
            ['nome' => 'Isabela', 'descricao' => '', 'votos' => 0],
            ['nome' => 'Iuryck', 'descricao' => '', 'votos' => 0],
        ];

        $vencedor = null;
        foreach ($indicados as $i) {
            $indicado = Indicado::create([
                'categoria_id' => $categoria4->id,
                'nome' => $i['nome'],
                'descricao' => $i['descricao'],
            ]);
            $this->criarVotos($categoria4->id, $indicado->id, $i['votos']);
            if ($i['votos'] == 14) $vencedor = $indicado;
        }

        Vencedor::create([
            'edicao_id' => $edicao->id,
            'categoria_id' => $categoria4->id,
            'indicado_id' => $vencedor->id,
            'total_votos' => 14,
        ]);

        // Categoria 5: Assunto de maior irrelevância do ano
        $categoria5 = Categoria::create([
            'edicao_id' => $edicao->id,
            'nome' => 'Assunto de maior irrelevância do ano',
            'ordem' => 5,
        ]);

        $indicados = [
            ['nome' => 'Frank', 'descricao' => 'Por indicação de condicionador às 7h da manhã', 'votos' => 9],
            ['nome' => 'Frank', 'descricao' => 'Por Review de banheiro do Sesi', 'votos' => 4],
            ['nome' => 'Nathan', 'descricao' => 'Por destrinchar todo o caso P. Diddy', 'votos' => 4],
            ['nome' => 'Frank', 'descricao' => 'Por review sobre a sala que parecia grande mas era pequena no Sesi', 'votos' => 0],
        ];

        $vencedor = null;
        foreach ($indicados as $i) {
            $indicado = Indicado::create([
                'categoria_id' => $categoria5->id,
                'nome' => $i['nome'],
                'descricao' => $i['descricao'],
            ]);
            $this->criarVotos($categoria5->id, $indicado->id, $i['votos']);
            if ($i['votos'] == 9 && $vencedor === null) $vencedor = $indicado;
        }

        Vencedor::create([
            'edicao_id' => $edicao->id,
            'categoria_id' => $categoria5->id,
            'indicado_id' => $vencedor->id,
            'total_votos' => 9,
        ]);

        // Categoria 6: Figurinha do ano
        $categoria6 = Categoria::create([
            'edicao_id' => $edicao->id,
            'nome' => 'Figurinha do ano',
            'ordem' => 6,
        ]);

        $indicados = [
            ['nome' => 'AEEEEE NATHAAAAAAAAAAAAAN', 'descricao' => '', 'votos' => 4],
            ['nome' => 'Emanoel gordo', 'descricao' => '', 'votos' => 1],
            ['nome' => 'CACHORRINHO VAI SE FUDE FRANK JUNIOR', 'descricao' => '', 'votos' => 1],
            ['nome' => 'ERA PRA PAGAR???', 'descricao' => '', 'votos' => 0],
        ];

        $vencedor = null;
        foreach ($indicados as $i) {
            $indicado = Indicado::create([
                'categoria_id' => $categoria6->id,
                'nome' => $i['nome'],
                'descricao' => $i['descricao'],
            ]);
            $this->criarVotos($categoria6->id, $indicado->id, $i['votos']);
            if ($i['votos'] == 4 && $vencedor === null) $vencedor = $indicado;
        }

        Vencedor::create([
            'edicao_id' => $edicao->id,
            'categoria_id' => $categoria6->id,
            'indicado_id' => $vencedor->id,
            'total_votos' => 4,
        ]);

        // Categoria 7: Mais viado do ano
        $categoria7 = Categoria::create([
            'edicao_id' => $edicao->id,
            'nome' => 'Mais viado do ano',
            'ordem' => 7,
        ]);

        $indicados = [
            ['nome' => 'André', 'descricao' => '', 'votos' => 12],
            ['nome' => 'Nathan', 'descricao' => '', 'votos' => 2],
            ['nome' => 'Frank', 'descricao' => '', 'votos' => 0],
            ['nome' => 'Emanoel', 'descricao' => '', 'votos' => 0],
        ];

        $vencedor = null;
        foreach ($indicados as $i) {
            $indicado = Indicado::create([
                'categoria_id' => $categoria7->id,
                'nome' => $i['nome'],
                'descricao' => $i['descricao'],
            ]);
            $this->criarVotos($categoria7->id, $indicado->id, $i['votos']);
            if ($i['votos'] == 12) $vencedor = $indicado;
        }

        Vencedor::create([
            'edicao_id' => $edicao->id,
            'categoria_id' => $categoria7->id,
            'indicado_id' => $vencedor->id,
            'total_votos' => 12,
        ]);

        // Categoria 8: Melhor evento do ano
        $categoria8 = Categoria::create([
            'edicao_id' => $edicao->id,
            'nome' => 'Melhor evento do ano',
            'ordem' => 8,
        ]);

        $indicados = [
            ['nome' => 'Arraiá Lambe Lambe', 'descricao' => '', 'votos' => 7],
            ['nome' => 'Aniversário da Isabela', 'descricao' => '', 'votos' => 4],
            ['nome' => 'Maduropalooza', 'descricao' => '', 'votos' => 4],
            ['nome' => 'Ano Novo na casa do Iuryck', 'descricao' => '', 'votos' => 0],
            ['nome' => 'Aniversário da Luiza', 'descricao' => '', 'votos' => 0],
        ];

        $vencedor = null;
        foreach ($indicados as $i) {
            $indicado = Indicado::create([
                'categoria_id' => $categoria8->id,
                'nome' => $i['nome'],
                'descricao' => $i['descricao'],
            ]);
            $this->criarVotos($categoria8->id, $indicado->id, $i['votos']);
            if ($i['votos'] == 7) $vencedor = $indicado;
        }

        Vencedor::create([
            'edicao_id' => $edicao->id,
            'categoria_id' => $categoria8->id,
            'indicado_id' => $vencedor->id,
            'total_votos' => 7,
        ]);

        // Categoria 9: Notícia bombástica do ano
        $categoria9 = Categoria::create([
            'edicao_id' => $edicao->id,
            'nome' => 'Notícia bombástica do ano',
            'ordem' => 9,
        ]);

        $indicados = [
            ['nome' => 'Gabi contratada da Cazé TV', 'descricao' => '', 'votos' => 4],
            ['nome' => 'Nicolle saindo da Escravos Jeans', 'descricao' => '', 'votos' => 3],
            ['nome' => 'Luiza deixando de lecionar', 'descricao' => '', 'votos' => 2],
            ['nome' => 'Matheus aluno do Cefet', 'descricao' => '', 'votos' => 2],
            ['nome' => 'André com um emprego de verdade', 'descricao' => '', 'votos' => 1],
        ];

        $vencedor = null;
        foreach ($indicados as $i) {
            $indicado = Indicado::create([
                'categoria_id' => $categoria9->id,
                'nome' => $i['nome'],
                'descricao' => $i['descricao'],
            ]);
            $this->criarVotos($categoria9->id, $indicado->id, $i['votos']);
            if ($i['votos'] == 4 && $vencedor === null) $vencedor = $indicado;
        }

        Vencedor::create([
            'edicao_id' => $edicao->id,
            'categoria_id' => $categoria9->id,
            'indicado_id' => $vencedor->id,
            'total_votos' => 4,
        ]);

        // Categoria 10: Surpresa do ano
        $categoria10 = Categoria::create([
            'edicao_id' => $edicao->id,
            'nome' => 'Surpresa do ano',
            'ordem' => 10,
        ]);

        $indicados = [
            ['nome' => 'André no Marrakesh', 'descricao' => '', 'votos' => 7],
            ['nome' => 'Emanoel ficando careca (enquanto Frank está com cabelo)', 'descricao' => '', 'votos' => 3],
            ['nome' => 'Frank namorando (com uma mulher)', 'descricao' => '', 'votos' => 2],
            ['nome' => 'Gabriela e Alencar pais de gato', 'descricao' => '', 'votos' => 1],
        ];

        $vencedor = null;
        foreach ($indicados as $i) {
            $indicado = Indicado::create([
                'categoria_id' => $categoria10->id,
                'nome' => $i['nome'],
                'descricao' => $i['descricao'],
            ]);
            $this->criarVotos($categoria10->id, $indicado->id, $i['votos']);
            if ($i['votos'] == 7) $vencedor = $indicado;
        }

        Vencedor::create([
            'edicao_id' => $edicao->id,
            'categoria_id' => $categoria10->id,
            'indicado_id' => $vencedor->id,
            'total_votos' => 7,
        ]);
    }
}
