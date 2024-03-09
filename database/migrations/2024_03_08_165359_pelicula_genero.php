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
        Schema::create('pelicula_pelicula_generos', function (Blueprint $table) {
            $table->unsignedBigInteger('pelicula_id');
            $table->unsignedBigInteger('genero_pelicula_id');
            $table->foreign('pelicula_id')->references('id')->on('peliculas')->onDelete('cascade');
            $table->foreign('genero_pelicula_id')->references('id')->on('generos')->onDelete('cascade');
            $table->primary(['pelicula_id', 'genero_pelicula_id']);
        });  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelicula_pelicula_generos');
    }
};
