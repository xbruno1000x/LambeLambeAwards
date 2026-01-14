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
        Schema::create('vencedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edicao_id')->constrained('edicoes')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('indicado_id')->constrained('indicados')->onDelete('cascade');
            $table->integer('total_votos')->default(0);
            $table->timestamps();
            
            $table->unique(['edicao_id', 'categoria_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vencedores');
    }
};
