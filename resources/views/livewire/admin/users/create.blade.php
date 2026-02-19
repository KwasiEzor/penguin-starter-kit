<div class="flex flex-col gap-6">
    <!-- Header -->
    <div>
        <x-breadcrumbs class="mb-4">
            <x-breadcrumb-item href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</x-breadcrumb-item>
            <x-breadcrumb-item href="{{ route('admin.users.index') }}">{{ __('Users') }}</x-breadcrumb-item>
            <x-breadcrumb-item :active="true">{{ __('Create') }}</x-breadcrumb-item>
        </x-breadcrumbs>

        <x-typography.heading accent size="xl" level="1">{{ __('Create User') }}</x-typography.heading>
        <x-typography.subheading size="lg">{{ __('Add a new user account') }}</x-typography.subheading>
    </div>

    <x-separator />

    <!-- Form -->
    <form wire:submit="save" class="max-w-2xl space-y-6">
        <div>
            <x-input-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" wire:model="name" class="mt-1" placeholder="{{ __('Full name') }}" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" wire:model="email" class="mt-1" placeholder="{{ __('Email address') }}" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="{{ __('Password') }}" />
            <x-input id="password" type="password" wire:model="password" class="mt-1" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-input id="password_confirmation" type="password" wire:model="password_confirmation" class="mt-1" />
        </div>

        <div>
            <x-input-label for="role" value="{{ __('Role') }}" />
            <x-select id="role" wire:model="role" class="mt-1">
                @foreach ($roles as $role)
                    <option value="{{ $role->value }}">{{ $role->label() }}</option>
                @endforeach
            </x-select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="avatar" value="{{ __('Avatar') }}" />
            <div class="mt-1">
                @if ($avatar && method_exists($avatar, 'isPreviewable') && $avatar->isPreviewable())
                    <x-file-upload :preview="$avatar->temporaryUrl()" />
                @elseif (! $avatar)
                    <x-file-upload wire="avatar" :label="__('Upload avatar')" />
                @endif
            </div>
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
            <div wire:loading wire:target="avatar" class="mt-2 text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Uploading...') }}
            </div>
        </div>

        <div class="flex items-center gap-3">
            <x-button type="submit">{{ __('Create User') }}</x-button>
            <x-button variant="ghost" href="{{ route('admin.users.index') }}">{{ __('Cancel') }}</x-button>
        </div>
    </form>
</div>
