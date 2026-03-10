<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@dcs.id'],
            [
                'name'       => 'Super Admin',
                'password'   => Hash::make('superadmin123'),
                'role'       => 'super_admin',
                'balance'    => 0,
                'is_active'  => true,
            ]
        );

        $this->command->info('Super Admin created: superadmin@dcs.id / superadmin123');
    }
}
