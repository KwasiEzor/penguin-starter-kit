<?php

it('renders a card with content', function () {
    $view = $this->blade('<x-card>Card content</x-card>');

    $view->assertSee('Card content');
    $view->assertSee('rounded-radius');
});

it('renders a card with header and footer', function () {
    $view = $this->blade('
        <x-card>
            <x-slot name="header">Header</x-slot>
            Body
            <x-slot name="footer">Footer</x-slot>
        </x-card>
    ');

    $view->assertSee('Header');
    $view->assertSee('Body');
    $view->assertSee('Footer');
});
