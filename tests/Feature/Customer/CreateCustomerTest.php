<?php

use App\Livewire\Customers;
use App\Models\User;

use function Pest\Laravel\{ actingAs, assertDatabaseHas };

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should be able to create a customer', function () {
    Livewire::test(Customers\Create::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@doe.com')
        ->set('phone', '1234567890')
        ->call('save')
        ->assertHasNoErrors();
    //        ->assertRedirectToRoute('customers.show', ['customer' => 1]);

    assertDatabaseHas('customers', [
        'name'  => 'John Doe',
        'email' => 'john@doe.com',
        'phone' => '1234567890',
        'type'  => 'customer',
    ]);
});

test('name should be required', function () {
    Livewire::test(Customers\Create::class)
        ->set('name', '')
        ->call('save')
        ->assertHasErrors(['name' => 'required']);
});

test('name should be at least 3 characters', function () {
    Livewire::test(Customers\Create::class)
        ->set('name', 'Jo')
        ->call('save')
        ->assertHasErrors(['name' => 'min']);
});

test('name must have a maximum of 120 characters', function () {
    Livewire::test(Customers\Create::class)
        ->set('name', 'THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA THIAGO FERNANDO DA ROSA')
        ->call('save')
        ->assertHasErrors(['name' => 'max']);
});

test('email required if we dont have a phone, email, unique:customers, email', function () {
    Livewire::test(Customers\Create::class)
        ->set('phone', '')
        ->set('email', '')
        ->call('save')
        ->assertHasErrors(['email' => 'required']);
})->todo();

//test('email should be required', function () {
//    Livewire::test(Customers\Create::class)
//        ->set('email', '')
//        ->call('save')
//        ->assertHasErrors(['email' => 'required']);
//});
