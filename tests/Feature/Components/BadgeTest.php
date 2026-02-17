<?php

it('renders a default badge', function () {
    $view = $this->blade('<x-badge>New</x-badge>');

    $view->assertSee('New');
    $view->assertSee('rounded-full');
});

it('renders variant badges', function () {
    $view = $this->blade('<x-badge variant="success">Active</x-badge>');

    $view->assertSee('Active');
    $view->assertSee('bg-success/10');
});
