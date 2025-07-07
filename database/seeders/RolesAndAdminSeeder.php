<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolesAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
    $sheikhRole = Role::create(['name' => 'sheikh']);
    $userRole = Role::create(['name' => 'user']);

    $admin = User::create([
        'name' => 'Admin',
        'email' => 'admin@fatwa.com',
        'password' => bcrypt('password'),
    ]);
    $admin->assignRole($adminRole);

    $sheikh = User::create([
        'name' => 'الشيخ محمد',
        'email' => 'sheikh@fatwa.com',
        'password' => bcrypt('password'),
    ]);
    $sheikh->assignRole($sheikhRole);

    $user = User::create([
        'name' => 'مستخدم',
        'email' => 'user@fatwa.com',
        'password' => bcrypt('password'),
    ]);
    $user->assignRole($userRole);
    }
}
