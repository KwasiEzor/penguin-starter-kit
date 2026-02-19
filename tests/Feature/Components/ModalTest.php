<?php

it('renders a modal with trigger and content', function (): void {
    $view = $this->blade('
        <x-modal>
            <x-slot:trigger>
                <button x-on:click="modalIsOpen = true">Open</button>
            </x-slot:trigger>
            <x-slot:header>
                <h3>Title</h3>
            </x-slot:header>
            Modal body content
        </x-modal>
    ');

    $view->assertSee('Open');
    $view->assertSee('Title');
    $view->assertSee('Modal body content');
    $view->assertSee('modalIsOpen');
});
