<?php

it('renders an empty state with default title', function () {
    $view = $this->blade('<x-empty-state />');

    $view->assertSee('No results found');
});

it('renders an empty state with custom title and description', function () {
    $view = $this->blade('<x-empty-state title="No posts" description="Create your first post to get started." />');

    $view->assertSee('No posts');
    $view->assertSee('Create your first post to get started.');
});
