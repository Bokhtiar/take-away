<?php

namespace Database\Seeders;

use App\Models\AdminRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminRole::firstOrCreate(
            ['slug' => 'super_admin'],
            [
                'name' => 'Super Admin',
                'slug' => 'super_admin',
                'description' => 'Super Administrator with full system access and permissions.',
            ]
        );
    }
}
