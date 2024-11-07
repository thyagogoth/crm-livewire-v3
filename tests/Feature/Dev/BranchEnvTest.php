<?php

use App\Livewire\Dev\BranchEnv;
use App\Models\User;

use Illuminate\Support\Facades\Process;

use function Pest\Laravel\{actingAs, get};

it('should show a current branch in the page', function () {

    Process::fake([
        'git branch --show-current' => Process::result('jeremias'),
    ]);

    Livewire::test(BranchEnv::class)
        ->assertSet('branch', 'jeremias')
        ->assertSee('jeremias');

    Process::assertRan('git branch --show-current');

});

it('should load the livewire component on non production environments', function () {
    $user = User::factory()->create();

    app()->detectEnvironment(fn () => 'local');

    actingAs($user);

    get(route('dashboard'))
        ->assertStatus(200)
        ->assertSeeLivewire('dev.branch-env');

    get(route('login'));
});
