<?php

it('renders a table with head and body', function (): void {
    $view = $this->blade('
        <x-table>
            <x-slot name="head">
                <x-table-heading>Name</x-table-heading>
            </x-slot>
            <tr>
                <x-table-cell>John</x-table-cell>
            </tr>
        </x-table>
    ');

    $view->assertSee('Name');
    $view->assertSee('John');
});

it('renders a sortable table heading', function (): void {
    $view = $this->blade('<x-table-heading :sortable="true" direction="asc">Name</x-table-heading>');

    $view->assertSee('Name');
});
