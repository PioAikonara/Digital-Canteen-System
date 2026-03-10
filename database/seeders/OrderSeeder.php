<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Menu;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari customer (buat customer dummy jika belum ada)
        $customer = User::where('role', 'customer')->first();
        
        if (!$customer) {
            $customer = User::create([
                'name' => 'Customer Test',
                'email' => 'customer@test.com',
                'password' => bcrypt('password'),
                'role' => 'customer',
            ]);
        }

        $customer2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        // Ambil menu yang ada
        $menus = Menu::all();

        if ($menus->count() > 0) {
            // Pesanan 1 - Pending
            Order::create([
                'user_id' => $customer->id,
                'menu_id' => $menus->random()->id,
                'quantity' => 2,
                'total_price' => 30000,
                'pickup_time' => 'istirahat_1',
                'status' => 'pending',
                'notes' => 'Pedas sedang ya',
            ]);

            // Pesanan 2 - Preparing
            Order::create([
                'user_id' => $customer2->id,
                'menu_id' => $menus->random()->id,
                'quantity' => 1,
                'total_price' => 15000,
                'pickup_time' => 'istirahat_1',
                'status' => 'preparing',
                'notes' => null,
            ]);

            // Pesanan 3 - Ready
            Order::create([
                'user_id' => $customer->id,
                'menu_id' => $menus->random()->id,
                'quantity' => 3,
                'total_price' => 24000,
                'pickup_time' => 'istirahat_2',
                'status' => 'ready',
                'notes' => 'Es nya banyak',
            ]);

            // Pesanan 4 - Pending
            Order::create([
                'user_id' => $customer2->id,
                'menu_id' => $menus->random()->id,
                'quantity' => 1,
                'total_price' => 12000,
                'pickup_time' => 'istirahat_2',
                'status' => 'pending',
            ]);

            // Pesanan 5 - Ready
            Order::create([
                'user_id' => $customer->id,
                'menu_id' => $menus->random()->id,
                'quantity' => 2,
                'total_price' => 16000,
                'pickup_time' => 'istirahat_1',
                'status' => 'ready',
                'notes' => 'Tanpa sayur',
            ]);

            echo "✅ Sample orders created successfully!\n";
        } else {
            echo "⚠️ No menus found. Please run MenuSeeder first.\n";
        }
    }
}
