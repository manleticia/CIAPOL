<?php

namespace Database\Seeders\roles;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Role::create([
            "name" => "super-administrateur",
            "guard_name" => "web",
        ]);

        Role::create([
            "name" => "administrateur",
            "guard_name" => "web",
        ]);

        Role::create([
            "name" => "entreprise",
            "guard_name" => "web",
        ]);
    }
}
