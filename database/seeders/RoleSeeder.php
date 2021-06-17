<?php

namespace Database\Seeders;
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
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'PorFormatos']);
        $role3 = Role::create(['name' => 'PorUnLocal']);

        $permission = Permission::create(['name' => 'indicadores'])->syncRoles([$role1,$role2]);
        $permission = Permission::create(['name' => 'Reportes'])->syncRoles([$role1,$role2,$role3]);
        $permission = Permission::create(['name' => 'Configuracion'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'Perfilamiento'])->syncRoles([$role1]);
        $permission = Permission::create(['name' => 'PorFormato'])->syncRoles([$role1,$role2]);
        $permission = Permission::create(['name' => 'PorLocal'])->syncRoles([$role3]);
        

    }
}
