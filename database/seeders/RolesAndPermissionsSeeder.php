<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $modules = [
            ['name' => 'Catalog'],
            ['name' => 'Orders'],
            ['name' => 'Users'],
            ['name' => 'Settings'],
        ];

        foreach ($modules as $data) {
            Module::create($data);
        }

        $permissions = [
            ['name' => 'Manage Catalog', 'module_id' => 1, 'slug' => 'manage-catalog'],
            ['name' => 'View Orders', 'module_id' => 2, 'slug' => 'view-orders'],
            ['name' => 'Manage Orders', 'module_id' => 2, 'slug' => 'manage-orders'],
            ['name' => 'Checkout Order', 'module_id' => 2, 'slug' => 'checkout-order'],
            ['name' => 'Manage Users', 'module_id' => 3, 'slug' => 'manage-users'],
            ['name' => 'Manage Settings', 'module_id' => 4, 'slug' => 'manage-settings'],
        ];

        foreach ($permissions as $data) {
            Permission::create($data);
        }

        $admin = Role::create(['name' => 'Admin', 'slug' => 'admin']);
        $manager = Role::create(['name' => 'Manager', 'slug' => 'manager']);
        $customer = Role::create(['name' => 'Customer', 'slug' => 'customer']);

        $admin->permissions()->attach(Permission::all()->pluck('id'));
        $manager->permissions()->attach(Permission::whereIn('slug', [
            'manage-catalog',
            'view-orders',
            'manage-orders',
        ])->pluck('id'));
        $customer->permissions()->attach(Permission::where('slug', 'checkout-order')->pluck('id'));
    }
}
