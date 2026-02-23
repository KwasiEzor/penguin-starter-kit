<?php

/**
 * Tests for the EmptyState blade component.
 *
 * Verifies rendering of empty state placeholders with the default title
 * and with custom title and description attributes.
 */

it('renders an empty state with default title', function (): void {
    $view = $this->blade('<x-empty-state />');

    $view->assertSee('No results found');
});

it('renders an empty state with custom title and description', function (): void {
    $view = $this->blade('<x-empty-state title="No posts" description="Create your first post to get started." />');

    $view->assertSee('No posts');
    $view->assertSee('Create your first post to get started.');
});
