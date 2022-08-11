<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // aqui se definin los roles
        $role1 = Role::create(['name' => 'superusuario']);
        $role2 = Role::create(['name' => 'usuariocomun']);

        // aqui se definen los primeros permisos y se asignan a roles
        Permission::create(['name' => 'es-super-usuario'])->assignRole($role1);
        Permission::create(['name' => 'es-usuario-comun'])->assignRole($role2);

        // aqui van permisos de los superusuarios...
        Permission::create(['name' => 'administracion'])->assignRole($role1);
        Permission::create(['name' => 'operaciones'])->assignRole($role2);

        Permission::create(['name' => 'agendas.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'agendas.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'agendas.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'agendas.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'agendas.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'agendas.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'agendas.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'categorias.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'categorias.create'])->assignRole($role1);
        Permission::create(['name' => 'categorias.store'])->assignRole($role1);
        Permission::create(['name' => 'categorias.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'categorias.edit'])->assignRole($role1);
        Permission::create(['name' => 'categorias.update'])->assignRole($role1);
        Permission::create(['name' => 'categorias.destroy'])->assignRole($role1);

        Permission::create(['name' => 'colonias.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'colonias.create'])->assignRole($role1);
        Permission::create(['name' => 'colonias.store'])->assignRole($role1);
        Permission::create(['name' => 'colonias.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'colonias.edit'])->assignRole($role1);
        Permission::create(['name' => 'colonias.update'])->assignRole($role1);
        Permission::create(['name' => 'colonias.destroy'])->assignRole($role1);

        Permission::create(['name' => 'contactos.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'contactos.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'contactos.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'contactos.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'contactos.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'contactos.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'contactos.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'owners.index'])->assignRole($role1);
        Permission::create(['name' => 'owners.create'])->assignRole($role1);
        Permission::create(['name' => 'owners.store'])->assignRole($role1);
        Permission::create(['name' => 'owners.show'])->assignRole($role1);
        Permission::create(['name' => 'owners.edit'])->assignRole($role1);
        Permission::create(['name' => 'owners.update'])->assignRole($role1);
        Permission::create(['name' => 'owners.destroy'])->assignRole($role1);

        Permission::create(['name' => 'visitas.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'visitas.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'visitas.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'visitas.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'visitas.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'visitas.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'visitas.destroy'])->assignRole($role1);
    }
}
