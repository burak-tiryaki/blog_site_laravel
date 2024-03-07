<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Admin','Editor','User'];
        
        foreach($roles as $role)
            Role::create(['name' => $role]);

        
        $permissions = ['get-all-articles','hard-delete'];
        
        foreach($permissions as $per)
            Permission::create(['name' => $per]);

        $roles = Role::where('name','Admin')
                        ->orWhere('name','Editor')
                        ->get();

        $permission = Permission::where('name','get-all-articles')
                                ->orWhere('name','hard-delete')                            
                                ->get();

        foreach($roles as $role){
            foreach($permission as $per){
                $role->givePermissionTo($per);
            }
        }

    }
}
