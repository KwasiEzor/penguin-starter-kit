<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use Livewire\Component;

final class Appearance extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.settings.appearance');
    }
}
