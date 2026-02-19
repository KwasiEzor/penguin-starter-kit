<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Payments;

use App\Livewire\Concerns\HasToast;
use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class Settings extends Component
{
    use HasToast;

    public bool $paymentsEnabled = false;

    public string $stripeKey = '';

    public string $stripeSecret = '';

    public string $stripeWebhookSecret = '';

    public string $currency = 'usd';

    public function mount(): void
    {
        $this->paymentsEnabled = Setting::paymentsEnabled();
        $this->stripeKey = (string) Setting::get('payments.stripe_key', '');
        $this->currency = (string) Setting::get('payments.currency', 'usd');
    }

    public function saveSettings(): void
    {
        $this->validate([
            'stripeKey' => ['nullable', 'string'],
            'stripeSecret' => ['nullable', 'string'],
            'stripeWebhookSecret' => ['nullable', 'string'],
            'currency' => ['required', 'string', 'in:usd,eur,gbp,cad,aud'],
        ]);

        if ($this->stripeKey && ! str_starts_with($this->stripeKey, 'pk_')) {
            $this->addError('stripeKey', 'Stripe publishable key must start with "pk_".');

            return;
        }

        if ($this->stripeSecret && ! str_starts_with($this->stripeSecret, 'sk_')) {
            $this->addError('stripeSecret', 'Stripe secret key must start with "sk_".');

            return;
        }

        if ($this->stripeWebhookSecret && ! str_starts_with($this->stripeWebhookSecret, 'whsec_')) {
            $this->addError('stripeWebhookSecret', 'Webhook secret must start with "whsec_".');

            return;
        }

        Setting::set('payments.enabled', $this->paymentsEnabled ? '1' : '0', 'payments');
        Setting::set('payments.stripe_key', $this->stripeKey, 'payments');
        Setting::set('payments.currency', $this->currency, 'payments');

        if ($this->stripeSecret !== '' && $this->stripeSecret !== '0') {
            Setting::set('payments.stripe_secret', Crypt::encryptString($this->stripeSecret), 'payments');
        }

        if ($this->stripeWebhookSecret !== '' && $this->stripeWebhookSecret !== '0') {
            Setting::set('payments.stripe_webhook_secret', Crypt::encryptString($this->stripeWebhookSecret), 'payments');
        }

        $this->stripeSecret = '';
        $this->stripeWebhookSecret = '';

        $this->toastSuccess('Payment settings saved successfully.');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.admin.payments.settings');
    }
}
