<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Remove as constraints únicas para permitir votação ilimitada
     */
    public function up(): void
    {
        Schema::table('votos', function (Blueprint $table) {
            // Remover a constraint única de categoria_id + voter_token
            $table->dropUnique(['categoria_id', 'voter_token']);
            
            // Remover a constraint única do voter_token
            $table->dropUnique(['voter_token']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votos', function (Blueprint $table) {
            $table->unique(['categoria_id', 'voter_token']);
            $table->unique('voter_token');
        });
    }
};
