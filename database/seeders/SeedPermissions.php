<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class SeedPermissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_permission = new Permission();
        $user_permission->name = 'Create Tasks';
        $user_permission->slug = 'create-tasks';
        $user_permission->save();

        $admin_permission = new Permission();
        $admin_permission->name = 'Edit Users';
        $admin_permission->slug = 'edit-users';
        $admin_permission->save();
    }
}
