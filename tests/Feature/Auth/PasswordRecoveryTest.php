<?php

test('needs to have route to password recovery', function () {
    $this->get(route('auth.password.recovery'))
        ->assertStatus(200);
});
