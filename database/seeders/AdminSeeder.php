<?php

namespace Database\Seeders;

use App\Models\AdminRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRoleId = AdminRole::where('slug', 'super_admin')->value('id') ?? 1;

        DB::table('admins')->updateOrInsert([
            'id' => 1,
        ], [
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'phone' => '01638107361',
            'location' => DB::raw("ST_GeomFromText('POINT(0 0)')"),
            'password' => Hash::make('password'), // Default password: password
            'role_id' => $superAdminRoleId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
