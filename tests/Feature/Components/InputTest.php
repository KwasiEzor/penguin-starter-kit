<?php

/**
 * Tests for the Input blade component.
 *
 * Verifies rendering of text inputs with proper name attributes and styling,
 * as well as the password variant with its show/hide toggle functionality.
 */

it('renders a text input by default', function (): void {
    $view = $this->blade('<x-input name="email" />');

    $view->assertSee('name="email"', false);
    $view->assertSee('rounded-radius');
});

it('renders a password input with toggle', function (): void {
    $view = $this->blade('<x-input variant="password" name="password" />');

    $view->assertSee('showPassword');
    $view->assertSee('name="password"', false);
});
