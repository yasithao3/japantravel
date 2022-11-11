<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $managerRole = Role::create(['name' => 'manager']);
        $employeeRole = Role::create(['name' => 'employee']);
        Permission::create(['name' => 'view employees']);
        Permission::create(['name' => 'create employees']);
        Permission::create(['name' => 'edit employees']);
        Permission::create(['name' => 'view leave requests']);
        Permission::create(['name' => 'review leave requests']);
        Permission::create(['name' => 'apply leaves']);
        $managerRole->syncPermissions(['view employees', 'create employees', 'edit employees', 'view leave requests', 'review leave requests', 'apply leaves']);
        $employeeRole->givePermissionTo('apply leaves');
        \App\Models\User::factory(1)->create()->each(function ($user) {
            $user->assignRole('manager');
        });
        LeaveType::factory()->count(2)->create();
    }
}
