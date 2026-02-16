<?php

it('renders a horizontal separator by default', function () {
    $view = $this->blade('<x-separator />');

    $view->assertSee('border-t');
});

it('renders a vertical separator', function () {
    $view = $this->blade('<x-separator vertical />');

    $view->assertSee('border-l');
});

it('renders a separator with text', function () {
    $view = $this->blade('<x-separator text="or" />');

    $view->assertSee('or');
});
