<?php

/**
 * Tests for the Select blade component.
 *
 * Verifies rendering of select dropdowns with proper name attributes,
 * option elements, styling classes, and the disabled state.
 */

it('renders a select element', function (): void {
    $view = $this->blade('<x-select name="role"><option value="admin">Admin</option></x-select>');

    $view->assertSee('name="role"', false);
    $view->assertSee('Admin');
    $view->assertSee('rounded-radius');
});

it('renders a disabled select', function (): void {
    $view = $this->blade('<x-select :disabled="true"><option>Test</option></x-select>');

    $view->assertSee('disabled');
});
