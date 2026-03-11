<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'makanan', 'icon' => 'solar:bowl-spoon-bold',  'color' => '#F97316'],
            ['name' => 'minuman', 'icon' => 'solar:cup-hot-bold',      'color' => '#3B82F6'],
            ['name' => 'snack',   'icon' => 'solar:cookie-minimalistic-bold', 'color' => '#8B5CF6'],
        ];

        foreach ($categories as $cat) {
            DB::table('menu_categories')->updateOrInsert(
                ['name' => $cat['name']],
                array_merge($cat, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
