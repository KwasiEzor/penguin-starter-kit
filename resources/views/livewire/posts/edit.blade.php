<div class="flex flex-col gap-6">
    <!-- Header -->
    <div>
        <x-breadcrumbs class="mb-4">
            <x-breadcrumb-item href="{{ route('posts.index') }}">{{ __('Posts') }}</x-breadcrumb-item>
            <x-breadcrumb-item :active="true">{{ __('Edit') }}</x-breadcrumb-item>
        </x-breadcrumbs>

        <x-typography.heading accent size="xl" level="1">{{ __('Edit Post') }}</x-typography.heading>
        <x-typography.subheading size="lg">{{ __('Update your post details') }}</x-typography.subheading>
    </div>

    <x-separator />

    <!-- Form -->
    <form wire:submit="save" class="max-w-2xl space-y-6">
        <div>
            <x-input-label for="title" value="{{ __('Title') }}" />
            <x-input id="title" wire:model="title" class="mt-1" placeholder="{{ __('Post title') }}" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="body" value="{{ __('Content') }}" />
            <x-textarea id="body" wire:model="body" rows="8" class="mt-1" placeholder="{{ __('Write your post content...') }}" />
            <x-input-error :messages="$errors->get('body')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="status" value="{{ __('Status') }}" />
            <x-select id="status" wire:model="status" class="mt-1">
                <option value="draft">{{ __('Draft') }}</option>
                <option value="published">{{ __('Published') }}</option>
            </x-select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <div class="flex items-center gap-3">
            <x-button type="submit">{{ __('Save Changes') }}</x-button>
            <x-button variant="ghost" href="{{ route('posts.index') }}">{{ __('Cancel') }}</x-button>
        </div>
    </form>
</div>
