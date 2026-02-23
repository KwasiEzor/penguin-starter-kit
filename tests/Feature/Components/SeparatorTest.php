<?php

/**
 * Tests for the Separator blade component.
 *
 * Verifies rendering of horizontal and vertical separators with correct
 * border classes, and separators with inline text content.
 */

it('renders a horizontal separator by default', function (): void {
    $view = $this->blade('<x-separator />');

    $view->assertSee('border-t');
});

it('renders a vertical separator', function (): void {
    $view = $this->blade('<x-separator vertical />');

    $view->assertSee('border-l');
});

it('renders a separator with text', function (): void {
    $view = $this->blade('<x-separator text="or" />');

    $view->assertSee('or');
});
