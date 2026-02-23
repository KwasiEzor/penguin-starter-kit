<?php

/**
 * Tests for the Alert blade component.
 *
 * Verifies rendering of alert messages with different variants (info, danger, etc.),
 * correct ARIA role attributes, and dismissible alert functionality.
 */

it('renders an info alert by default', function (): void {
    $view = $this->blade('<x-alert>Something happened</x-alert>');

    $view->assertSee('Something happened');
    $view->assertSee('role="alert"', false);
    $view->assertSee('bg-info/10');
});

it('renders variant alerts', function (): void {
    $view = $this->blade('<x-alert variant="danger">Error occurred</x-alert>');

    $view->assertSee('Error occurred');
    $view->assertSee('bg-danger/10');
});

it('renders a dismissible alert', function (): void {
    $view = $this->blade('<x-alert :dismissible="true">Closeable</x-alert>');

    $view->assertSee('Closeable');
    $view->assertSee('Dismiss');
});
