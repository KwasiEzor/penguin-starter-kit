<div class="flex flex-col gap-6">
    <!-- Header -->
    <div>
        <x-breadcrumbs class="mb-4">
            <x-breadcrumb-item href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</x-breadcrumb-item>
            <x-breadcrumb-item :active="true">{{ __('Payments') }}</x-breadcrumb-item>
        </x-breadcrumbs>

        <x-typography.heading accent size="xl" level="1">{{ __('Payments') }}</x-typography.heading>
        <x-typography.subheading size="lg">{{ __('Manage payment settings, plans, products, and transactions') }}</x-typography.subheading>
    </div>

    <x-separator />

    <x-tabs active="settings">
        <x-slot name="tabs">
            <x-tab name="settings">{{ __('Settings') }}</x-tab>
            <x-tab name="plans">{{ __('Plans') }}</x-tab>
            <x-tab name="products">{{ __('Products') }}</x-tab>
            <x-tab name="transactions">{{ __('Transactions') }}</x-tab>
        </x-slot>

        <!-- Settings Tab -->
        <x-tab-panel name="settings">
            <x-card>
                <x-slot name="header">
                    <x-typography.heading accent>{{ __('Payment Configuration') }}</x-typography.heading>
                </x-slot>

                <form wire:submit="saveSettings" class="flex flex-col gap-4">
                    <!-- Enable/Disable Payments -->
                    <div>
                        <x-toggle id="payments-enabled" wire:model="paymentsEnabled">
                            {{ __('Enable Payments') }}
                        </x-toggle>
                        <p class="mt-1 text-xs text-on-surface dark:text-on-surface-dark">{{ __('When enabled, users can subscribe to plans and purchase products.') }}</p>
                    </div>

                    <x-separator />

                    <!-- Stripe Keys -->
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label value="{{ __('Stripe Publishable Key') }}" for="stripe-key" />
                            <x-input id="stripe-key" type="text" wire:model="stripeKey" placeholder="pk_test_..." class="mt-1" />
                            <x-input-error :messages="$errors->get('stripeKey')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label value="{{ __('Stripe Secret Key') }}" for="stripe-secret" />
                            <x-input id="stripe-secret" type="text" wire:model="stripeSecret" placeholder="sk_test_..." class="mt-1" />
                            <x-input-error :messages="$errors->get('stripeSecret')" class="mt-1" />
                            <p class="mt-1 text-xs text-on-surface dark:text-on-surface-dark">{{ __('Leave blank to keep current value. Stored encrypted.') }}</p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label value="{{ __('Webhook Secret') }}" for="webhook-secret" />
                            <x-input id="webhook-secret" type="text" wire:model="stripeWebhookSecret" placeholder="whsec_..." class="mt-1" />
                            <x-input-error :messages="$errors->get('stripeWebhookSecret')" class="mt-1" />
                            <p class="mt-1 text-xs text-on-surface dark:text-on-surface-dark">{{ __('Leave blank to keep current value. Stored encrypted.') }}</p>
                        </div>

                        <div>
                            <x-input-label value="{{ __('Currency') }}" for="currency" />
                            <x-select id="currency" wire:model="currency" class="mt-1">
                                <option value="usd">USD ($)</option>
                                <option value="eur">EUR</option>
                                <option value="gbp">GBP</option>
                                <option value="cad">CAD</option>
                                <option value="aud">AUD</option>
                            </x-select>
                            <x-input-error :messages="$errors->get('currency')" class="mt-1" />
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <x-button type="submit">{{ __('Save Settings') }}</x-button>
                    </div>
                </form>
            </x-card>
        </x-tab-panel>

        <!-- Plans Tab -->
        <x-tab-panel name="plans">
            @livewire('admin.payments.plan-manager')
        </x-tab-panel>

        <!-- Products Tab -->
        <x-tab-panel name="products">
            @livewire('admin.payments.product-manager')
        </x-tab-panel>

        <!-- Transactions Tab -->
        <x-tab-panel name="transactions">
            @livewire('admin.payments.transaction-list')
        </x-tab-panel>
    </x-tabs>
</div>
