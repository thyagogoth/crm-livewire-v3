<?php

namespace Database\Seeders;

use App\Enums\Can;
use App\Models\{User};
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->withPermission(Can::BE_AN_ADMIN)
            ->create([
                'name'     => 'Admin CRM',
                'email'    => 'admin@crm.com',
                'password' => '4n0n3ff3ct',
            ]);

    }
}
