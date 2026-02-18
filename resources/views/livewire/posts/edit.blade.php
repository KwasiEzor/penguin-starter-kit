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
            <x-input id="title" wire:model.live.debounce.300ms="title" class="mt-1" placeholder="{{ __('Post title') }}" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="body" value="{{ __('Content') }}" />
            <x-textarea id="body" wire:model="body" rows="8" class="mt-1" placeholder="{{ __('Write your post content...') }}" />
            <x-input-error :messages="$errors->get('body')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="featured_image" value="{{ __('Featured Image') }}" />
            <div class="mt-1">
                @if ($featured_image && method_exists($featured_image, 'isPreviewable') && $featured_image->isPreviewable())
                    <x-file-upload :preview="$featured_image->temporaryUrl()" />
                @elseif (!$featured_image && $post->featuredImageUrl())
                    <x-file-upload :preview="$post->featuredImageUrl()" :removable="true" removeAction="removeFeaturedImage" />
                @else
                    <x-file-upload wire="featured_image" :label="__('Upload featured image')" />
                @endif
            </div>
            <x-input-error :messages="$errors->get('featured_image')" class="mt-2" />
            <div wire:loading wire:target="featured_image" class="mt-2 text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Uploading...') }}
            </div>
        </div>

        <div>
            <x-input-label for="status" value="{{ __('Status') }}" />
            <x-select id="status" wire:model="status" class="mt-1">
                <option value="draft">{{ __('Draft') }}</option>
                <option value="published">{{ __('Published') }}</option>
            </x-select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="tags_input" value="{{ __('Tags') }}" />
            <x-input id="tags_input" wire:model="tags_input" class="mt-1" placeholder="{{ __('Laravel, PHP, Tutorial') }}" />
            <p class="mt-1 text-xs text-on-surface dark:text-on-surface-dark">{{ __('Separate tags with commas') }}</p>
            <x-input-error :messages="$errors->get('tags_input')" class="mt-2" />
        </div>

        <!-- SEO Settings -->
        <details class="rounded-lg border border-outline p-4 dark:border-outline-dark">
            <summary class="cursor-pointer text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('SEO Settings') }}</summary>
            <div class="mt-4 space-y-4">
                <div>
                    <x-input-label for="slug" value="{{ __('Slug') }}" />
                    <x-input id="slug" wire:model="slug" class="mt-1" placeholder="{{ __('post-url-slug') }}" />
                    <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="excerpt" value="{{ __('Excerpt') }}" />
                    <x-textarea id="excerpt" wire:model="excerpt" rows="2" class="mt-1" placeholder="{{ __('Brief summary of the post...') }}" />
                    <p class="mt-1 text-xs text-on-surface dark:text-on-surface-dark">{{ __('Leave empty to auto-generate from content') }}</p>
                    <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="meta_title" value="{{ __('Meta Title') }}" />
                    <x-input id="meta_title" wire:model="meta_title" class="mt-1" placeholder="{{ __('SEO title (max 60 characters)') }}" maxlength="60" />
                    <p class="mt-1 text-xs text-on-surface dark:text-on-surface-dark">{{ strlen($meta_title) }}/60 {{ __('characters') }}</p>
                    <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="meta_description" value="{{ __('Meta Description') }}" />
                    <x-textarea id="meta_description" wire:model="meta_description" rows="2" class="mt-1" placeholder="{{ __('SEO description (max 160 characters)') }}" maxlength="160" />
                    <p class="mt-1 text-xs text-on-surface dark:text-on-surface-dark">{{ strlen($meta_description) }}/160 {{ __('characters') }}</p>
                    <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                </div>
            </div>
        </details>

        <div class="flex items-center gap-3">
            <x-button type="submit">{{ __('Save Changes') }}</x-button>
            <x-button variant="ghost" href="{{ route('posts.index') }}">{{ __('Cancel') }}</x-button>
        </div>
    </form>
</div>
