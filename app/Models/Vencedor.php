<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vencedor extends Model
{
    protected $table = 'vencedores';
    
    protected $fillable = [
        'edicao_id',
        'categoria_id',
        'indicado_id',
        'total_votos',
    ];

    public function edicao(): BelongsTo
    {
        return $this->belongsTo(Edicao::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function indicado(): BelongsTo
    {
        return $this->belongsTo(Indicado::class);
    }
}
