<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'list',
           'create',
           'edit',
           'delete'
        ];

        $modules = [
          'user',
          'role',
          'assign-checker',
          'bus',
          'bus-in-Route',
          'bus-route',
          'bus-stops',
          'checker',
          'all-Check-in',
          'complains',
          'Income-Report',
          'passenger-category',
          'settings',
          'ticket-price',
          'check-in',
          'checker-complain'
        ];

         foreach ($modules as $key => $module) {
           foreach ($permissions as $permission) {
                   Permission::create(['module' => $module, 'name' => $module.'-'.$permission]);
              }
         }
    }
}
