<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            MenuSeeder::class,
            CategorySeeder::class,
            ArticleSeeder::class,
        ]);

        User::query()->updateOrCreate(
            ['email' => 'admin@blog.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin'),
            ]
        );
    }
}
