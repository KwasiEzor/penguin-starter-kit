<div class="flex flex-col gap-8">
    <!-- Header with Breadcrumbs -->
    <div class="flex flex-col gap-2">
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-2">
            <a href="{{ route('posts.index') }}" class="hover:text-primary transition-colors">{{ __('Publications') }}</a>
            <x-icons.chevron-right size="xs" />
            <span class="text-on-surface/60">{{ __('Edit Post') }}</span>
        </div>
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-3xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Refine Publication') }}
            </h1>
            <div class="flex items-center gap-3">
                <x-button variant="ghost" href="{{ route('posts.index') }}">{{ __('Discard') }}</x-button>
                <x-button wire:click="save" class="shadow-lg shadow-primary/20">
                    <x-icons.check variant="outline" size="xs" class="mr-1" />
                    {{ __('Update Changes') }}
                </x-button>
            </div>
        </div>
    </div>

    <!-- Main Editor Area -->
    <div class="grid gap-8 lg:grid-cols-3">
        <!-- Left: Content -->
        <div class="lg:col-span-2 flex flex-col gap-8">
            <x-card padding="false">
                <div class="p-8 space-y-8">
                    <!-- Title -->
                    <div class="space-y-2">
                        <x-input-label for="title" value="{{ __('Publication Title') }}" class="text-[10px] uppercase font-black tracking-widest text-on-surface/40" />
                        <input 
                            id="title" 
                            wire:model.live.debounce.300ms="title" 
                            class="w-full bg-transparent border-none p-0 text-4xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong placeholder:text-on-surface/10 focus:ring-0" 
                            placeholder="{{ __('Enter a catchy title...') }}"
                            autofocus
                        />
                        <x-input-error :messages="$errors->get('title')" />
                    </div>

                    <!-- Content (Trix) -->
                    <div class="space-y-2" wire:ignore>
                        <x-input-label for="body" value="{{ __('Story Content') }}" class="text-[10px] uppercase font-black tracking-widest text-on-surface/40" />
                        <input id="body" type="hidden" name="body" value="{{ $body }}" />
                        <trix-editor 
                            input="body"
                            class="trix-content prose dark:prose-invert max-w-none mt-1 min-h-[500px] rounded-2xl border border-outline bg-surface-alt/30 p-6 text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark/30 dark:text-on-surface-dark-strong focus:bg-surface transition-colors"
                            placeholder="{{ __('Tell your story...') }}"
                            x-on:trix-change="$wire.set('body', $event.target.value)"
                        ></trix-editor>
                    </div>
                    <x-input-error :messages="$errors->get('body')" />
                </div>
            </x-card>

            <!-- SEO Card -->
            <x-card padding="false">
                <x-slot name="header">
                    <div class="flex items-center gap-2">
                        <x-icons.sparkles variant="outline" size="xs" class="text-primary" />
                        <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Search Engine Optimization') }}</span>
                    </div>
                </x-slot>
                
                <div class="p-8 space-y-8">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="flex flex-col gap-2">
                            <x-input-label for="slug" value="{{ __('URL Slug') }}" />
                            <x-input id="slug" wire:model="slug" placeholder="{{ __('post-url-handle') }}" />
                            <x-input-error :messages="$errors->get('slug')" />
                        </div>

                        <div class="flex flex-col gap-2">
                            <x-input-label for="meta_title" value="{{ __('Meta Title') }}" />
                            <x-input id="meta_title" wire:model="meta_title" placeholder="{{ __('SEO Title') }}" maxlength="60" />
                            <div class="flex justify-between items-center px-1">
                                <span class="text-[10px] text-on-surface/40 uppercase font-bold">{{ __('Recommended: 60 chars') }}</span>
                                <span @class(['text-[10px] font-bold', 'text-success' => strlen($meta_title) <= 60, 'text-danger' => strlen($meta_title) > 60])>{{ strlen($meta_title) }}/60</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-input-label for="excerpt" value="{{ __('Excerpt') }}" />
                        <x-textarea id="excerpt" wire:model="excerpt" rows="3" placeholder="{{ __('Brief summary for previews...') }}" />
                        <p class="text-[11px] text-on-surface/50 italic">{{ __('Automatically generated from content if left blank.') }}</p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-input-label for="meta_description" value="{{ __('Meta Description') }}" />
                        <x-textarea id="meta_description" wire:model="meta_description" rows="3" placeholder="{{ __('SEO Description') }}" maxlength="160" />
                        <div class="flex justify-between items-center px-1">
                            <span class="text-[10px] text-on-surface/40 uppercase font-bold">{{ __('Recommended: 160 chars') }}</span>
                            <span @class(['text-[10px] font-bold', 'text-success' => strlen($meta_description) <= 160, 'text-danger' => strlen($meta_description) > 160])>{{ strlen($meta_description) }}/160</span>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Right: Settings & Metadata -->
        <div class="lg:col-span-1 flex flex-col gap-8">
            <!-- Publishing Controls -->
            <x-card>
                <x-slot name="header">
                    <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Publication State') }}</span>
                </x-slot>
                
                <div class="space-y-6">
                    <div>
                        <x-input-label for="status" value="{{ __('Current Status') }}" />
                        <x-select id="status" wire:model="status" class="mt-1">
                            <option value="draft">{{ __('Draft') }}</option>
                            <option value="published">{{ __('Published') }}</option>
                        </x-select>
                    </div>

                    <div class="pt-4 border-t border-outline dark:border-outline-dark">
                        <div class="flex items-center justify-between text-xs text-on-surface/60 mb-4">
                            <span>{{ __('Last Saved') }}:</span>
                            <span class="font-bold">{{ $post->updated_at->diffForHumans() }}</span>
                        </div>
                        <x-button wire:click="save" class="w-full">
                            {{ __('Update Status') }}
                        </x-button>
                    </div>
                </div>
            </x-card>

            <!-- Featured Image -->
            <x-card>
                <x-slot name="header">
                    <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Featured Image') }}</span>
                </x-slot>
                
                <div class="space-y-4">
                    <div class="relative aspect-video rounded-2xl bg-surface-alt dark:bg-surface-dark overflow-hidden border border-outline dark:border-outline-dark group">
                        @if ($featured_image && method_exists($featured_image, 'isPreviewable') && $featured_image->isPreviewable())
                            <img src="{{ $featured_image->temporaryUrl() }}" class="size-full object-cover" />
                            <button wire:click="clearUploadedImage" class="absolute top-2 right-2 size-8 flex items-center justify-center rounded-full bg-black/60 text-white backdrop-blur hover:bg-danger transition-colors">
                                <x-icons.x-mark size="xs" />
                            </button>
                        @elseif ($post->hasMedia('featured_image'))
                            <img src="{{ $post->featuredImageUrl() }}" class="size-full object-cover" />
                            <button wire:click="removeFeaturedImage" class="absolute top-2 right-2 size-8 flex items-center justify-center rounded-full bg-black/60 text-white backdrop-blur hover:bg-danger transition-colors">
                                <x-icons.trash size="xs" />
                            </button>
                        @else
                            <div class="flex size-full items-center justify-center text-on-surface/10">
                                <x-icons.document-text variant="outline" size="xl" />
                            </div>
                        @endif
                    </div>
                    
                    <x-file-upload wire:model="featured_image" :label="$post->hasMedia('featured_image') ? __('Replace featured image') : __('Upload featured image')" />
                    <x-input-error :messages="$errors->get('featured_image')" />
                    
                    <div wire:loading wire:target="featured_image" class="flex items-center gap-2 text-xs font-bold text-primary animate-pulse">
                        <x-icons.arrow-path class="size-3 animate-spin" />
                        {{ __('UPLOADING...') }}
                    </div>
                </div>
            </x-card>

            <!-- Organization -->
            <x-card>
                <x-slot name="header">
                    <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Organization') }}</span>
                </x-slot>
                
                <div class="space-y-6">
                    <!-- Categories -->
                    @if ($categories->isNotEmpty())
                        <div class="space-y-3">
                            <x-input-label value="{{ __('Categories') }}" class="text-[10px] uppercase font-black text-on-surface/40 tracking-widest" />
                            <div class="grid grid-cols-1 gap-2">
                                @foreach ($categories as $category)
                                    <label class="flex items-center gap-3 p-2 rounded-xl hover:bg-surface-alt transition-colors cursor-pointer border border-transparent hover:border-outline dark:hover:bg-surface-dark dark:hover:border-outline-dark">
                                        <input 
                                            type="checkbox" 
                                            value="{{ $category->id }}" 
                                            wire:model="category_ids"
                                            class="size-4 rounded-md border-outline-strong text-primary focus:ring-4 focus:ring-primary/10 dark:border-outline-dark-strong dark:bg-surface-dark" 
                                        />
                                        <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Tags -->
                    <div class="space-y-2 pt-4 border-t border-outline dark:border-outline-dark">
                        <x-input-label for="tags_input" value="{{ __('Tags') }}" class="text-[10px] uppercase font-black text-on-surface/40 tracking-widest" />
                        <x-input id="tags_input" wire:model="tags_input" placeholder="{{ __('Enter tags...') }}" />
                        <p class="text-[10px] text-on-surface/40 font-medium italic">{{ __('Comma separated values') }}</p>
                        <x-input-error :messages="$errors->get('tags_input')" />
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</div>
