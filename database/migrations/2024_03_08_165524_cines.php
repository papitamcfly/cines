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
        Schema::create('cines',function(Blueprint $table){
            $table->id();
            $table->string('nombre');
            $table->string('dirección');
            $table->string('ciudad');
            $table->integer('capacidad_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cines');
    }
};
