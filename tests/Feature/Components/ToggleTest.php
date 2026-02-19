<?php

it('renders a toggle switch', function (): void {
    $view = $this->blade('<x-toggle id="notifications">Enable notifications</x-toggle>');

    $view->assertSee('Enable notifications');
    $view->assertSee('role="switch"', false);
});

it('renders a disabled toggle', function (): void {
    $view = $this->blade('<x-toggle id="test" :disabled="true" />');

    $view->assertSee('disabled');
});
