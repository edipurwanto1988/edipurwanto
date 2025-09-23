<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Produktivitas',
                'slug' => 'produktivitas',
                'description' => 'Strategi menjaga fokus, mengatur energi, dan evaluasi rutin.',
            ],
            [
                'name' => 'Catatan Harian',
                'slug' => 'catatan-harian',
                'description' => 'Cerita pendek seputar kegiatan, perjalanan, dan insight personal.',
            ],
            [
                'name' => 'Mindfulness',
                'slug' => 'mindfulness',
                'description' => 'Latihan kesadaran diri, refleksi, dan jeda hening.',
            ],
            [
                'name' => 'Teknologi',
                'slug' => 'teknologi',
                'description' => 'Alat digital dan workflow sederhana pendukung kreativitas.',
            ],
            [
                'name' => 'Kreativitas',
                'slug' => 'kreativitas',
                'description' => 'Eksperimen ide liar, proses kreatif, dan eksplorasi proyek.',
            ],
            [
                'name' => 'Rutinitas',
                'slug' => 'rutinitas',
                'description' => 'Ritual harian realistis yang mudah dijaga konsisten.',
            ],
            [
                'name' => 'Rekomendasi',
                'slug' => 'rekomendasi',
                'description' => 'Kurasi bacaan, referensi, dan sumber inspirasi pilihan.',
            ],
        ];

        $timestamped = array_map(function (array $category) {
            return $category + [
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $categories);

        Category::query()->upsert(
            $timestamped,
            ['slug'],
            ['name', 'description', 'updated_at']
        );
    }
}
