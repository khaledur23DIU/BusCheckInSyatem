<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Account for Super Admin
        $user = User::create([
            'name' => 'Jhon Doe', 
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user->profile()->create([
            'account_status' => true
        ]);

        $roleAdmin = Role::create(['name' => 'Super Admin']);
   
        $permissionsAll = Permission::whereNotIn('module',['check-in','checker-complain'])->pluck('id','id')->all();
  
        $roleAdmin->syncPermissions($permissionsAll);
   
        $user->assignRole([$roleAdmin->id]);

        //Account for Checker Demo
        $checker = User::create([
            'name' => 'Jr. Smith', 
            'email' => 'checker@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $checker->profile()->create([
            'account_status' => true
        ]);

        $roleChecker = Role::create(['name' => 'Checker']);
        $permissionsChecker = Permission::whereIn('module',['check-in','checker-complain'])->pluck('id','id')->all();
  
        $roleChecker->syncPermissions($permissionsChecker);
        $checker->assignRole([$roleChecker->id]);
    }
}
