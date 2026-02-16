<?php

namespace App\Livewire\Concerns;

trait HasToast
{
    public function toastSuccess(string $content): void
    {
        $this->toast($content, 'success');
    }

    public function toastWarning(string $content): void
    {
        $this->toast($content, 'warning');
    }

    public function toastError(string $content): void
    {
        $this->toast($content, 'error');
    }

    public function toastInfo(string $content): void
    {
        $this->toast($content, 'info');
    }

    public function toast(string $content, string $type = 'info'): void
    {
        $this->dispatch('notify', content: $content, type: $type);
    }
}
