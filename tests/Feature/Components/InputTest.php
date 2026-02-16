<?php

it('renders a text input by default', function () {
    $view = $this->blade('<x-input name="email" />');

    $view->assertSee('name="email"', false);
    $view->assertSee('rounded-radius');
});

it('renders a password input with toggle', function () {
    $view = $this->blade('<x-input variant="password" name="password" />');

    $view->assertSee('showPassword');
    $view->assertSee('name="password"', false);
});
