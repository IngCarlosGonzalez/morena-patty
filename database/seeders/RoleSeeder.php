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
        $role3 = Role::create(['name' => 'usuariomovil']);

        // aqui se definen los primeros permisos y se asignan a roles
        Permission::create(['name' => 'es-super-usuario'])->assignRole($role1);
        Permission::create(['name' => 'es-usuario-comun'])->assignRole($role2);
        Permission::create(['name' => 'es-usuario-movil'])->assignRole($role3);

        Permission::create(['name' => 'catalogos.usuarios.index'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.usuarios.create'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.usuarios.store'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.usuarios.show'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.usuarios.edit'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.usuarios.update'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.usuarios.destroy'])->assignRole($role1);

        Permission::create(['name' => 'catalogos.owners.index'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.owners.create'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.owners.store'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.owners.show'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.owners.edit'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.owners.update'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.owners.destroy'])->assignRole($role1);

        Permission::create(['name' => 'catalogos.categorias.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'catalogos.categorias.create'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.categorias.store'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.categorias.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'catalogos.categorias.edit'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.categorias.update'])->assignRole($role1);
        Permission::create(['name' => 'catalogos.categorias.destroy'])->assignRole($role1);

        Permission::create(['name' => 'directorios.subscribers.index'])->assignRole($role1);
        Permission::create(['name' => 'directorios.subscribers.create'])->assignRole($role1);
        Permission::create(['name' => 'directorios.subscribers.store'])->assignRole($role1);
        Permission::create(['name' => 'directorios.subscribers.show'])->assignRole($role1);
        Permission::create(['name' => 'directorios.subscribers.edit'])->assignRole($role1);
        Permission::create(['name' => 'directorios.subscribers.update'])->assignRole($role1);
        Permission::create(['name' => 'directorios.subscribers.destroy'])->assignRole($role1);

        Permission::create(['name' => 'directorios.contactos.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'directorios.contactos.index2'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'directorios.contactos.avisos'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'directorios.contactos.create'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'directorios.contactos.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'directorios.contactos.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'directorios.contactos.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'directorios.contactos.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'directorios.contactos.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'directorios.documentos.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'directorios.documentos.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'directorios.documentos.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'directorios.documentos.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'directorios.documentos.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'directorios.documentos.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'directorios.documentos.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'oficinas.visitas.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'oficinas.visitas.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'oficinas.visitas.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'oficinas.visitas.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'oficinas.visitas.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'oficinas.visitas.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'oficinas.visitas.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'controles.agendas.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'controles.agendas.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'controles.agendas.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'controles.agendas.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'controles.agendas.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'controles.agendas.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'controles.agendas.destroy'])->syncRoles([$role1, $role2]);
    }
}
