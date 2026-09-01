<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Seed catálogos primero
        $this->call([
            RolSeeder::class,
            TipoContratoSeeder::class,
            FormaPagoSeeder::class,
        ]);

        // Crear usuario administrador
        $adminRole = Rol::where('slug', 'admin')->first();
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@contratos.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole?->id,
        ]);

        // Seed contratos
        $this->call([
            ContratoSeeder::class,
        ]);
    }
}
