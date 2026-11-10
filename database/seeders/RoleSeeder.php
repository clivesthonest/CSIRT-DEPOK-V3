<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'Super Administrator']);
        Role::create(['name' => 'Administrator CSIRT']);
        Role::create(['name' => 'Security Analyst']);
        Role::create(['name' => 'GRC atau Auditor']);
        Role::create(['name' => 'Content Editor']);
        Role::create(['name' => 'Operator OPD']);
        Role::create(['name' => 'Executive Viewer']);
    }
}