<?php

/**
 * Tests for the Button blade component.
 *
 * Verifies rendering of buttons with different variants (primary, danger),
 * size options, and the ability to render as an anchor tag when an href is provided.
 */

it('renders a primary button by default', function (): void {
    $view = $this->blade('<x-button>Click me</x-button>');

    $view->assertSee('Click me');
    $view->assertSee('bg-primary');
});

it('renders a danger variant button', function (): void {
    $view = $this->blade('<x-button variant="danger">Delete</x-button>');

    $view->assertSee('Delete');
    $view->assertSee('bg-danger');
});

it('renders as an anchor when href is provided', function (): void {
    $view = $this->blade('<x-button href="/test">Link</x-button>');

    $view->assertSee('href="/test"', false);
    $view->assertSee('Link');
});

it('renders different sizes', function (): void {
    $view = $this->blade('<x-button size="sm">Small</x-button>');

    $view->assertSee('Small');
    $view->assertSee('text-sm');
});
