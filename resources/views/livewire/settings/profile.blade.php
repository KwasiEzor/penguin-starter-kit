<section>
    <header>
        <x-typography.heading class="mb-2" accent>
            {{ __('Profile') }}
        </x-typography.heading>
        <x-typography.subheading>
            {{ __('Update your name and email address') }}
        </x-typography.subheading>
    </header>

    <form wire:submit="updateProfile" class="mt-6 space-y-6">
        <!-- Name Field -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-input id="name" type="text" class="mt-1 block w-full"
                wire:model="name" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email Field -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-input id="email" type="email" class="mt-1 block w-full"
                wire:model="email" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-on-surface dark:text-on-surface-dark">
                        {{ __('Your email address is unverified.') }}
                        <button type="button" wire:click="$dispatch('send-verification')"
                            class="font-medium text-primary underline-offset-2 hover:underline focus:underline focus:outline-hidden dark:text-primary-dark">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                </div>
            @endif
        </div>

        <!-- Form Actions -->
        <div class="flex items-center gap-4">
            <x-button variant="primary">
                {{ __('Save') }}
            </x-button>
        </div>
    </form>
</section>
