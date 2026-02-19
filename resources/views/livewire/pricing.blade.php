<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="text-center">
        <x-typography.heading accent size="xl" level="1">{{ __('Pricing') }}</x-typography.heading>
        <x-typography.subheading size="lg">
            {{ __('Choose the plan that works best for you') }}
        </x-typography.subheading>
    </div>

    <!-- Subscription Plans -->
    @if ($plans->count())
        <div>
            <x-typography.heading accent level="2" class="mb-4">
                {{ __('Subscription Plans') }}
            </x-typography.heading>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($plans as $plan)
                    <x-card class="{{ $plan->is_featured ? 'ring-2 ring-primary dark:ring-primary-dark' : '' }}">
                        @if ($plan->is_featured)
                            <div class="mb-2">
                                <x-badge variant="primary" size="sm">{{ __('Most Popular') }}</x-badge>
                            </div>
                        @endif

                        <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                            {{ $plan->name }}
                        </h3>

                        @if ($plan->description)
                            <p class="mt-1 text-sm text-on-surface dark:text-on-surface-dark">
                                {{ $plan->description }}
                            </p>
                        @endif

                        <div class="mt-4">
                            <span class="text-3xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                                {{ $plan->formattedPrice() }}
                            </span>
                            <span class="text-sm text-on-surface dark:text-on-surface-dark">
                                /{{ $plan->interval }}
                            </span>
                        </div>

                        @if ($plan->features && count($plan->features))
                            <ul class="mt-4 space-y-2">
                                @foreach ($plan->features as $feature)
                                    <li
                                        class="flex items-center gap-2 text-sm text-on-surface dark:text-on-surface-dark"
                                    >
                                        <svg
                                            class="size-4 shrink-0 text-success"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m4.5 12.75 6 6 9-13.5"
                                            />
                                        </svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="mt-6">
                            @auth
                                @if (auth()->user()->subscribed('default'))
                                    <x-button variant="outline" class="w-full" href="{{ route('billing') }}">
                                        {{ __('Manage Subscription') }}
                                    </x-button>
                                @else
                                    <x-button class="w-full" wire:click="subscribe({{ $plan->id }})">
                                        {{ __('Subscribe') }}
                                    </x-button>
                                @endif
                            @else
                                <x-button class="w-full" href="{{ route('login') }}">
                                    {{ __('Sign in to Subscribe') }}
                                </x-button>
                            @endauth
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>
    @endif

    <!-- One-Time Products -->
    @if ($products->count())
        <x-separator />

        <div>
            <x-typography.heading accent level="2" class="mb-4">
                {{ __('One-Time Purchases') }}
            </x-typography.heading>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($products as $product)
                    <x-card>
                        <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                            {{ $product->name }}
                        </h3>

                        @if ($product->description)
                            <p class="mt-1 text-sm text-on-surface dark:text-on-surface-dark">
                                {{ $product->description }}
                            </p>
                        @endif

                        <div class="mt-4">
                            <span class="text-3xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                                {{ $product->formattedPrice() }}
                            </span>
                            <span class="text-sm text-on-surface dark:text-on-surface-dark">{{ __('one-time') }}</span>
                        </div>

                        <div class="mt-6">
                            @auth
                                <x-button class="w-full" wire:click="purchase({{ $product->id }})">
                                    {{ __('Buy Now') }}
                                </x-button>
                            @else
                                <x-button class="w-full" href="{{ route('login') }}">
                                    {{ __('Sign in to Purchase') }}
                                </x-button>
                            @endauth
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>
    @endif

    @if (! $plans->count() && ! $products->count())
        <x-empty-state
            title="{{ __('No plans or products available') }}"
            description="{{ __('Check back later for pricing options.') }}"
        />
    @endif
</div>
