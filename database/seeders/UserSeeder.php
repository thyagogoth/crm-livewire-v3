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
        $admin = User::factory()
            ->withPermission(Can::BE_AN_ADMIN)
            ->create([
                'name'     => 'Admin do CRM',
                'email'    => 'admin@crm.com',
                'password' => 'password',
            ]);

        $admin->givePermissionTo(Can::BE_AN_ADMIN);

        User::factory()
            ->withPermission(Can::TESTING)
            ->count(68)
            ->create();

        User::factory()
            ->withPermission(Can::TESTING)
            ->count(27)
            ->deleted()
            ->create();

        $me = User::factory()
            ->withPermission(Can::BE_AN_ADMIN)
            ->create([
                'name'     => 'Thiago F. da Rosa',
                'email'    => 'thyagogoth@gmail.com',
                'password' => '4n0n3ff3ct',
            ]);

        $me->givePermissionTo(Can::BE_AN_ADMIN);

    }
}
