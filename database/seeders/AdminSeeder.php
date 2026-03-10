<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@canteen.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        echo "✅ Admin created: admin@canteen.com (password: admin123)\n";
    }
}
