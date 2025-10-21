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
        Schema::create('productos_cdag', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255); // Nombre del producto
            $table->text('descripcion'); // Descripción del producto
            $table->decimal('precio', 10, 2); // Precio con 2 decimales
            $table->integer('stock')->default(0); // Cantidad disponible en stock
            $table->timestamps(); // Created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_cdag');
    }
};
