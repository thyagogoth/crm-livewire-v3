<?php

use App\Livewire\Auth\Login;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Login::class)
        ->assertOk();
});

it('should be able to login', function () {

    $user = \App\Models\User::factory()->create([
        'email'    => 'joe@doe.com',
        'password' => '12345678',
    ]);

    Livewire::test(Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', '12345678')
        ->call('tryToLogin')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));

});

it('should make sure to inform the user an error when login do not work', function () {

    Livewire::test(Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', '12345678')
        ->call('tryToLogin')
        ->assertHasErrors(['invalidCredentials'])
        ->assertSee(trans('auth.failed'));

});

it('should make sure that the rate limiting is blocking after 5 attempts', function () {
    $user = \App\Models\User::factory()->create();

    for ($i = 0; $i < 5; $i++) {
        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', '1213213')
            ->call('tryToLogin')
            ->assertHasErrors(['invalidCredentials']);

    }

    Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', '1213213')
        ->call('tryToLogin')
        ->assertHasErrors(['rateLimiter']);
});
