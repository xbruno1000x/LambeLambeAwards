<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('votos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('indicado_id')->constrained('indicados')->onDelete('cascade');
            $table->string('voter_token')->unique();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            // Garantir um voto por pessoa por categoria
            $table->unique(['categoria_id', 'voter_token']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votos');
    }
};
