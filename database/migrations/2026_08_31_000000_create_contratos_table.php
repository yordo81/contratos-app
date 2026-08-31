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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->string('proveedor_cliente'); // Proveedor o Cliente
            $table->string('tipo_contrato'); // Tipo de contrato (Prestación de servicios / Compra venta)
            $table->text('objeto_contrato'); // Objeto del contrato
            $table->string('numero_contrato_proveedor_cliente'); // No. contrato del proveedor/cliente
            $table->string('dictamen')->nullable(); // Dictamen
            $table->string('forma_pago'); // Forma de pago
            $table->date('fecha_firma'); // Fecha de firma del contrato
            $table->date('fecha_inicio_vigencia')->nullable(); // Periodo de vigencia - inicio
            $table->date('fecha_fin_vigencia')->nullable(); // Periodo de vigencia - fin
            $table->text('observaciones')->nullable(); // Observaciones
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
