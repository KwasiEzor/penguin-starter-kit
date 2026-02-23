<?php

/**
 * Tests for the Badge blade component.
 *
 * Verifies rendering of badges with default styling and variant-specific
 * appearances such as success, including correct background color classes.
 */

it('renders a default badge', function (): void {
    $view = $this->blade('<x-badge>New</x-badge>');

    $view->assertSee('New');
    $view->assertSee('rounded-full');
});

it('renders variant badges', function (): void {
    $view = $this->blade('<x-badge variant="success">Active</x-badge>');

    $view->assertSee('Active');
    $view->assertSee('bg-success/10');
});
