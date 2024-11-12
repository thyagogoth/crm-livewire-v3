<?php

namespace Database\Seeders;

use App\Enums\Can;
use App\Models\{User};
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $me = User::factory()
            ->withPermission(Can::BE_AN_ADMIN)
            ->create([
                'name'     => 'Thiago F. da Rosa',
                'email'    => 'thyagogoth@gmail.com',
                'password' => 'password',
            ]);

        $me->givePermissionTo(Can::BE_AN_ADMIN);

        $admin = User::factory()
            ->withPermission(Can::BE_AN_ADMIN)
            ->create([
                'name'     => 'Admin do CRM',
                'email'    => 'admin@crm.com',
                'password' => 'password',
            ]);

        $this->normalUsers();

        $this->deletedUsers($me);

    }

    private function defaultDefinition(): array
    {
        return array_merge((new UserFactory())->definition(), ['password' => '$2y$10$Ybe7g6ojOtQLVDmX914YUeCqdpfKmuOkPlA9n0zvH.3HLO0u0PA56']);
    }

    private function normalUsers(): void
    {
        User::query()->insert(
            array_map(
                fn () => $this->defaultDefinition(),
                range(1, 50)
            )
        );
    }

    private function deletedUsers(User $admin): void
    {
        User::query()->insert(
            array_map(
                fn () => array_merge(
                    $this->defaultDefinition(),
                    [
                        'deleted_at' => now(),
                        'deleted_by' => $admin->id,
                    ]
                ),
                range(1, 50)
            )
        );
    }
}
