<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'Sandal Pria',
                'slug' => 'sandal-pria',
                'description' => 'Koleksi sandal untuk pria dengan berbagai model dan desain',
                'image' => 'categories/sandal-pria.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Sandal Wanita',
                'slug' => 'sandal-wanita',
                'description' => 'Koleksi sandal untuk wanita dengan model trendy dan stylish',
                'image' => 'categories/sandal-wanita.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Sandal Anak',
                'slug' => 'sandal-anak',
                'description' => 'Sandal untuk anak-anak dengan warna-warna cerah dan menarik',
                'image' => 'categories/sandal-anak.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Sandal Jepit',
                'slug' => 'sandal-jepit',
                'description' => 'Sandal jepit casual untuk aktivitas sehari-hari',
                'image' => 'categories/sandal-jepit.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Sandal Gunung',
                'slug' => 'sandal-gunung',
                'description' => 'Sandal dengan grip kuat untuk aktivitas outdoor dan mendaki',
                'image' => 'categories/sandal-gunung.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('categories')->insert($categories);
    }
}
