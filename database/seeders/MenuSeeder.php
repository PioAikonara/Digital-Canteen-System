<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Nasi Goreng',
                'category' => 'makanan',
                'price' => 15000,
                'description' => 'Nasi goreng spesial dengan telur dan ayam',
                'is_available' => true,
            ],
            [
                'name' => 'Mie Ayam',
                'category' => 'makanan',
                'price' => 12000,
                'description' => 'Mie ayam dengan bakso',
                'is_available' => true,
            ],
            [
                'name' => 'Es Teh Manis',
                'category' => 'minuman',
                'price' => 3000,
                'description' => 'Es teh manis segar',
                'is_available' => true,
            ],
            [
                'name' => 'Jus Jeruk',
                'category' => 'minuman',
                'price' => 8000,
                'description' => 'Jus jeruk segar tanpa gula',
                'is_available' => true,
            ],
            [
                'name' => 'Soto Ayam',
                'category' => 'makanan',
                'price' => 13000,
                'description' => 'Soto ayam dengan nasi',
                'is_available' => false,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }

        echo "✅ Sample menu created successfully!\n";
    }
}
