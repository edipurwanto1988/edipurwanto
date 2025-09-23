<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryLookup = Category::query()->get()->keyBy('slug');

        $articles = [
            [
                'slug' => 'merancang-minggu-selaras-energi',
                'title' => 'Merancang minggu yang selaras dengan energi personal',
                'category_slug' => 'produktivitas',
                'thumbnail_url' => 'https://picsum.photos/seed/energi/400/300',
                'excerpt' => 'Langkah praktis menyusun jadwal mingguan berdasarkan waktu fokus terbaik dan rutinitas pemulihan.',
                'content' => implode("\n\n", [
                    'Dalam beberapa bulan terakhir, saya bereksperimen dengan cara menyusun minggu berdasarkan pola energi pribadi. Alih-alih memaksa diri fokus penuh setiap hari, saya membuat peta hari untuk pekerjaan mendalam, kolaborasi, dan pemulihan.',
                    'Langkah kunci yang paling membantu adalah melakukan review singkat setiap Jumat sore, mengukur tingkat energi, lalu menyesuaikan slot pekerjaan besar di hari-hari ketika pagi terasa paling segar. Sisanya saya isi dengan pekerjaan ringan dan ruang kosong untuk beristirahat.',
                    'Hasilnya, rasa kewalahan berkurang drastis karena saya tahu kapan harus melambat dan kapan perlu memaksimalkan fokus.'
                ]),
                'published_at' => Carbon::create(2025, 1, 12, 8, 0, 0),
            ],
            [
                'slug' => 'mengelola-informasi-digital',
                'title' => 'Mengelola informasi digital agar tidak menumpuk',
                'category_slug' => 'catatan-harian',
                'thumbnail_url' => 'https://picsum.photos/seed/digital/400/300',
                'excerpt' => 'Sistem katalog sederhana untuk menyimpan ide, artikel referensi, dan inspirasi visual.',
                'content' => implode("\n\n", [
                    'Setiap kali menemukan bahan bacaan menarik, saya masukkan ke satu tempat bernama "Rak Referensi". Rak ini terbagi menjadi tiga kategori: ide mentah, referensi siap pakai, dan inspirasi visual.',
                    'Kuncinya adalah meninjau rak ini setiap Minggu. Arsip yang tidak lagi relevan saya hapus, sementara ide yang mulai matang dipindahkan ke folder proyek. Siklus mingguan ini menjaga folder tidak penuh dan mudah dirujuk kapan saja.'
                ]),
                'published_at' => Carbon::create(2025, 1, 5, 8, 0, 0),
            ],
            [
                'slug' => 'ritual-refleksi-akhir-tahun',
                'title' => 'Ritual refleksi akhir tahun dalam tiga langkah',
                'category_slug' => 'mindfulness',
                'thumbnail_url' => 'https://picsum.photos/seed/refleksi/400/300',
                'excerpt' => 'Panduan singkat menutup tahun dengan evaluasi, perayaan, dan niat baru.',
                'content' => implode("\n\n", [
                    'Ritual ini dimulai dengan evaluasi, yakni menuliskan momen-momen penting sepanjang tahun. Saya menandai mana yang ingin diulang dan mana yang perlu ditinggalkan.',
                    'Langkah kedua adalah perayaan kecil. Biasanya dengan menulis surat terima kasih untuk diri sendiri, mengingatkan bahwa proses panjang telah dijalani dengan baik.',
                    'Terakhir, saya menyusun niat sederhana untuk tahun berikutnya. Bukan resolusi kaku, melainkan arah yang ingin dijaga agar tetap ringan.'
                ]),
                'published_at' => Carbon::create(2024, 12, 27, 8, 0, 0),
            ],
            [
                'slug' => 'tool-favorit-newsletter',
                'title' => 'Tool favorit untuk menyiapkan newsletter mingguan',
                'category_slug' => 'teknologi',
                'thumbnail_url' => 'https://picsum.photos/seed/newsletter/400/300',
                'excerpt' => 'Daftar aplikasi yang mempermudah kurasi konten, penjadwalan, dan analisis performa.',
                'content' => implode("\n\n", [
                    'Newsletter mingguan saya disusun dengan kombinasi tiga tool utama: Notion untuk bank ide, Cron untuk menjadwalkan drafting, dan MailerLite untuk distribusi.',
                    'Integrasi sederhana antar tool membuat proses kurasi terasa ringan karena setiap tahap memiliki rumah masing-masing. Ini mengurangi rasa panik setiap kali deadline mendekat.'
                ]),
                'published_at' => Carbon::create(2024, 12, 18, 8, 0, 0),
            ],
            [
                'slug' => 'jeda-hening-tengah-kesibukan',
                'title' => 'Menemani diri dengan jeda hening di tengah kesibukan',
                'category_slug' => 'mindfulness',
                'thumbnail_url' => 'https://picsum.photos/seed/tenang/400/300',
                'excerpt' => 'Teknik sederhana membuat ruang tenang lima menit untuk menjaga keseimbangan mental.',
                'content' => implode("\n\n", [
                    'Jeda hening adalah alarm kecil yang saya pasang di siang hari. Saat alarm berbunyi, saya berhenti bekerja, menutup mata, dan bernapas perlahan selama lima menit.',
                    'Kebiasaan ini menjaga kepala tetap jernih, terutama ketika deadline beruntun. Pada praktiknya, jeda hening juga membantu memisahkan tugas sehingga transisi terasa lebih mulus.'
                ]),
                'published_at' => Carbon::create(2024, 12, 10, 8, 0, 0),
            ],
            [
                'slug' => 'mengumpulkan-ide-liar',
                'title' => 'Mengumpulkan ide liar tanpa takut berantakan',
                'category_slug' => 'kreativitas',
                'thumbnail_url' => 'https://picsum.photos/seed/ide/400/300',
                'excerpt' => 'Metode braindump mingguan menggunakan papan visual fisik dan digital sekaligus.',
                'content' => implode("\n\n", [
                    'Saya memisahkan ruang braindump menjadi dua: papan tempel fisik di dekat meja kerja dan kanvas digital. Setiap Jumat, semua ide dipindahkan ke dua ruang ini tanpa disunting.',
                    'Minggu berikutnya, saya pilah ide yang layak ditindaklanjuti dan menandainya dengan warna berbeda. Proses ini membuat ide liar tetap aman tanpa menimbulkan rasa bersalah.'
                ]),
                'published_at' => Carbon::create(2024, 12, 1, 8, 0, 0),
            ],
            [
                'slug' => 'ritual-pagi-realistik',
                'title' => 'Membangun ritual pagi yang realistis',
                'category_slug' => 'rutinitas',
                'thumbnail_url' => 'https://picsum.photos/seed/pagi/400/300',
                'excerpt' => 'Tiga langkah ringan menyusun ritual pagi tanpa menambah tekanan atau rasa bersalah.',
                'content' => implode("\n\n", [
                    'Ritual pagi yang saya jalankan hanya terdiri dari tiga komponen: air putih, peregangan ringan, dan meninjau agenda hari itu. Tidak ada aturan rumit lainnya.',
                    'Dengan cara ini, ritual terasa manusiawi dan bisa dijaga konsisten meski jadwal sedang padat.'
                ]),
                'published_at' => Carbon::create(2024, 11, 22, 8, 0, 0),
            ],
            [
                'slug' => 'mengatur-ulang-fokus-proyek',
                'title' => 'Mengatur ulang fokus di tengah proyek panjang',
                'category_slug' => 'produktivitas',
                'thumbnail_url' => 'https://picsum.photos/seed/fokus/400/300',
                'excerpt' => 'Checklist mingguan untuk mengevaluasi progres, menyegarkan motivasi, dan merapikan prioritas.',
                'content' => implode("\n\n", [
                    'Setiap Jumat saya membuat review mini, menanyakan tiga hal: apa yang sudah selesai, apa yang menghambat, dan apa yang butuh dukungan. Jawaban ini lalu saya ubah menjadi rencana pekan berikutnya.',
                    'Checklist sederhana ini membuat proyek panjang terasa bergerak, sekalipun progressnya kecil.'
                ]),
                'published_at' => Carbon::create(2024, 11, 15, 8, 0, 0),
            ],
            [
                'slug' => 'belajar-meluangkan-libur',
                'title' => 'Belajar meluangkan libur tanpa rasa bersalah',
                'category_slug' => 'catatan-harian',
                'thumbnail_url' => 'https://picsum.photos/seed/libur/400/300',
                'excerpt' => 'Cerita pendek tentang mengenali tanda lelah dan merencanakan hari libur spontan.',
                'content' => implode("\n\n", [
                    'Saya pernah mengabaikan tanda lelah hingga akhirnya jatuh sakit. Sejak itu, saya menandai tanggal kosong di kalender setiap bulan sebagai “hari tanpa agenda”.',
                    'Di hari itu, saya benar-benar melepaskan pekerjaan dan hanya melakukan aktivitas ringan yang menyenangkan. Ternyata, libur yang disengaja membuat produktivitas minggu berikutnya meningkat.'
                ]),
                'published_at' => Carbon::create(2024, 11, 5, 8, 0, 0),
            ],
            [
                'slug' => 'bacaan-pilihan-akhir-tahun',
                'title' => 'Bacaan pilihan untuk memantik semangat di akhir tahun',
                'category_slug' => 'rekomendasi',
                'thumbnail_url' => 'https://picsum.photos/seed/baca/400/300',
                'excerpt' => 'Kompilasi buku dan artikel yang membantu menutup tahun dengan perspektif segar.',
                'content' => implode("\n\n", [
                    'Saya menyusun daftar bacaan akhir tahun berisi tiga buku ringan dan beberapa artikel favorit. Fokus saya adalah hal-hal yang menghangatkan, bukan menambah tekanan.',
                    'Daftar ini menjadi ritual kecil yang selalu saya nantikan karena membantu mengakhiri tahun dengan rasa syukur.'
                ]),
                'published_at' => Carbon::create(2024, 10, 28, 8, 0, 0),
            ],
        ];

        foreach ($articles as $article) {
            $category = $categoryLookup->get($article['category_slug'] ?? '');

            Article::query()->updateOrCreate(
                ['slug' => $article['slug']],
                [
                    'title' => $article['title'],
                    'category_id' => $category?->id,
                    'thumbnail_url' => $article['thumbnail_url'],
                    'excerpt' => $article['excerpt'],
                    'content' => $article['content'],
                    'published_at' => $article['published_at'],
                ]
            );
        }
    }
}
