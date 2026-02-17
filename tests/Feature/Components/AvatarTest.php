<?php

it('renders an avatar with initials', function () {
    $view = $this->blade('<x-avatar initials="JD" />');

    $view->assertSee('JD');
    $view->assertSee('rounded-full');
});

it('renders an avatar with image', function () {
    $view = $this->blade('<x-avatar src="/img/user.jpg" alt="John" />');

    $view->assertSee('src="/img/user.jpg"', false);
    $view->assertSee('alt="John"', false);
});
