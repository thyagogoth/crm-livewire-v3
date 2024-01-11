<?php

it('should be able to list all users of the system', function () {
    \App\Models\User::factory()->count(10)->create();

    $users = \App\Models\User::all();

    Livewire::test(\App\Livewire\Dev\Login::class)
        ->assertSet('users', $users)
        ->assertSee($users->first()->name);
});


it ( 'should be able to login with any user', function(){
    $user = \App\Models\User::factory()->create();

    Livewire::test(\App\Livewire\Dev\Login::class)
        ->set('selectedUser', $user->id)
        ->call('login')
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);
});
