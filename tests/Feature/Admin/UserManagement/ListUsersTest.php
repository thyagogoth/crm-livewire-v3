<?php

use App\Enums\Can;
use App\Livewire\Admin;

use App\Models\{Permission, User};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};

it('should be able to access the route admin/users', function () {
    actingAs(User::factory()->admin()->create());

    get(route('admin.users'))
     ->assertOk();
});

test('making sure that route is protected by BE_AN_ADMIN permission', function () {
    actingAs(User::factory()->create());

    get(route('admin.users'))
        ->assertForbidden();
});

test("let's create a livewire component to list all users in the page", function () {
    actingAs(User::factory()->admin()->create());
    $users = User::factory()->count(10)->create();

    $lw = Livewire::test(Admin\Users\Index::class);
    $lw->assertSet('users', function ($users) {
        expect($users)
            ->toHaveCount(11);

        return true;
    });

    foreach ($users as $user) {
        $lw->assertSee($user->name);
    }
});

test('check the table format', function () {
    actingAs(User::factory()->admin()->create());

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('headers', [
            ['key' => 'id', 'label' => '#', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'name', 'label' => 'Name', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'email', 'label' => 'Email', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'permissions', 'label' => 'Permissions', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
        ]);
});

it('should be able to filter by name and email', function () {
    $admin      = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $normalUser = User::factory()->create(['name' => 'Mario', 'email' => 'little_guy@gmail.com']);

    actingAs($admin);
    Livewire::test(Admin\Users\Index::class)
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(2);

            return true;
        })
        ->set('search', 'mar')
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(1)
                ->first()->name->toBe('Mario');

            return true;
        })
        ->set('search', 'guy')
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(1)
                ->first()->name->toBe('Mario');

            return true;
        });
});

it('should be able to filter by permission key', function () {
    $admin             = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $normalUser        = User::factory()->withPermission(Can::TESTING)->create(['name' => 'Mario', 'email' => 'little_guy@gmail.com']);
    $permissionAdmin   = Permission::where('key', Can::BE_AN_ADMIN->value)->first();
    $permissionTesting = Permission::where('key', Can::TESTING->value)->first();

    actingAs($admin);
    Livewire::test(Admin\Users\Index::class)
        ->assertSet('users', function ($users) {
            expect($users)->toHaveCount(2);

            return true;
        })
        ->set('search_permissions', [$permissionAdmin->id, $permissionTesting->id])
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(2);
            //                ->first()->name->toBe('Joe Doe');

            return true;
        });
});

it('should be able to list deleted users', function () {
    $admin        = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $deletedUsers = User::factory()->count(2)->create(['deleted_at' => now()]);

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(1);

            return true;
        })
    ->set('search_trash', true)
    ->assertSet('users', function ($users) {
        expect($users)
            ->toHaveCount(2);

        return true;
    });

});

test('should be able to delete an user', function () {
    $admin      = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $normalUser = User::factory()->create();

    actingAs($admin);

    Livewire::test(
        Admin\Users\Index::class,
        ['users' => $users = User::query()->paginate(10)]
    )
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(2);

            return true;
        })
        ->call('delete', $normalUser->id)
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(1);

            return true;
        });
});

it('should be able to restore a deleted user', function () {
    $admin       = User::factory()->admin()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $deletedUser = User::factory()->create(['deleted_at' => now()]);

    actingAs($admin);

    Livewire::test(
        Admin\Users\Index::class,
        [
            'users' => User::withTrashed()->find($deletedUser->id)]
    )
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(1);

            return true;
        })
        ->call('restore', $deletedUser->id)
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(2);

            return true;
        });

});