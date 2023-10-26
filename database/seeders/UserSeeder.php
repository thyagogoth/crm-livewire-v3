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
                'password' => 'password',
            ]);

        User::factory()
            ->withPermission(Can::BE_AN_ADMIN)
            ->create([
                'name'     => 'Thiago F. da Rosa',
                'email'    => 'thyagogoth@gmail.com',
                'password' => '4n0n3ff3ct',
            ]);

        User::factory()
            ->withPermission(Can::TESTING)
            ->count(82)
            ->create();

    }
}
