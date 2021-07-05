<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Superadmin',
            ],
            [
                'id' => 2,
                'name' => 'User',
            ],
            [
                'id' => 3,
                'name' => 'Jury',
            ]
        ]);
    }
}
