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
        Schema::create('boletos',function(Blueprint $table)
        {
            $table->id();
            $table->unsignedBigInteger('id_funcion');
            $table->unsignedBigInteger('id_user');
            $table->string('fila');
            $table->string('asiento');
            $table->double('precio');
            $table->foreign('id_funcion')->references('id')->on('funciones');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boletos');
    }
};
