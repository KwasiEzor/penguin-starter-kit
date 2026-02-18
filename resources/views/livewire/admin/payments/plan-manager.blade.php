<div>
    <div class="flex items-center justify-between mb-4">
        <x-typography.heading accent>{{ __('Subscription Plans') }}</x-typography.heading>
        <x-button size="sm" wire:click="createPlan">{{ __('Add Plan') }}</x-button>
    </div>

    @if ($plans->count())
        <x-table>
            <x-slot name="head">
                <x-table-heading>{{ __('Name') }}</x-table-heading>
                <x-table-heading>{{ __('Price') }}</x-table-heading>
                <x-table-heading>{{ __('Interval') }}</x-table-heading>
                <x-table-heading>{{ __('Stripe Price ID') }}</x-table-heading>
                <x-table-heading>{{ __('Status') }}</x-table-heading>
                <x-table-heading>{{ __('Actions') }}</x-table-heading>
            </x-slot>

            @foreach ($plans as $plan)
                <tr wire:key="plan-{{ $plan->id }}">
                    <x-table-cell class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ $plan->name }}
                        @if ($plan->is_featured)
                            <x-badge variant="warning" size="sm">{{ __('Featured') }}</x-badge>
                        @endif
                    </x-table-cell>
                    <x-table-cell>{{ $plan->formattedPrice() }}</x-table-cell>
                    <x-table-cell>{{ ucfirst($plan->interval) . 'ly' }}</x-table-cell>
                    <x-table-cell class="text-xs">{{ $plan->stripe_price_id ?? '-' }}</x-table-cell>
                    <x-table-cell>
                        <x-badge :variant="$plan->is_active ? 'success' : 'default'" size="sm">
                            {{ $plan->is_active ? __('Active') : __('Inactive') }}
                        </x-badge>
                    </x-table-cell>
                    <x-table-cell>
                        <div class="flex items-center gap-2">
                            <x-button size="xs" variant="ghost" wire:click="editPlan({{ $plan->id }})">{{ __('Edit') }}</x-button>
                            <x-button size="xs" variant="ghost" wire:click="toggleActive({{ $plan->id }})">
                                {{ $plan->is_active ? __('Deactivate') : __('Activate') }}
                            </x-button>
                            <x-button size="xs" variant="ghost" wire:click="confirmDelete({{ $plan->id }})" class="text-danger hover:text-danger">
                                {{ __('Delete') }}
                            </x-button>
                        </div>
                    </x-table-cell>
                </tr>
            @endforeach
        </x-table>
    @else
        <x-empty-state title="{{ __('No plans yet') }}" description="{{ __('Create your first subscription plan.') }}">
            <x-slot name="action">
                <x-button wire:click="createPlan">{{ __('Add Plan') }}</x-button>
            </x-slot>
        </x-empty-state>
    @endif

    <!-- Create/Edit Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-99 flex items-start justify-center bg-surface-dark/20 p-4 pb-8 backdrop-blur-sm sm:items-center lg:p-8" role="dialog" aria-modal="true">
            <div class="flex sm:max-w-2xl w-full flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
                <div class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark-alt/20">
                    <x-typography.heading accent>{{ $editingPlanId ? __('Edit Plan') : __('Create Plan') }}</x-typography.heading>
                    <button wire:click="$set('showModal', false)" class="ml-auto" aria-label="close modal">
                        <x-icons.x-mark />
                    </button>
                </div>
                <form wire:submit="savePlan" class="p-4 flex flex-col gap-4">
                    <div>
                        <x-input-label value="{{ __('Name') }}" for="plan-name" />
                        <x-input id="plan-name" type="text" wire:model="name" class="mt-1" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label value="{{ __('Description') }}" for="plan-description" />
                        <textarea id="plan-description" wire:model="description" rows="2" class="mt-1 w-full rounded-radius border border-outline bg-surface px-2 py-2 text-sm text-on-surface focus:border-outline focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:border-outline-dark dark:text-on-surface-dark dark:bg-surface/10 dark:focus-visible:outline-primary-dark"></textarea>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label value="{{ __('Price (cents)') }}" for="plan-price" />
                            <x-input id="plan-price" type="number" wire:model="price" min="0" class="mt-1" />
                            <x-input-error :messages="$errors->get('price')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label value="{{ __('Billing Interval') }}" for="plan-interval" />
                            <x-select id="plan-interval" wire:model="interval" class="mt-1">
                                <option value="month">{{ __('Monthly') }}</option>
                                <option value="year">{{ __('Yearly') }}</option>
                            </x-select>
                        </div>
                    </div>

                    <div>
                        <x-input-label value="{{ __('Stripe Price ID') }}" for="plan-stripe-id" />
                        <x-input id="plan-stripe-id" type="text" wire:model="stripe_price_id" placeholder="price_..." class="mt-1" />
                    </div>

                    <div>
                        <x-input-label value="{{ __('Features (one per line)') }}" for="plan-features" />
                        <textarea id="plan-features" wire:model="featuresText" rows="3" placeholder="{{ __("Unlimited projects\nPriority support\n10GB storage") }}" class="mt-1 w-full rounded-radius border border-outline bg-surface px-2 py-2 text-sm text-on-surface focus:border-outline focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:border-outline-dark dark:text-on-surface-dark dark:bg-surface/10 dark:focus-visible:outline-primary-dark"></textarea>
                    </div>

                    <div class="flex items-center gap-6">
                        <x-toggle id="plan-active" wire:model="is_active">{{ __('Active') }}</x-toggle>
                        <x-toggle id="plan-featured" wire:model="is_featured">{{ __('Featured') }}</x-toggle>
                    </div>

                    <div class="flex justify-end gap-2">
                        <x-button variant="ghost" type="button" wire:click="$set('showModal', false)">{{ __('Cancel') }}</x-button>
                        <x-button type="submit">{{ $editingPlanId ? __('Update Plan') : __('Create Plan') }}</x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <x-modal :show="$deletingPlanId !== null" maxWidth="md">
        <x-slot name="trigger"><span></span></x-slot>
        <x-slot name="header">
            <x-typography.subheading accent size="lg">{{ __('Delete Plan') }}</x-typography.subheading>
        </x-slot>
        <div class="p-4">
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Are you sure you want to delete this plan? This action cannot be undone.') }}
            </p>
        </div>
        <div class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
            <x-button variant="ghost" type="button" wire:click="cancelDelete">{{ __('Cancel') }}</x-button>
            <x-button variant="danger" type="button" wire:click="deletePlan">{{ __('Delete Plan') }}</x-button>
        </div>
    </x-modal>
</div>
