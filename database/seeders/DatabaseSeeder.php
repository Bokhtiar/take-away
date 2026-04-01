<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        // Idempotent "demo" user so db:seed can be rerun safely
        $demoEmail = 'test@example.com';
        $demoPhone = '01700000000';

        $demoUser = User::firstOrNew(['email' => $demoEmail]);
        $demoUser->name = 'Test User';
        $demoUser->password = Hash::make('password');

        // Assign phone if available and not taken by another user.
        if (! $demoUser->phone) {
            $phoneTaken = User::where('phone', $demoPhone)
                ->when($demoUser->exists, fn ($q) => $q->where('id', '!=', $demoUser->id))
                ->exists();

            if (! $phoneTaken) {
                $demoUser->phone = $demoPhone;
            }
        }

        $demoUser->save();

        $this->call([
            AdminRoleSeeder::class,
            MenuPermissionSeeder::class,
            AdminSeeder::class,
            RestaurantDummyDataSeeder::class,
        ]);
    }
}
