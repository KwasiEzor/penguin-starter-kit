<?php

it('renders a textarea', function (): void {
    $view = $this->blade('<x-textarea name="body">Hello</x-textarea>');

    $view->assertSee('name="body"', false);
    $view->assertSee('Hello');
    $view->assertSee('rounded-radius');
});

it('renders a disabled textarea', function (): void {
    $view = $this->blade('<x-textarea :disabled="true" />');

    $view->assertSee('disabled');
});
