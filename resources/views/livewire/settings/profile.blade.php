<section>
    <header>
        <x-typography.heading class="mb-2" accent>
            {{ __('Profile') }}
        </x-typography.heading>
        <x-typography.subheading>
            {{ __('Update your name and email address') }}
        </x-typography.subheading>
    </header>

    <!-- Avatar Upload -->
    <div class="mt-6 mb-6">
        <x-input-label :value="__('Avatar')" class="mb-2" />
        <div class="flex items-center gap-4">
            @php $avatarUrl = auth()->user()->avatarUrl(); @endphp
            <x-avatar :src="$avatarUrl" :initials="auth()->user()->initials()" size="xl" />
            <div class="flex flex-col gap-2">
                <label class="inline-flex cursor-pointer items-center gap-2 rounded-radius border border-outline px-3 py-1.5 text-sm font-medium text-on-surface-strong transition-colors hover:bg-surface-alt dark:border-outline-dark dark:text-on-surface-dark-strong dark:hover:bg-surface-dark-alt">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                    </svg>
                    {{ __('Upload Photo') }}
                    <input type="file" wire:model="avatar" accept="image/*" class="sr-only" />
                </label>
                @if ($avatarUrl)
                    <button type="button" wire:click="removeAvatar" class="text-sm text-danger hover:text-danger/80">
                        {{ __('Remove') }}
                    </button>
                @endif
            </div>
        </div>
        <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        <div wire:loading wire:target="avatar" class="mt-2 text-sm text-on-surface dark:text-on-surface-dark">
            {{ __('Uploading...') }}
        </div>
    </div>

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
