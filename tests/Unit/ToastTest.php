<?php

use App\Support\Toast;

it('flashes a success toast to the session', function () {
    Toast::success('It worked!');

    expect(session('notify'))->toBe([
        'content' => 'It worked!',
        'type' => 'success',
    ]);
});

it('flashes an error toast to the session', function () {
    Toast::error('Something failed');

    expect(session('notify'))->toBe([
        'content' => 'Something failed',
        'type' => 'error',
    ]);
});

it('flashes a warning toast to the session', function () {
    Toast::warning('Be careful');

    expect(session('notify'))->toBe([
        'content' => 'Be careful',
        'type' => 'warning',
    ]);
});

it('flashes an info toast to the session', function () {
    Toast::info('FYI');

    expect(session('notify'))->toBe([
        'content' => 'FYI',
        'type' => 'info',
    ]);
});
