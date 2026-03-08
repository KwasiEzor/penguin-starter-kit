<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Livewire component to showcase and test UI components.
 */
#[Layout('layouts.app')]
final class Playground extends Component
{
    /**
     * Render the component view.
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.admin.playground');
    }
}
