<?php

use App\Livewire\Admin;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('should be able to show all the details of the user in the component', function () {
    $admin = User::factory()->admin()->create();
    $user  = User::factory()->deleted()->create();

    actingAs($admin);

    Livewire::test(Admin\Users\Show::class)
        ->call('load', $user->id)
        ->assertSet('user.id', $user->id)
        ->assertSet('modal', true)
        ->assertSee($user->name)
        ->assertSee($user->email)
        ->assertSee($user->created_at->format('d/m/Y H:i'))
        ->assertSee($user->updated_at->format('d/m/Y H:i'))
        ->assertSee($user->deleted_at->format('d/m/Y H:i'))
        ->assertSee($user->deletedBy->name);
});

it('should open the modal when the event is dispatched', function () {
    $admin = User::factory()->admin()->create();
    $user  = User::factory()->deleted()->create();

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->call('showUser', $user->id)
        ->assertDispatched('user::show', id: $user->id);
});

test('making sure that the method load has the attribute On', function () {
    $reflection = new ReflectionClass(new Admin\Users\Show());

    $attributes = $reflection->getMethod('load')->getAttributes();

    expect($attributes)->toHaveCount(1);

    /** @var ReflectionAttribute $attribute */
    $attribute = $attributes[0];

    expect($attribute)->getName()->toBe('Livewire\Attributes\On')
        ->and($attribute)->getArguments()->toHaveCount(1);

    $argument = $attribute->getArguments()[0];
    expect($argument)->toBe('user::show');
});

test('check if component is in the page', function () {
    actingAs(User::factory()->admin()->create());
    Livewire::test(Admin\Users\Index::class)
        ->assertContainsLivewireComponent('admin.users.show');
});
