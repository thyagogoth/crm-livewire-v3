<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\{Can, User};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        foreach(Can::cases() as $can) {
            Gate::define(
                str($can->value)->snake('-')->toString(),
                fn (User $user) => $user->hasPermissionTo($can)
            );

        }
    }
}
