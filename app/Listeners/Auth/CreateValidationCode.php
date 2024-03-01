<?php

namespace App\Listeners\Auth;

use App\Events\SendNewCode;
use App\Notifications\Auth\ValidationCodeNotification;
use Illuminate\Auth\Events\Registered;

class CreateValidationCode
{
    /** @phpstan-ignore-next-line */
    public function handle(Registered|SendNewCode $event): void
    {
        /** @phpstan-ignore-next-line */
        $user = $event->user;

        /** @phpstan-ignore-next-line */
        $user->validation_code = random_int(100000, 999999);
        $user->save();

        $user->notify(new ValidationCodeNotification());
    }

}
