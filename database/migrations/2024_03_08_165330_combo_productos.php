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
        Schema::create('combo_combo_productos', function (Blueprint $table) {
            $table->unsignedBigInteger('combo_id');
            $table->unsignedBigInteger('combo_productos_id');
            $table->foreign('combo_id')->references('id')->on('combos')->onDelete('cascade');
            $table->foreign('combo_productos_id')->references('id')->on('productos')->onDelete('cascade');
            $table->primary(['combo_id', 'combo_productos_id']);
        });  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combo_combo_productos');
    }
};
