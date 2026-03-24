<?php

namespace Database\Seeders;

use App\Models\Admin;
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
        Admin::create([
            'name' => 'super admin',
            'email' => 'superadmin@bokhtiarpro.com',
            'phone' => '01638107361',
            'location' => DB::raw("ST_GeomFromText('POINT(0 0)')"),
            'password' => Hash::make('password'), // Default password: password
            'role_id' => 1,
        ]);
    }
}
