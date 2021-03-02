<?php

use Illuminate\Database\Seeder;

class RoleTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return;
        DB::table('roles')->delete();
        Role::create(array(
            'description' => 'Management',
        ));
        Role::create(array(
            'description' => 'Admin',
        ));
    }
}
