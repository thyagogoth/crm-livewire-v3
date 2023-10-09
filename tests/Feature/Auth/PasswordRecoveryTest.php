<?php

use App\Livewire\Auth\Password\Recovery;
use App\Models\User;
use App\Notifications\PasswordRecoveryNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\get;

test('needs to have route to password recovery', function () {
    get(route('auth.password.recovery'))
        ->assertSeeLivewire('auth.password.recovery');
});

it('should be able to request for a password recovery', function() {
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->create();

    Livewire::test(Recovery::class)
        ->assertDontSee('You will receive an email with the password recovery link')
        ->set('email', $user->email)
        ->call('startPasswordRecovery')
        ->assertSee('You will receive an email with the password recovery link');

    Notification::assertSentTo($user, PasswordRecoveryNotification::class );
});

test('making sure the email is a real email', function($value, $rule) {
    Livewire::test(Recovery::class)
        ->set('email', $value)
        ->call('startPasswordRecovery')
        ->assertHasErrors(['email' => 'email']);
})->with([
    'required' => ['value' => null, 'rule' => 'required'],
    'email' => ['value' => 'any email', 'rule' => 'email']
]);
