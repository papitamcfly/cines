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
        Schema::create('salas',function(Blueprint $table)
        {
            $table->id();
            $table->unsignedBigInteger('cine_id');
            $table->integer('numero_sala');
            $table->integer('capacidad');
            $table->foreign('cine_id')->references('id')->on('cines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salas');
    }
};
