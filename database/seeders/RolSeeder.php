<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'Administrador', 'slug' => 'admin', 'descripcion' => 'Acceso total al sistema. Puede gestionar usuarios, contratos y configuración.'],
            ['nombre' => 'Editor', 'slug' => 'editor', 'descripcion' => 'Puede crear, editar y eliminar contratos. No puede gestionar usuarios.'],
            ['nombre' => 'Consultor', 'slug' => 'viewer', 'descripcion' => 'Solo puede visualizar contratos. No tiene permisos de edición.'],
        ];

        foreach ($roles as $rol) {
            Rol::updateOrCreate(
                ['slug' => $rol['slug']],
                $rol
            );
        }
    }
}
