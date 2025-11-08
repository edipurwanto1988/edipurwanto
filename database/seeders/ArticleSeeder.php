<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryLookup = \DB::table('categories')->get()->keyBy('slug');
        $authorId = '82a26a43-2154-4ec5-9123-9b8787915039'; // Use the created user ID

        $articles = [
            [
                'slug' => 'merancang-minggu-selaras-energi',
                'title' => 'Merancang minggu yang selaras dengan energi personal',
                'category_slug' => 'produktivitas',
                'thumbnail_url' => 'https://picsum.photos/seed/energi/400/300',
                'excerpt' => 'Langkah praktis menyusun jadwal mingguan berdasarkan waktu fokus terbaik dan rutinitas pemulihan.',
                'content' => 'Eksperimen menyusun minggu berdasarkan energi pribadi. Review Jumat membantu ukur energi dan sesuaikan jadwal.',
                'published_at' => Carbon::create(2025, 1, 12, 8, 0, 0),
            ],
            [
                'slug' => 'mengelola-informasi-digital',
                'title' => 'Mengelola informasi digital agar tidak menumpuk',
                'category_slug' => 'catatan-harian',
                'thumbnail_url' => 'https://picsum.photos/seed/digital/400/300',
                'excerpt' => 'Sistem katalog sederhana untuk menyimpan ide, artikel referensi, dan inspirasi visual.',
                'content' => 'Bahan bacaan menarik dimasukkan ke "Rak Referensi" dengan tiga kategori: ide mentah, referensi, dan inspirasi.',
                'published_at' => Carbon::create(2025, 1, 5, 8, 0, 0),
            ],
            [
                'slug' => 'ritual-refleksi-akhir-tahun',
                'title' => 'Ritual refleksi akhir tahun dalam tiga langkah',
                'category_slug' => 'mindfulness',
                'thumbnail_url' => 'https://picsum.photos/seed/refleksi/400/300',
                'excerpt' => 'Panduan singkat menutup tahun dengan evaluasi, perayaan, dan niat baru.',
                'content' => 'Ritual refleksi: evaluasi momen penting, perayaan kecil, dan susun niat sederhana untuk tahun berikutnya.',
                'published_at' => Carbon::create(2024, 12, 27, 8, 0, 0),
            ],
            [
                'slug' => 'tool-favorit-newsletter',
                'title' => 'Tool favorit untuk menyiapkan newsletter mingguan',
                'category_slug' => 'teknologi',
                'thumbnail_url' => 'https://picsum.photos/seed/newsletter/400/300',
                'excerpt' => 'Daftar aplikasi yang mempermudah kurasi konten, penjadwalan, dan analisis performa.',
                'content' => 'Newsletter mingguan menggunakan tiga tool: Notion untuk ide, Cron untuk jadwal, dan MailerLite untuk distribusi.',
                'published_at' => Carbon::create(2024, 12, 18, 8, 0, 0),
            ],
            [
                'slug' => 'jeda-hening-tengah-kesibukan',
                'title' => 'Menemani diri dengan jeda hening di tengah kesibukan',
                'category_slug' => 'mindfulness',
                'thumbnail_url' => 'https://picsum.photos/seed/tenang/400/300',
                'excerpt' => 'Teknik sederhana membuat ruang tenang lima menit untuk menjaga keseimbangan mental.',
                'content' => 'Jeda hening: alarm siang untuk berhenti bekerja, tutup mata, dan bernapas perlahan lima menit.',
                'published_at' => Carbon::create(2024, 12, 10, 8, 0, 0),
            ],
            [
                'slug' => 'mengumpulkan-ide-liar',
                'title' => 'Mengumpulkan ide liar tanpa takut berantakan',
                'category_slug' => 'kreativitas',
                'thumbnail_url' => 'https://picsum.photos/seed/ide/400/300',
                'excerpt' => 'Metode braindump mingguan menggunakan papan visual fisik dan digital sekaligus.',
                'content' => 'Braindump menggunakan papan tempel fisik dan kanvas digital. Ide Jumat dipilah minggu berikutnya.',
                'published_at' => Carbon::create(2024, 12, 1, 8, 0, 0),
            ],
            [
                'slug' => 'ritual-pagi-realistik',
                'title' => 'Membangun ritual pagi yang realistis',
                'category_slug' => 'rutinitas',
                'thumbnail_url' => 'https://picsum.photos/seed/pagi/400/300',
                'excerpt' => 'Tiga langkah ringan menyusun ritual pagi tanpa menambah tekanan atau rasa bersalah.',
                'content' => 'Ritual pagi: air putih, peregangan ringan, dan tinjau agenda hari. Terasa manusiawi dan konsisten.',
                'published_at' => Carbon::create(2024, 11, 22, 8, 0, 0),
            ],
            [
                'slug' => 'mengatur-ulang-fokus-proyek',
                'title' => 'Mengatur ulang fokus di tengah proyek panjang',
                'category_slug' => 'produktivitas',
                'thumbnail_url' => 'https://picsum.photos/seed/fokus/400/300',
                'excerpt' => 'Checklist mingguan untuk mengevaluasi progres, menyegarkan motivasi, dan merapikan prioritas.',
                'content' => 'Review Jumat: tiga pertanyaan tentang selesai, hambatan, dan dukungan. Jawaban jadi rencana pekan berikutnya.',
                'published_at' => Carbon::create(2024, 11, 15, 8, 0, 0),
            ],
            [
                'slug' => 'belajar-meluangkan-libur',
                'title' => 'Belajar meluangkan libur tanpa rasa bersalah',
                'category_slug' => 'catatan-harian',
                'thumbnail_url' => 'https://picsum.photos/seed/libur/400/300',
                'excerpt' => 'Cerita pendek tentang mengenali tanda lelah dan merencanakan hari libur spontan.',
                'content' => 'Pernah abaikan lelah hingga sakit. Sekarang tandai "hari tanpa agenda" untuk lepas pekerjaan.',
                'published_at' => Carbon::create(2024, 11, 5, 8, 0, 0),
            ],
            [
                'slug' => 'bacaan-pilihan-akhir-tahun',
                'title' => 'Bacaan pilihan untuk memantik semangat di akhir tahun',
                'category_slug' => 'rekomendasi',
                'thumbnail_url' => 'https://picsum.photos/seed/baca/400/300',
                'excerpt' => 'Kompilasi buku dan artikel yang membantu menutup tahun dengan perspektif segar.',
                'content' => 'Daftar bacaan akhir tahun: tiga buku ringan dan artikel favorit. Fokus pada hal yang menghangatkan.',
                'published_at' => Carbon::create(2024, 10, 28, 8, 0, 0),
            ],
        ];

        foreach ($articles as $article) {
            $category = $categoryLookup->get($article['category_slug'] ?? '');

            Article::query()->updateOrCreate(
                ['slug' => $article['slug']],
                [
                    'id' => (string) Str::uuid(),
                    'title' => $article['title'],
                    'categoryId' => $category?->id ?: null, // Use null if category not found
                    'excerpt' => $article['excerpt'],
                    'content' => $article['content'],
                    'publishedAt' => $article['published_at'],
                    'published' => 1, // Set as published
                    'featured' => 0, // Not featured by default
                    'authorId' => $authorId, // Use the created user ID
                    'updatedAt' => now(),
                ]
            );
        }
    }
}
