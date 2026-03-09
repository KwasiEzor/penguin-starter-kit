<div class="flex flex-col gap-8">
    <!-- Header -->
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
            {{ __('Billing & Payments') }}
        </h1>
        <p class="text-on-surface/60 dark:text-on-surface-dark/60 font-medium">
            {{ __('Configure your Stripe integration, manage plans and view transactions.') }}
        </p>
    </div>

    <x-tabs active="settings">
        <x-slot name="tabs">
            <x-tab name="settings">
                <div class="flex items-center gap-2">
                    <x-icons.cog variant="outline" size="xs" />
                    {{ __('Config') }}
                </div>
            </x-tab>
            <x-tab name="plans">
                <div class="flex items-center gap-2">
                    <x-icons.document-text variant="outline" size="xs" />
                    {{ __('Plans') }}
                </div>
            </x-tab>
            <x-tab name="products">
                <div class="flex items-center gap-2">
                    <x-icons.sparkles variant="outline" size="xs" />
                    {{ __('Products') }}
                </div>
            </x-tab>
            <x-tab name="transactions">
                <div class="flex items-center gap-2">
                    <x-icons.currency-dollar variant="outline" size="xs" />
                    {{ __('History') }}
                </div>
            </x-tab>
        </x-slot>

        <!-- Settings Tab -->
        <x-tab-panel name="settings">
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="lg:col-span-1 flex flex-col gap-6">
                    <div class="p-6 rounded-2xl bg-success/5 border border-success/10">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-success/10 text-success mb-4">
                            <x-icons.shield variant="outline" size="sm" />
                        </div>
                        <h3 class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong mb-2">
                            {{ __('Secure Payments') }}
                        </h3>
                        <p class="text-xs text-on-surface/70 leading-relaxed">
                            {{ __('We use Laravel Cashier and Stripe for robust, secure billing. Your secret keys are encrypted at rest and never exposed in the UI.') }}
                        </p>
                    </div>

                    <div class="flex flex-col gap-4">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-on-surface/40 px-1">{{ __('Master Toggle') }}</h4>
                        <x-card class="!bg-surface">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Accept Payments') }}</span>
                                <x-toggle id="payments-enabled-toggle" wire:model.live="paymentsEnabled" />
                            </div>
                        </x-card>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <x-card padding="false">
                        <x-slot name="header">
                            <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Stripe API Integration') }}</span>
                        </x-slot>

                        <form wire:submit="saveSettings" class="p-8 space-y-8">
                            <div class="grid gap-6 sm:grid-cols-2">
                                <div class="col-span-full">
                                    <x-input-label value="{{ __('Publishable Key') }}" for="stripe-key" />
                                    <x-input id="stripe-key" type="text" wire:model="stripeKey" placeholder="pk_test_..." class="mt-1" />
                                    <x-input-error :messages="$errors->get('stripeKey')" class="mt-1" />
                                </div>

                                <div>
                                    <div class="flex items-center gap-2">
                                        <x-input-label value="{{ __('Secret Key') }}" for="stripe-secret" />
                                        @if($hasStripeSecret)
                                            <x-badge variant="success" size="xs">{{ __('Configured') }}</x-badge>
                                        @endif
                                    </div>
                                    <x-input id="stripe-secret" type="password" wire:model="stripeSecret" placeholder="sk_test_••••••••" class="mt-1" />
                                    <x-input-error :messages="$errors->get('stripeSecret')" class="mt-1" />
                                </div>

                                <div>
                                    <div class="flex items-center gap-2">
                                        <x-input-label value="{{ __('Webhook Secret') }}" for="webhook-secret" />
                                        @if($hasWebhookSecret)
                                            <x-badge variant="success" size="xs">{{ __('Configured') }}</x-badge>
                                        @endif
                                    </div>
                                    <x-input id="webhook-secret" type="password" wire:model="stripeWebhookSecret" placeholder="whsec_••••••••" class="mt-1" />
                                    <x-input-error :messages="$errors->get('stripeWebhookSecret')" class="mt-1" />
                                </div>

                                <div class="col-span-full md:col-span-1">
                                    <x-input-label value="{{ __('Default Currency') }}" for="currency" />
                                    <x-select id="currency" wire:model="currency" class="mt-1">
                                        <option value="usd">United States Dollar (USD)</option>
                                        <option value="eur">Euro (EUR)</option>
                                        <option value="gbp">British Pound (GBP)</option>
                                        <option value="cad">Canadian Dollar (CAD)</option>
                                        <option value="aud">Australian Dollar (AUD)</option>
                                    </x-select>
                                    <x-input-error :messages="$errors->get('currency')" class="mt-1" />
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-6 border-t border-outline dark:border-outline-dark">
                                <span class="text-xs text-on-surface/50 italic">{{ __('Changes take effect immediately.') }}</span>
                                <x-button type="submit" class="shadow-lg shadow-primary/20">
                                    {{ __('Save Configuration') }}
                                </x-button>
                            </div>
                        </form>
                    </x-card>
                </div>
            </div>
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
