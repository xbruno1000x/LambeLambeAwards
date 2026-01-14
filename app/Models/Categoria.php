<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $fillable = [
        'edicao_id',
        'nome',
        'descricao',
        'ordem',
    ];

    public function edicao(): BelongsTo
    {
        return $this->belongsTo(Edicao::class);
    }

    public function indicados(): HasMany
    {
        return $this->hasMany(Indicado::class);
    }

    public function votos(): HasMany
    {
        return $this->hasMany(Voto::class);
    }

    public function vencedor()
    {
        return $this->hasOne(Vencedor::class);
    }
}
