<?php

use App\Livewire\Auth\Logout;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should be able to logout of the application', function () {
    $user = \App\Models\User::factory()->create();

    actingAs($user);

    Livewire::test(Logout::class)
        ->call('logout')
        ->assertRedirect(route('login'));

    expect(auth()
    ->guest())->toBeTrue();

});
