<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indicado extends Model
{
    protected $fillable = [
        'categoria_id',
        'nome',
        'foto',
        'descricao',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function votos(): HasMany
    {
        return $this->hasMany(Voto::class);
    }

    public function totalVotos(): int
    {
        return $this->votos()->count();
    }
}
