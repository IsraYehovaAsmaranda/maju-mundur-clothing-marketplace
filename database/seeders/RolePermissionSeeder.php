<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merchantRole = Role::firstOrCreate(['name' => 'merchant']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        $merchantPermissions = [    
            'create product',
            'update product',
            'delete product',
            'get customer report'
        ];

        $customerPermissions = [
            'buy product',
            'redeem points',
        ];

        foreach($merchantPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        foreach($customerPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $merchantRole->syncPermissions($merchantPermissions);
        $customerRole->syncPermissions($customerPermissions);
    }
}
