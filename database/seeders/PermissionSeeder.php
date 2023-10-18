<?php

namespace Database\Seeders;

use App\Models\{Can, Permission};
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'key' => Can::BE_AN_ADMIN,
        ]);
    }
}
