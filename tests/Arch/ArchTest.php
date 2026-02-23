<?php

/**
 * Architecture tests for the application.
 *
 * Enforces coding standards and architectural constraints across the codebase,
 * including strict types usage, absence of debug functions, Livewire component
 * conventions, invokable actions, string-backed enums, restricted env() usage,
 * notification inheritance, and middleware method requirements.
 */

declare(strict_types=1);

arch('all app files use strict types')
    ->expect('App')
    ->toUseStrictTypes();

arch('no debug functions are left in the codebase')
    ->expect(['dd', 'dump', 'ray', 'var_dump', 'print_r'])
    ->not->toBeUsed();

arch('livewire components are final')
    ->expect('App\Livewire')
    ->not->toBeAbstract()
    ->ignoring('App\Livewire\Concerns')
    ->ignoring('App\Livewire\Forms');

arch('livewire components extend Component')
    ->expect('App\Livewire')
    ->toExtend(\Livewire\Component::class)
    ->ignoring('App\Livewire\Concerns')
    ->ignoring('App\Livewire\Forms');

arch('actions are invokable')
    ->expect('App\Actions')
    ->toBeInvokable();

arch('enums are string-backed')
    ->expect('App\Enums')
    ->toBeStringBackedEnums();

arch('env() is not used outside config and providers')
    ->expect('env')
    ->not->toBeUsed()
    ->ignoring('App\Providers');

arch('notifications extend Notification')
    ->expect('App\Notifications')
    ->toExtend(\Illuminate\Notifications\Notification::class);

arch('middleware has handle method')
    ->expect('App\Http\Middleware')
    ->toHaveMethod('handle');
