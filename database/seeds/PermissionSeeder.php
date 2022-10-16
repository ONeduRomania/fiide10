<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'create users',
            'guard_name' => 'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'can:manage-users',
            'guard_name' => 'web'
        ]);

        foreach (User::$dbRoles as $role) {
            DB::table('roles')->insert([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }
    }
}
