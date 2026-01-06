<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'id' => 1,
                'category_id' => 2,
                'name' => 'Sandal Wanita Sandal Selop Slide Karet EVA Motif Gesper',
                'slug' => 'sandal-wanita-sandal-selop-slide-karet-eva-motif-gesper',
                'description' => 'Sandal wanita dengan desain casual yang nyaman untuk digunakan sehari-hari. Berbahan karet EVA berkualitas. 
                                Panduan ukuran :
                                - Size 35 - 36 Untuk panjang telapak kaki 21,5 cm
                                - Size 37 - 38 Untuk panjang telapak kaki 22,5 cm
                                - Size 39 - 40 Untuk panjang telapak kaki 23,5 cm',
                'price' => 32988.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'category_id' => 3,
                'name' => 'Sandal Anak Sandal Baim Crocs',
                'slug' => 'sandal-anak-sandal-baim-crocs',
                'description' => 'Sandal anak perempuan Jibbitz ini sangat nyaman dan lembut di kaki anak. 
                                Panduan ukuran :
                                - Size 24 - 25 : 14 cm
                                - Size 26 - 27 : 15,5 cm
                                - Size 28 - 29 : 16,5 cm
                                - Size 30 - 31 : 17,5 cm
                                - Size 32 - 33 : 19 cm
                                - Size 34 - 35 : 20 cm',
                'price' => 28758.00,
                'weight' => 400,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'category_id' => 1,
                'name' => 'Sandal Pria VENTINO LAFD Sport',
                'slug' => 'sandal-pria-ventino-lafd-sport',
                'description' => 'Sandal ini dibuat dengan design casual dan fashionable, namun memberikan kenyamanan di setiap langkah kaki Anda. Sandal ini terbuat dari bahan 100% karet yang ramah lingkungan dan mudah untuk dibersihkan. Sangat cocok untuk dipakai saat bersantai maupun sehari-hari. Sandal slop untuk kamu yang ingin tampil gaya. Selain nyaman, model yang simpel dan tulisan yang kekinian membuat sandal ini sangat digemari oleh pria maupun wanita.
                                Panduan ukuran
                                - Size 40 = 26CM
                                - Size 41 = 26.5CM
                                - Size 42 = 27CM
                                - Size 43 = 27.5CM
                                - Size 44 = 28CM
                                - Size 45 = 28.5CM',
                'price' => 28500.00,
                'weight' => 350,
                'is_active' => true,
                'featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'category_id' => 3,
                'name' => 'Sandal Anak Slop kekinian',
                'slug' => 'sandal-anak-slop-kekinian',
                'description' => 'Sandal anak slop fuji wedges anak perempuan dengan bahan karet EVA halus tidak sakit dipakai sehari-hari, empuk dan anti slip tidak licin saat kena air. Tinggi hak 5cm
                                Panduan ukuran:
                                - Size 29 - 30 : 20cm
                                - Size 31 - 32 : 21cm
                                - Size 33 - 34 : 22cm',
                'price' => 28000.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'category_id' => 3,
                'name' => 'Sandal Anak laki-laki Motif Loreng',
                'slug' => 'sandal-anak-laki-laki-motif-loreng',
                'description' => 'Sandal anak slop terbaru dengan desain yang kekinian, bahan karet yang nyaman dan anti slip. 
                            Panduan ukuran:
                            - Size 25 - 26 : 16,5 - 17cm
                            - Size 27 - 28 : 17,5 - 18cm
                            - Size 29 - 30 : 18,5 - 19cm
                            - Size 31 - 32 : 19,5 - 20cm
                            - Size 33 - 34 : 20,5 - 21cm',
                'price' => 22000.00,
                'weight' => 200,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'category_id' => 2,
                'name' => 'Sandal Wanita Wedges FUJI Japit',
                'slug' => 'sandal-wanita-wedges-fuji-japit',
                'description' => 'Sandal Jepit Wedges Wanita Terbaru Kekinian Sandal Jelly Ringan Phylon Elegant Dewasa 36-41 dengan Bahan Ringan dan lentur, Nyaman dipakai dan empuk, Anti Slip dan Anti Air, Model Timeless, Cocok dipakai dimana saja. 
                                Panduan ukuran:
                                - Size 36 - 37 : 23 - 23,5cm
                                - Size 38 - 39 : 24 - 24,5cm
                                - Size 40 - 41 : 25 - 25,5cm',
                'price' => 30305.00,
                'weight' => 350,
                'is_active' => true,
                'featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'category_id' => 2,
                'name' => 'Sandal Wanita CLOG Model Rantai',
                'slug' => 'sandal-wanita-clog-model-rantai',
                'description' => 'Sandal CLOG / BAIM Santai Tinggi 5 Cm, Bahan Sangat Empuk dan Nyaman di Pakai Seharian, Mudah di Bersihkan, dan Anti Air, Sol Anti Slip dan Tidak Licin, ringan dan Empuk
                                Panduan ukuran:
                                - Size 30 - 31 : 19 - 19,5cm
                                - Size 32 - 33 : 20 - 20,5cm
                                - Size 34 - 35 : 21 - 22cm
                                - Size 36 - 37 : 22,5 - 23cm
                                - Size 38 - 39 : 23,5 - 24cm
                                - Size 40 : 25cm',
                'price' => 32869.00,
                'weight' => 450,
                'is_active' => true,
                'featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'category_id' => 1,
                'name' => 'Sandal Pria Slop Karet NEW ERA',
                'slug' => 'sandal-pria-slop-karet-new-era',
                'description' => 'Sandal Slop karet dari New Era ini terbuat dari bahan karet lentur, sangat ringan, nyaman dipakai, kuat, anti air, mudah dibersihkan, desain yang simple dan elegan, pilihan warna yang menarik.',
                'price' => 31967.00,
                'weight' => 600,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'category_id' => 1,
                'name' => 'Sandal Pria Dulux 565-3 slop karet',
                'slug' => 'sandal-pria-dulux-565-3-slop-karet',
                'description' => 'sandal pria slop dengan bahan karet, elastis, kuat, tidak licin dan empuk
                                Panduan ukuran
                                - Size 36 : 24cm
                                - Size 37 : 24,5cm
                                - Size 38 : 25 cm
                                - Size 39 : 26cm
                                - Size 40 : 26,6 cm
                                - Size 41 : 27,5cm
                                - Size 42 : 28cm
                                - Size 43 : 28,5cm',
                'price' => 31750.00,
                'weight' => 250,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'category_id' => 1,
                'name' => 'Sandal Pria Porto 1034M',
                'slug' => 'sandal-pria-porto-1034m',
                'description' => 'Sandal jepit pria porto dengan bahan karet, empuk, dan nyaman dipakai sehari-hari
                                Panduan ukuran:
                                - Size 41 : 24,3 - 24,9 cm
                                - Size 42 : 24,9 - 25,5 cm
                                - Size 43 : 25,5 - 26,1 cm
                                - Size 44 : 26,1 - 26,7 cm',
                'price' => 28900.00,
                'weight' => 450,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'category_id' => 2,
                'name' => 'Sandal Wanita Slop Dulux 663B',
                'slug' => 'sandal-wanita-slop-dulux-663b',
                'description' => 'Sandal ini menggunakan bahan eva raber yang sangat ringan dengan desain yang elegan dan trendy, nyaman dan lembut ketika di gunakan, tida membuat kaki sakit dan pegal cocok buat di gunakan sehari hari
                                Panduan ukuran:
                                - Size 36 : 23 cm
                                - Size 37 : 23,5 cm
                                - Size 38 : 24 cm
                                - Size 39 : 24,5 cm
                                - Size 40 : 25 cm',
                'price' => 30000.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'category_id' => 3,
                'name' => 'Sandal Anak jepit Labubu',
                'slug' => 'sandal-anak-jepit-labubu',
                'description' => 'sandal anak dengan bahan karet yang empuk dan nyaman buat anak, desain labubu yang disukai anak-anak, anti Slip dan anti air
                                Panduan ukuran:
                                - 24 - 25 : 16 cm
                                - 26 - 27 : 17 cm
                                - 28 - 29 : 18 cm
                                - 30 - 31 : 19 cm
                                - 32 - 33 : 20 cm
                                - 34 - 35 : 21 cm',
                'price' => 25500.00,
                'weight' => 200,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 13,
                'category_id' => 2,
                'name' => 'Sandal Wanita Dulux Slip Silang',
                'slug' => 'sandal-wanita-dulux-slip-silang',
                'description' => 'Sandal yang terbuat dari bahan karet dengan desain yang simple dan mudah dipakai. Desain yang sederhana membuatnya cocok digunakan dalam berbagai aktivitas. Sehingga mudah disesuaikan dengan kebutuhan dan selera, sandal ini juga memiliki harga yang terjangkau sehingga menjadi salah satu pilihan sandal yang populer di kalangan wanita.
                                Panduan ukuran:
                                - Size 36 : 23,5 cm
                                - Size 37 : 24 cm
                                - Size 38 : 24,5 cm
                                - Size 39 : 25 cm
                                - Size 40 : 25,5 cm',
                'price' => 32567.00,
                'weight' => 300,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 14,
                'category_id' => 1,
                'name' => 'Sandal Pria Slip on Model Sport',
                'slug' => 'sandal-pria-slip-on-model-sport',
                'description' => 'Sandal dengan bahan karet ringan, elastis dan anti selip. Produk 100% original awet dan kuat, anti air, nyaman digunakan, lentur, cocok digunakan sehari-hari maupun bepergian
                                Panduan ukuran :
                                - Size 40 : 25 cm
                                - Size 41 : 25,5 cm
                                - Size 42 : 26 cm
                                - Size 43 : 26,5 cm
                                - Size 44 : 27 cm
                                - Size 45 : 27,5 cm',
                'price' => 29000.00,
                'weight' => 300,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 15,
                'category_id' => 3,
                'name' => 'Sandal Anak Slop Ceqiu EH 8D Badman',
                'slug' => 'sandal-anak-slop-ceqiu-eh-8d-badman',
                'description' => 'Sandal CEQIU terbuat dari karet alami sehingga awet dan ramah lingkungan. Desainnya yang menarik dalam nuansa terkini dengan bahan yang berkualitas dengan sol yang elastis menjadikan sandal ini sangat cocok untuk anda gunakan di waktu santai.
                                Panduan ukuran:
                                - Size 26 : 15,9 cm
                                - Size 27 : 16,5 cm
                                - Size 28 : 17,1 cm
                                - Size 29 : 17,8 cm
                                - Size 30 : 18,1 cm
                                - Size 31 : 19,8 cm',
                'price' => 27000.00,
                'weight' => 200,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 16,
                'category_id' => 1,
                'name' => 'Sandal Pria Casual Dulux Slip kekinian 2 Strap',
                'slug' => 'sandal-pria-casual-dulux-slip-kekinian-2-strap',
                'description' => 'Sandal pria casual dulux dengan bahan karet EVA anti slip yang ringan, lentur enak dibuat beraktivitas seharian dengan harga murah
                                Panduan ukuran :
                                - Size 38 : 23 cm
                                - Size 39 : 23,5 cm
                                - Size 40 : 24 cm
                                - Size 41 : 24,4 cm
                                - Size 42 : 25 cm
                                - Size 43 : 25,5 cm',
                'price' => 27040.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 17,
                'category_id' => 3,
                'name' => 'Sandal Anak Baim Labubu',
                'slug' => 'sandal-anak-baim-labubu',
                'description' => 'Sandal Anak Baim Labubu dengan material EVA yang Nyaman, Ringan, dan Empuk. Bantal Kaki (Insole) Bertekstur Tinggi Elastis EVA. Sole Non-Slip dan Tahan Gesekan. Ringan dan Menjaga Kaki Anda Bebas Dari Tekanan. Menggunakan bahan baku EVA Premium berkualitas namun tetap dengan harga terjangkau. Sangat nyaman dipakai, bahan berkualitas sehingga tidak mudah rusak dan Awet. Cocok Untuk Dikenakan Indoor Maupun Outdoor. 
                                Panduan ukuran:
                                - Size 24 - 25 : 16 cm
                                - Size 26 - 27 : 17 cm
                                - Size 28 - 29 : 18 cm
                                - Size 30 - 31 : 19 cm
                                - Size 32 - 33 : 20 cm
                                - Size 34 - 35 : 21 cm',
                'price' => 25500.00,
                'weight' => 300,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 18,
                'category_id' => 1,
                'name' => 'Sandal Pria Gos Porto 1094M',
                'slug' => 'sandal-pria-gos-porto-1094m',
                'description' => 'Sandal jepit Karet Porto dengan bahan nyaman dan ringan, motif simple tapi elegant, anti slip cocok dalam segala kondisi dan keadaan. 
                                Panduan ukuran:
                                - Size 39 : 26 cm
                                - Size 40 : 26,6 cm
                                - Size 41 : 27 cm
                                - Size 42 : 27,5 cm
                                - Size 43 : 28 cm
                                - Size 44 : 28,5 cm',
                'price' => 24900.00,
                'weight' => 400,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 19,
                'category_id' => 1,
                'name' => 'Sandal Pria selop Porto 1023M',
                'slug' => 'sandal-pria-selop-porto-1023m',
                'description' => 'Sandal selop pria Porto dengan bahan karet EVA empuk, nyaman, ringan dan tidak licin
                                Panduan ukuran:
                                - Size 39 : 24 cm
                                - Size 40 : 24,5 cm
                                - Size 41 : 25 cm
                                - Size 42 : 25,5 cm
                                - Size 43 : 26 cm
                                - Size 44 : 26,5 cm',
                'price' => 38328.00,
                'weight' => 400,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 20,
                'category_id' => 1,
                'name' => 'Sandal Pria New Era MB E 7042',
                'slug' => 'sandal-pria-new-era-mb-e-7042',
                'description' => 'NEW ERA MB E 7042 Sandal Selop Sport New Era Dewasa Sendal Karet Anti Slip Casual Sandal Pria Keren Terbaru Original 39-44
                                Bahan: Karet phylon
                                Detail Size :
                                size 39/40-25,5 cm
                                size 41-26 cm
                                size 42=26,5 cm
                                size 43/44-27 cm',
                'price' => 35900.00,
                'weight' => 600,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 21,
                'category_id' => 2,
                'name' => 'Sandal Wanita Jepit New Era 9134',
                'slug' => 'sandal-wanita-jepit-new-era-9134',
                'description' => 'Sandal Jepit New Era 100% original dengan bahan karet, elastis, kuat, tidak licin dan empuk. 
                                Panduan ukuran:
                                - Size 37 24,5 cm
                                - Size 38 25. cm
                                - Size 39 = 25,5 cm
                                - Size 40 = 26 cm',
                'price' => 31000.00,
                'weight' => 550,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 22,
                'category_id' => 3,
                'name' => 'Sandal Anak Hilos Selop Pita M',
                'slug' => 'sandal-anak-hilos-selop-pita-m',
                'description' => 'Sandal anak Hilos Selop dengan bahan karet nyaman, empuk, model kekinian cocok untuk dipakai sehari-hari atau acara tertentu
                                Panduan ukuran:
                                - Size 24 - 25 : 15,5 cm
                                - Size 26 - 27 : 16,5 cm
                                - Size 28 - 29 : 17,5 cm
                                - Size 30 - 31 : 18,5 cm
                                - Size 32 - 33 : 19,5 cm
                                - Size 34 - 35 : 20,5 cm',
                'price' => 34000.00,
                'weight' => 300,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 23,
                'category_id' => 1,
                'name' => 'Sandal Pria Anti Slip Keep Drifting Fun',
                'slug' => 'sandal-pria-anti-slip-keep-drifting-fun',
                'description' => 'Sandal pria Selop keep drifting fun dengan bahan karet anti slip, tahan air, nyaman, model kekinian. 
                                Panduan ukuran:
                                - size 41 - 42 : 26,5 cm
                                - Size 43 - 44 : 27 cm',
                'price' => 32000.00,
                'weight' => 450,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 24,
                'category_id' => 3,
                'name' => 'Sandal Anak Jepit Karet Flip Flop',
                'slug' => 'sandal-anak-jepit-karet-flip-flop',
                'description' => 'Sandal anak dengan bahan sintesis premium, ringan, nyaman, empuk, nyaman di kaki dan tidak bikin capek. 
                                Panduan ukuran:
                                - Size 30 : 18,3 cm
                                - Size 31 : 18,9 cm
                                - Size 32 : 19,5 cm
                                - Size 33 : 21,1 cm
                                - Size 34 : 20,7 cm
                                - Size 35 : 21,3 cm',
                'price' => 25578.00,
                'weight' => 300,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 25,
                'category_id' => 2,
                'name' => 'Sandal Wanita Selop New Era elegant',
                'slug' => 'sandal-wanita-selop-new-era-elegant',
                'description' => 'Sandal wanita selop dengan bahan karet EVA kuat nyaman anti slip, empuk, ringan, mudah dibersihkan, dengan desain yang simple elegant dan modern. 
                                Panduan ukuran:
                                - Size 37 : 23 cm
                                - Size 38 : 24 cm
                                - Size 39 : 25 cm
                                - Size 40 : 26 cm',
                'price' => 36578.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 26,
                'category_id' => 3,
                'name' => 'Sandal Anak Casual Slip On Tali Belakang',
                'slug' => 'sandal-anak-casual-slip-on-tali-belakang',
                'description' => 'Sandal Sportif dari Hlos memiliki bahan yang tebal sehingga tidak mudah rusak, tidak licin dan tahan lama. Walaupun tebal, sandal ini tetap ringan untuk dipakai sehari-hari.
                                - Model: labubu
                                - Bahan: Karet, Elastis, Kuat, Tidak Licin, Anti Air dan Empuk
                                Size Chart:
                                - size 20 = ±12 cm
                                - size 21 = ±12.5 cm
                                - size 22 = ±13 cm
                                - size 23 = ±13.5 cm',
                'price' => 24500.00,
                'weight' => 300,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 27,
                'category_id' => 2,
                'name' => 'Sendal Wanita Dulux 693 Kekinian',
                'slug' => 'sandal-wanita-dulux-693-kekinian',
                'description' => 'Sandal wanita Dulux 693 adalah pilihan tepat untuk menambahkan gaya kekinian pada koleksi sepatu Anda.
                                Desain modern yang cocok untuk berbagai kesempatan.
                                Nyaman dipakai sepanjang hari.
                                Tersedia dalam berbagai ukuran terbaru.
                                Dapatkan penampilan stylish dan tetap nyaman dengan sandal ini!
                                Panduan ukuran:
                                - size 36 : 21,5 cm
                                - size 37 : 22 cm
                                - size 38 : 22,5 cm
                                - size 39 : 23 cm
                                - size 40 : 23,5 cm',
                'price' => 33000.00,
                'weight' => 550,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 28,
                'category_id' => 2,
                'name' => 'Sandal Wanita New Era Model Flat Dua Strap',
                'slug' => 'sandal-wanita-new-era-model-flat-dua-strap',
                'description' => 'Sendal slip on / selop yang merupakan sebuah produk sandal yang bergaya casual. cocok untuk menemani aktivitas sehari hari baik untuk bersantai anda maupun untuk berliburan. Anti slip, Sendal ini terbuat dari bahan yang nyaman saat digunakan, Cocok dipakai wanita, Ringan dan nyaman membuat penampilan anda yang sporty & elegan menjadi makin fashionable dan dimanis
                                Panduan ukuran:
                                - Size 38 : 22,5 cm
                                - Size 39 : 23 cm
                                - Size 40 : 23,5 cm',
                'price' => 28708.00,
                'weight' => 600,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 29,
                'category_id' => 1,
                'name' => 'Sandal Pria jepit casual New Era MB E 1253',
                'slug' => 'sandal-pria-jepit-casual-new-era-mb-e-1253',
                'description' => 'Sandal Jepit Pria Casual - New Era - Terbuat dari bahan berkualitas sehingga awet dan nyaman dipakai.
                                Dengan design yang trendy dan warna natural sehingga sangat cocok untuk dipakai saat santai & aktivitas sehari-hari.
                                OutSole / Sol Luar:
                                - 39:26cm
                                - 40: 26,5 cm
                                - 41:27 cm
                                - 42: 27,5 cm
                                - 43:28 cm',
                'price' => 35950.00,
                'weight' => 750,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 30,
                'category_id' => 1,
                'name' => 'Sandal Pria New Era 5087',
                'slug' => 'sandal-pria-new-era-5087',
                'description' => 'Sandal Pria jepit Terbuat dari bahan karet berkualitas tinggi, Produk sangat nyaman untuk beraktivitas, Bahan full karet, Tidak mudah rusak, Awet & empuk saat dipakai, Cocok untuk pemakaian sehari-hari
                                Panduan ukuran:
                                - Size 39 : 26 cm
                                - Size 40 : 26,5 cm
                                - Size 41 : 27 cm
                                - Size 42 : 27,5 cm
                                - Size 43 : 28 cm
                                - Size 44 : 28,5 cm',
                'price' => 34500.00,
                'weight' => 450,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 31,
                'category_id' => 1,
                'name' => 'Sandal Pria Vanchnee jepit 930L',
                'slug' => 'sandal-pria-vanchnee-jepit-930l',
                'description' => 'Terbuat dari bahan karet berkualitas tinggi, Produk sangat nyaman untuk beraktivitas, Bahan full karet, Tidak mudah rusak, Awet & empuk saat dipakai, Cocok untuk pemakaian sehari-hari
                                Panduan ukuran : 
                                - size 42 : 27,5 cm',
                'price' => 26500.00,
                'weight' => 300,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 32,
                'category_id' => 1,
                'name' => 'Sandal Pria Selop New Era MB 11137',
                'slug' => 'sandal-pria-selop-new-era-mb-11137',
                'description' => 'Sandal Slop pria New Era dengan bahan yang berkualitas nyaman digunakan untuk sehari-hari, empuk, anti licin
                                Panduan ukuran:
                                - size 40 : 24 cm
                                - size 41 : 24,5 cm
                                - size 42 : 25 cm
                                - size 43 : 25,5 cm',
                'price' => 33650.00,
                'weight' => 400,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 33,
                'category_id' => 2,
                'name' => 'Sandal Wanita Selop Porto Lady ZKS',
                'slug' => 'sandal-wanita-selop-porto-lady-zkl',
                'description' => 'Sandal Sepatu Wedges Sandal Wanita PORTO LADY ZKS
                                Sepatu Sandal Wedges dengan design kerut dibagian depan dan tali yang terbuat dari bahan berkualitas sehingga nyaman serta menggunakan model hak kotak agar tumit tidak terasa sakit. Cocok digunakan untuk acara formal ataupun non formal
                                Bahan: Karet PVC
                                Hak: -+ 5cm
                                Size Chart Ladies Sandal & Sepatu
                                No. 36 = 21,5 - 22,5 CM
                                No. 37 = 22,6 - 23,5 CM
                                No. 38 = 23,6 - 24,5 CM
                                No. 39 = 24,6 - 25,5 CM
                                No. 40 = 25,6 - 26,5 CM',
                'price' => 44650.00,
                'weight' => 650,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 34,
                'category_id' => 1,
                'name' => 'Sandal Pria Polos Slip on Hilos',
                'slug' => 'sandal-pria-polos-slip-on-hilos',
                'description' => 'Bahan EVA Tidak Licin, ringan, empuk, dan enak di pakai Bisa digunakan di kamar mandi, outdoor dan didalam rumah.
                                Size Produk Mengikuti Ukuran Kaki :
                                - 39 Insole 23 CM
                                - 40 Insole 24 CM
                                - 41 Insole 25 CM
                                - 42 Insole 26 CM
                                - 43 Insole 27 CM
                                - 44 Insole 28 CM',
                'price' => 30500.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 35,
                'category_id' => 2,
                'name' => 'Sandal Wanita Selop New Era LB E 9136',
                'slug' => 'sandal-wanita-selop-new-era-lb-e-9136',
                'description' => 'Sandal selop tali silang New Era, Sandal berbahan karet Eva/Phylon, model simple tali silang gesper, karet lentur, empuk dan pastinya tahan air
                                Panduan ukuran:
                                - size 37 : 23 cm
                                - size 38 : 23,5 cm
                                - size 39 : 24,5 cm',
                'price' => 32000.00,
                'weight' => 450,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 36,
                'category_id' => 1,
                'name' => 'Sandal Pria Selop G-Max Casual',
                'slug' => 'sandal-pria-selop-gmax-casual',
                'description' => 'Sandal selop pria casual, dengan bahan karet lentur, nyaman digunakan sehari-hari, anti air dan anti licin. 
                                Panduan ukuran:
                                - size 39 : 23 cm
                                - size 40 : 24 cm
                                - size 41 : 25 cm
                                - size 42 : 26 cm
                                - size 43 : 27 cm
                                - size 44 : 28 cm',
                'price' => 33000.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 37,
                'category_id' => 3,
                'name' => 'Sandal Anak TAKIDTOO Super Mario',
                'slug' => 'sandal-anak-takidtoo-super-mario',
                'description' => 'Sandal karet bermotif lucu, Bahan karet ringan, tebal dan berkualitas. Tahan lama dan tahan air, mudah dibersihkan. Cocok untuk berjalan jarak jauh tanpa sakit kaki
                                Size Produk Mengikuti Ukuran Kaki :
                                - 24/25:16.0 Cm
                                - 26/27: 17.0 Cm
                                - 28/29: 18.0 Cm
                                - 30/31:19.0 Cm
                                - 32/33: 20.0 Cm
                                - 34/35:21.0 Cm',
                'price' => 33500.00,
                'weight' => 300,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 38,
                'category_id' => 3,
                'name' => 'Sandal Jepit Anak Motif Anomali',
                'slug' => 'sandal-jepit-anak-motif-anomali',
                'description' => 'Sandal Jepit Anak Sehari-hari Bahan Karet Jelly Ringan Empuk, Elastis, Nyaman & Tidak Licin Dipakai. Kualitas Bagus',
                'price' => 26605.00,
                'weight' => 350,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 39,
                'category_id' => 3,
                'name' => 'Sandal Anak Jepit Jempol KicKers',
                'slug' => 'sandal-anak-jepit-jempol-kickers',
                'description' => 'Terbuat dari kulit sintetis premium, sandal ini nyaman dipakai sepanjang hari. Dilengkapi dengan outsole rubber PVC anti slip, memberikan keamanan ekstra saat berjalan. Bahan berkualitas ini memastikan sandal tahan lama dan tetap awet meskipun sering digunakan oleh anak-anak.',
                'price' => 33400.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 40,
                'category_id' => 3,
                'name' => 'Sandal Anak Slop Rabbit',
                'slug' => 'sandal-anak-slop-rabbit',
                'description' => 'Sandal Jepit Anak Sehari-hari Bahan Karet Jelly Ringan Empuk, Elastis, Nyaman & Tidak Licin Dipakai. Kualitas Bagus',
                'price' => 20000.00,
                'weight' => 200,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 41,
                'category_id' => 2,
                'name' => 'Sandal Slop Wanita Motif Sol Tebal',
                'slug' => 'sandal-slop-wanita-motif-sil-tebal',
                'description' => 'Bahan 100% brand new and high quality Rubber Anti Slip. Bahan karet ringan, tebal, berkualitas tinggi. Tahan lama dan tahan air, mudah dibersihkan. Cocok untuk jalan jauh tanpa nyeri kaki
                                Insole kurang lebih :
                                - 36-37: 22.5 cm
                                - 38-39: 23.5 cm
                                - 40-41: 24.5 cm',
                'price' => 32540.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 42,
                'category_id' => 2,
                'name' => 'Sandal Wanita Flat Premium',
                'slug' => 'sandal-wanita-flat-premium',
                'description' => 'Terbuat dari bahan berkualitas dengan harga yang terjangkau, model casual dan kekinian dengan resiko setelah pemakaian bikin ootd tambah cantik, cocok sekali untuk pemakaian sehari-hari temani segala aktivitasmu, baik itu dalam ruangan maupun diluar ruangan. memiliki karakter sandal yang empuk upper lembut, anti slip, nyaman, ringan dan waterproof. juga adalah jenis sandal Flatfrom yang tingi sandalnya ada di 2cm.',
                'price' => 67000.00,
                'weight' => 450,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 43,
                'category_id' => 2,
                'name' => 'Sandal Wanita Flat Teplek Tali Kepang Anyam',
                'slug' => 'sandal-wanita-flat-teplek-tali-kepang-anyam',
                'description' => 'Sandal kekinian super nyaman karena menggunakan material busa foam super dilapis bahan sintetis yang sangat lembut, dijamin sangat memanjakan kaki kalian guys! Siap menemani hari-harimu tanpa takut kaki sakit atau lecet. Kalau ada yang berkualitas harga terjangkau kenapa harus yang mahal? Buruan dapetin sekarang juga! Produk sudah termasuk dus packing (warna dus tergantung stok yang ada)
                                Panjang sol:
                                - 37 = 23cm
                                - 38 = 23,5 cm
                                - 39 = 24 cm
                                - 40 = 24,5 cm
                                - 41 = 25 cm',
                'price' => 40000.00,
                'weight' => 450,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 44,
                'category_id' => 2,
                'name' => 'Sandal Selop Wanita Karakter Kucing',
                'slug' => 'sandal-selop-wanita-karakter-kucing',
                'description' => 'Sandal Selop Motip Kucing Cute dengan desain yang simple, unik elegant, cocok untuk segala aktifitas wanita baik Di Rumah, anak Kuliah maupun yang sudah berkerja. Sandal Selop Karet mengunakan sol not slip sehingga sudah pasti nyaman serta tidak licin dan cocok di pakai waktu santai di rumah. Kondisi 100% baru dan kualitas nyama di pakai. Sol Full Rubber
                                Patong panjang kaki dan size
                                - 36: 22cm
                                - 37: 22.5cm
                                - 38:23cm
                                - 39: 23.5cm
                                - 40: 24cm',
                'price' => 19300.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 45,
                'category_id' => 2,
                'name' => 'Sandal Wanita Slip On Sandal Karet Jelly Korea',
                'slug' => 'sandal-wanita-slip-on-sandal-karet-jelly-korea',
                'description' => 'Desaint aesthetic dan tidak pasaran dengan hiasan yang lucu serta cocok untuk semua bentuk kaki. Material karet ringan, tebal, dan berkualitas. Tahan lama, tahan air, dan mudah dicuci. Sangat nyaman untuk berjalan lama dan tidak membuat kaki sakit. Bagian dalam lembut, sol tahan licin dan tahan gesekan.  Sandal lentur, elastis, dan tidak kaku ketika dunakan. Dapat dunakan di dalam rumah maupun diluar rumah.
                                Bahan: EVA (Tidak bau, sangat ringan, dan empuk)
                                Ukuran:
                                36-37: 23cm
                                38-39: 24cm
                                40-41: 25cm
                                42-43:26cm
                                44-45:27cm',
                'price' => 49520.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 46,
                'category_id' => 2,
                'name' => 'Sandal Jepit Wedges Wanita Karet',
                'slug' => 'sandal-jepit-wedges-wanita-karet',
                'description' => 'Sandal jepit wedges wanita ini terbuat dari bahan EVA rubber premium yang empuk, ringan, dan lentur. Desain cantik dengan hiasan bunga membuatnya cocok untuk gaya casual maupun semi formal. Sol tebal anti slip memberikan kenyamanan dan keamanan saat digunakan, baik di dalam maupun luar ruangan.',
                'price' => 35000.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 47,
                'category_id' => 2,
                'name' => 'Sandal Wanita Karet Jelly Tebal Bahan Karet Double Strap',
                'slug' => 'sandal-wanita-karet-jelly-tebal-bahan-karet-double-strap',
                'description' => 'Sandal karet bermotif lucu. Bahan karet ringan, tebal dan berkualitas. Tahan lama dan tahan air, mudah dibersihkan. Cocok untuk berjalan jarak jauh tanpa sakit kaki.',
                'price' => 35000.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 48,
                'category_id' => 2,
                'name' => 'Sandal Wanita NBS Font MinMin Bahan PVC',
                'slug' => 'sandal-wanita-nbs-font-minmin-bahan-pvc',
                'description' => 'Sandal NEW BUENOR Sangat nyaman digunakan, anti slip, kuat dan empuk dipakai. Serta insole di desain khusus mengikuti bentuk kontur kaki. Cocok dipakai di indoor/outdoor.',
                'price' => 37000.00,
                'weight' => 600,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 49,
                'category_id' => 1,
                'name' => 'Sandal Jepit Pria Flop Full Karet',
                'slug' => 'sandal-jepit-pria-flop-full-karet',
                'description' => 'Terbuat dari material karet EVA berkualitas Sandal Inkayni memiliki bahan yang tebal sehingga tidak mudah rusak tidak licin dan tahan lama. Walaupun tebal sandal ini tetap ringan untuk dipakai sehari-hari. Dengan harga yang murah anda bisa dapatkan kualitas sendal yang bagus Tersedia varian warna Hitam Abu Biru tua Coklat CMCMToleransi Ukuran 0.5-1 CM. Bahan anti air tidak licin elastis tebal serta kuat Bahan empuk dan tidak mudah rusak, tetap ringan untuk dipakai sehari-hari.',
                'price' => 34500.00,
                'weight' => 500,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 50,
                'category_id' => 1,
                'name' => 'Sandal Pria Jepit Distro Kekinian',
                'slug' => 'sandal-pria-jepit-distro-kekinian',
                'description' => 'Sandal Jepit Tomaselli Vittoria Terbaik Terbaru di tahun 2025 hadir dengan desain modern dan material yang memberikan keseimbangan antara gaya dan kenyamanan. sandal distro pria kekinian ini dilengkapi dengan outsole anti-slip serta bahan canvas berkualitas tinggi, sandal ini cocok untuk penggunaan sehari-hari (Tidak di rekomendasikan untuk penggunaan ekstream).',
                'price' => 49500.00,
                'weight' => 450,
                'is_active' => true,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('products')->insert($products);
    }
}
