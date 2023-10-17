<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->withPermission('be an admin')
            ->create([
                'name'  => 'Admin CRM',
                'email' => 'admin@crm.com',
            ]);

        //        User::factory()->create([
        //            'name'     => 'Thiago F. da Rosa',
        //            'email'    => 'thyagogoth@gmail.com',
        //            'password' => Hash::make('4n0n3ff3ct'),
        //        ]);
    }
}
