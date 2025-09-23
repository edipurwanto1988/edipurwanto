<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::query()->firstOrCreate(
            ['slug' => 'primary'],
            [
                'name' => 'Primary Menu',
                'items' => [],
            ]
        );
    }
}
