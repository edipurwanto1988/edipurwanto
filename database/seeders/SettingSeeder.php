<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::query()->firstOrCreate([], [
            'homepage_description' => 'Blog personal berisi ide, catatan perjalanan, dan referensi.',
            'google_console_code' => null,
            'homepage_image_path' => null,
        ]);
    }
}
