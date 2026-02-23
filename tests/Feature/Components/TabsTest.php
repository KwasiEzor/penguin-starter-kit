<?php

/**
 * Tests for the Tabs, Tab, and TabPanel blade components.
 *
 * Verifies rendering of the tabbed interface including tab labels, panel content,
 * and proper ARIA role attributes for accessibility (tab and tabpanel roles).
 */

it('renders tabs component', function (): void {
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
