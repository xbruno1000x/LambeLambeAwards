<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voto extends Model
{
    protected $fillable = [
        'categoria_id',
        'indicado_id',
        'voter_token',
        'ip_address',
        'user_agent',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function indicado(): BelongsTo
    {
        return $this->belongsTo(Indicado::class);
    }
}
