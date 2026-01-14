<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Edicao extends Model
{
    protected $table = 'edicoes';
    
    protected $fillable = [
        'ano',
        'titulo',
        'ativa',
        'votacao_aberta',
    ];

    protected $casts = [
        'ativa' => 'boolean',
        'votacao_aberta' => 'boolean',
    ];

    public function categorias(): HasMany
    {
        return $this->hasMany(Categoria::class)->orderBy('ordem');
    }

    public function vencedores(): HasMany
    {
        return $this->hasMany(Vencedor::class);
    }

    public static function ativa()
    {
        return self::where('ativa', true)->first();
    }
}
