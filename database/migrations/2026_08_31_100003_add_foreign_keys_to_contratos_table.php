<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Insertar catálogos basados en datos existentes
        DB::table('tipo_contratos')->insert([
            ['nombre' => 'Prestación de servicios', 'descripcion' => 'Contrato para la prestación de servicios profesionales', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Compra venta', 'descripcion' => 'Contrato de compra-venta de bienes o productos', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('forma_pagos')->insert([
            ['nombre' => 'Transferencia bancaria', 'descripcion' => 'Pago mediante transferencia electrónica a cuenta bancaria', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Efectivo', 'descripcion' => 'Pago en efectivo', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cheque', 'descripcion' => 'Pago mediante cheque nominativo', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Tarjeta de crédito', 'descripcion' => 'Pago con tarjeta de crédito', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Tarjeta de débito', 'descripcion' => 'Pago con tarjeta de débito', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Otro', 'descripcion' => 'Otra forma de pago no especificada', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Agregar columnas de foreign key (sin constraint aún)
        Schema::table('contratos', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_contrato_id')->nullable()->after('proveedor_cliente');
            $table->unsignedBigInteger('forma_pago_id')->nullable()->after('dictamen');
        });

        // 3. Migrar datos de strings a IDs
        $tiposMap = DB::table('tipo_contratos')->pluck('id', 'nombre')->toArray();
        $formasMap = DB::table('forma_pagos')->pluck('id', 'nombre')->toArray();

        $contratos = DB::table('contratos')->get();
        foreach ($contratos as $contrato) {
            DB::table('contratos')->where('id', $contrato->id)->update([
                'tipo_contrato_id' => $tiposMap[$contrato->tipo_contrato] ?? null,
                'forma_pago_id' => $formasMap[$contrato->forma_pago] ?? null,
            ]);
        }

        // 4. Eliminar columnas de string
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropColumn('tipo_contrato');
            $table->dropColumn('forma_pago');
        });

        // 5. Agregar foreign key constraints
        Schema::table('contratos', function (Blueprint $table) {
            $table->foreign('tipo_contrato_id')->references('id')->on('tipo_contratos')->nullOnDelete();
            $table->foreign('forma_pago_id')->references('id')->on('forma_pagos')->nullOnDelete();
        });
    }

    public function down(): void
    {
        // 1. Eliminar foreign keys
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropForeign(['tipo_contrato_id']);
            $table->dropForeign(['forma_pago_id']);
        });

        // 2. Recrear columnas de string
        Schema::table('contratos', function (Blueprint $table) {
            $table->string('tipo_contrato')->nullable()->after('proveedor_cliente');
            $table->string('forma_pago')->nullable()->after('dictamen');
        });

        // 3. Migrar datos de IDs a strings
        $tiposMap = DB::table('tipo_contratos')->pluck('nombre', 'id')->toArray();
        $formasMap = DB::table('forma_pagos')->pluck('nombre', 'id')->toArray();

        $contratos = DB::table('contratos')->get();
        foreach ($contratos as $contrato) {
            DB::table('contratos')->where('id', $contrato->id)->update([
                'tipo_contrato' => $tiposMap[$contrato->tipo_contrato_id] ?? null,
                'forma_pago' => $formasMap[$contrato->forma_pago_id] ?? null,
            ]);
        }

        // 4. Eliminar columnas de foreign key
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropColumn('tipo_contrato_id');
            $table->dropColumn('forma_pago_id');
        });
    }
};
