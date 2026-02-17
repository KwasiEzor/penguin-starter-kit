<?php

it('renders tabs component', function () {
    $view = $this->blade('
        <x-tabs active="first">
            <x-slot name="tabs">
                <x-tab name="first">First</x-tab>
                <x-tab name="second">Second</x-tab>
            </x-slot>
            <x-tab-panel name="first">First content</x-tab-panel>
            <x-tab-panel name="second">Second content</x-tab-panel>
        </x-tabs>
    ');

    $view->assertSee('First');
    $view->assertSee('Second');
    $view->assertSee('First content');
    $view->assertSee('role="tab"', false);
    $view->assertSee('role="tabpanel"', false);
});
