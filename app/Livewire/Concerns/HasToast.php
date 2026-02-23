<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

/**
 * Trait for dispatching toast notifications from Livewire components.
 *
 * Provides convenience methods for dispatching success, warning, error,
 * and info toast notifications via Livewire's event dispatching system.
 */
trait HasToast
{
    /**
     * Dispatch a success toast notification.
     *
     * @param  string  $content  The message to display in the toast.
     * @return void
     */
    public function toastSuccess(string $content): void
    {
        $this->toast($content, 'success');
    }

    /**
     * Dispatch a warning toast notification.
     *
     * @param  string  $content  The message to display in the toast.
     * @return void
     */
    public function toastWarning(string $content): void
    {
        $this->toast($content, 'warning');
    }

    /**
     * Dispatch an error toast notification.
     *
     * @param  string  $content  The message to display in the toast.
     * @return void
     */
    public function toastError(string $content): void
    {
        $this->toast($content, 'error');
    }

    /**
     * Dispatch an info toast notification.
     *
     * @param  string  $content  The message to display in the toast.
     * @return void
     */
    public function toastInfo(string $content): void
    {
        $this->toast($content, 'info');
    }

    /**
     * Dispatch a toast notification of the given type.
     *
     * @param  string  $content  The message to display in the toast.
     * @param  string  $type     The notification type (default: 'info').
     * @return void
     */
    public function toast(string $content, string $type = 'info'): void
    {
        $this->dispatch('notify', content: $content, type: $type);
    }
}
