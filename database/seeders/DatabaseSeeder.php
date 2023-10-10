<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        User::factory(10)->create();

        User::factory()->create([
            'name'  => 'Guart User',
            'email' => 'guest@example.com',
        ]);
//
//        User::factory()->create([
//            'name'     => 'Thiago F. da Rosa',
//            'email'    => 'thyagogoth@gmail.com',
//            'password' => Hash::make('4n0n3ff3ct'),
//        ]);
    }
}
