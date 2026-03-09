<div class="flex flex-col gap-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="flex flex-col gap-2">
        <x-typography.heading accent size="xl" level="1" class="font-extrabold tracking-tight">
            {{ __('Website Settings') }}
        </x-typography.heading>
        <x-typography.subheading size="lg" class="text-on-surface/70 dark:text-on-surface-dark/70">
            {{ __('Configure your website branding, SEO, and global integrations.') }}
        </x-typography.subheading>
    </div>

    <form wire:submit="save" class="space-y-8">
        <x-tabs active="general">
            <x-slot:tabs>
                <x-tab name="general">{{ __('General') }}</x-tab>
                <x-tab name="branding">{{ __('Branding') }}</x-tab>
                <x-tab name="seo">{{ __('SEO & Metadata') }}</x-tab>
                <x-tab name="integrations">{{ __('Integrations') }}</x-tab>
                <x-tab name="advanced">{{ __('Advanced') }}</x-tab>
            </x-slot:tabs>

            <!-- General Settings -->
            <x-tab-panel name="general" class="space-y-6">
                <x-card class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="name" :value="__('Website Name')" />
                                <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tagline" :value="__('Website Tagline')" />
                                <x-input id="tagline" type="text" class="mt-1 block w-full" wire:model="tagline" />
                                <x-input-error :messages="$errors->get('tagline')" class="mt-2" />
                                <p class="mt-1 text-xs text-on-surface/60">{{ __('A short catchphrase or description of your site.') }}</p>
                            </div>

                            <div>
                                <x-input-label for="contactEmail" :value="__('Contact Email')" />
                                <x-input id="contactEmail" type="email" class="mt-1 block w-full" wire:model="contactEmail" />
                                <x-input-error :messages="$errors->get('contactEmail')" class="mt-2" />
                            </div>
                        </div>

                        <div class="bg-surface-alt dark:bg-surface-dark-alt rounded-radius p-6 flex flex-col justify-center">
                            <h4 class="text-sm font-bold uppercase tracking-widest text-on-surface/40 mb-4">{{ __('Preview') }}</h4>
                            <div class="flex flex-col items-center text-center gap-2">
                                <span class="text-2xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ $name ?: __('Your Site Name') }}</span>
                                <span class="text-sm text-on-surface/70 dark:text-on-surface-dark/70 italic">{{ $tagline ?: __('Your catchy tagline goes here.') }}</span>
                            </div>
                        </div>
                    </div>
                </x-card>
            </x-tab-panel>

            <!-- Branding Settings -->
            <x-tab-panel name="branding" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Logo Light -->
                    <x-card class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <x-typography.heading size="base" level="3">{{ __('Logo (Light Mode)') }}</x-typography.heading>
                            @if($currentLogoLight)
                                <x-button variant="ghost" size="xs" type="button" class="text-danger hover:text-danger/80" wire:click="deleteImage('logo_light')" wire:confirm="{{ __('Are you sure you want to remove the light logo?') }}">
                                    <x-icons.trash variant="outline" size="xs" class="mr-1" />
                                    {{ __('Remove') }}
                                </x-button>
                            @endif
                        </div>
                        <p class="text-xs text-on-surface/60">{{ __('Used on light backgrounds. Transparent PNG or SVG recommended.') }}</p>

                        <x-file-upload
                            wire="logoLight"
                            :preview="$logoLight ? $logoLight->temporaryUrl() : ($currentLogoLight ? asset('storage/' . $currentLogoLight) : null)"
                            :label="__('Upload Light Logo')"
                        />
                        <x-input-error :messages="$errors->get('logoLight')" class="mt-2" />
                    </x-card>

                    <!-- Logo Dark -->
                    <x-card class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <x-typography.heading size="base" level="3">{{ __('Logo (Dark Mode)') }}</x-typography.heading>
                            @if($currentLogoDark)
                                <x-button variant="ghost" size="xs" type="button" class="text-danger hover:text-danger/80" wire:click="deleteImage('logo_dark')" wire:confirm="{{ __('Are you sure you want to remove the dark logo?') }}">
                                    <x-icons.trash variant="outline" size="xs" class="mr-1" />
                                    {{ __('Remove') }}
                                </x-button>
                            @endif
                        </div>
                        <p class="text-xs text-on-surface/60">{{ __('Used on dark backgrounds. Transparent PNG or SVG recommended.') }}</p>

                        <x-file-upload
                            wire="logoDark"
                            :preview="$logoDark ? $logoDark->temporaryUrl() : ($currentLogoDark ? asset('storage/' . $currentLogoDark) : null)"
                            :label="__('Upload Dark Logo')"
                        />
                        <x-input-error :messages="$errors->get('logoDark')" class="mt-2" />
                    </x-card>

                    <!-- Favicon -->
                    <x-card class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <x-typography.heading size="base" level="3">{{ __('Favicon') }}</x-typography.heading>
                                @if($currentFavicon)
                                    <x-button variant="ghost" size="xs" type="button" class="text-danger hover:text-danger/80" wire:click="deleteImage('favicon')" wire:confirm="{{ __('Are you sure you want to remove the favicon?') }}">
                                        <x-icons.trash variant="outline" size="xs" />
                                    </x-button>
                                @endif
                            </div>
                            <div class="flex items-center gap-1.5 px-2 py-1 bg-surface-alt dark:bg-surface-dark-alt rounded-md border border-outline dark:border-outline-dark">
                                <div class="size-4 bg-white rounded-sm overflow-hidden flex items-center justify-center">
                                    @if($favicon)
                                        <img src="{{ $favicon->temporaryUrl() }}" class="size-3">
                                    @elseif($currentFavicon)
                                        <img src="{{ asset('storage/' . $currentFavicon) }}" class="size-3">
                                    @else
                                        <div class="size-2 bg-primary rounded-full"></div>
                                    @endif
                                </div>
                                <span class="text-[10px] font-medium text-on-surface/60">browser-tab.com</span>
                            </div>
                        </div>
                        <p class="text-xs text-on-surface/60">{{ __('The small icon shown in browser tabs (32x32px or 16x16px).') }}</p>

                        <x-file-upload
                            wire="favicon"
                            :preview="$favicon ? $favicon->temporaryUrl() : ($currentFavicon ? asset('storage/' . $currentFavicon) : null)"
                            :label="__('Upload Favicon')"
                            hint="{{ __('ICO or PNG, 32x32px') }}"
                        />
                        <x-input-error :messages="$errors->get('favicon')" class="mt-2" />
                    </x-card>
                </div>
            </x-tab-panel>

            <!-- SEO Settings -->
            <x-tab-panel name="seo" class="space-y-6">
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                    <!-- SEO Form -->
                    <div class="xl:col-span-2 space-y-6">
                        <x-card class="p-6 space-y-4">
                            <div>
                                <x-input-label for="seoTitle" :value="__('Global Meta Title')" />
                                <x-input id="seoTitle" type="text" class="mt-1 block w-full" wire:model.live="seoTitle" />
                                <p class="mt-1 text-xs text-on-surface/60">{{ __('Recommended: 50-60 characters.') }} <span class="font-bold" :class="$wire.seoTitle.length > 60 ? 'text-danger' : 'text-success'">{{ strlen($seoTitle) }}</span></p>
                                <x-input-error :messages="$errors->get('seoTitle')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="seoDescription" :value="__('Global Meta Description')" />
                                <x-textarea id="seoDescription" class="mt-1 block w-full" rows="3" wire:model.live="seoDescription"></x-textarea>
                                <p class="mt-1 text-xs text-on-surface/60">{{ __('Recommended: 120-160 characters.') }} <span class="font-bold" :class="$wire.seoDescription.length > 160 ? 'text-danger' : 'text-success'">{{ strlen($seoDescription) }}</span></p>
                                <x-input-error :messages="$errors->get('seoDescription')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="seoKeywords" :value="__('Meta Keywords')" />
                                <x-input id="seoKeywords" type="text" class="mt-1 block w-full" wire:model="seoKeywords" placeholder="keyword1, keyword2, keyword3" />
                                <x-input-error :messages="$errors->get('seoKeywords')" class="mt-2" />
                            </div>
                        </x-card>

                        <x-card class="p-6 space-y-4">
                            <div class="flex justify-between items-center">
                                <x-typography.heading size="base" level="3">{{ __('Social Share Image (OpenGraph)') }}</x-typography.heading>
                                @if($currentSeoSocialImage)
                                    <x-button variant="ghost" size="xs" type="button" class="text-danger hover:text-danger/80" wire:click="deleteImage('seo_social_image')" wire:confirm="{{ __('Are you sure you want to remove the social sharing image?') }}">
                                        <x-icons.trash variant="outline" size="xs" class="mr-1" />
                                        {{ __('Remove') }}
                                    </x-button>
                                @endif
                            </div>
                            <p class="text-xs text-on-surface/60">{{ __('The image shown when your website is shared on social media. Recommended size: 1200x630px.') }}</p>

                            <x-file-upload
                                wire="seoSocialImage"
                                :preview="$seoSocialImage ? $seoSocialImage->temporaryUrl() : ($currentSeoSocialImage ? asset('storage/' . $currentSeoSocialImage) : null)"
                                :label="__('Upload Social Image')"
                                hint="{{ __('PNG or JPG, 1200x630px') }}"
                            />
                            <x-input-error :messages="$errors->get('seoSocialImage')" class="mt-2" />
                        </x-card>
                    </div>

                    <!-- Previews -->
                    <div class="space-y-6">
                        <!-- Google Preview -->
                        <div class="space-y-2">
                            <h4 class="text-xs font-bold uppercase tracking-widest text-on-surface/40 px-1">{{ __('Search Engine Preview') }}</h4>
                            <div class="bg-white p-4 rounded-radius border border-outline shadow-sm font-sans">
                                <div class="text-[14px] text-[#202124] flex items-center gap-2 mb-1">
                                    <div class="size-4 bg-[#f1f3f4] rounded-full flex items-center justify-center overflow-hidden">
                                        @if($favicon)
                                            <img src="{{ $favicon->temporaryUrl() }}" class="size-3">
                                        @elseif($currentFavicon)
                                            <img src="{{ asset('storage/' . $currentFavicon) }}" class="size-3">
                                        @else
                                            <div class="size-2 bg-primary rounded-full"></div>
                                        @endif
                                    </div>
                                    <span class="truncate">{{ config('app.url') }}</span>
                                </div>
                                <div class="text-[20px] text-[#1a0dab] hover:underline cursor-pointer leading-tight mb-1 truncate">
                                    {{ $seoTitle ?: ($name ?: __('Your Site Title')) }}
                                </div>
                                <div class="text-[14px] text-[#4d5156] leading-snug line-clamp-2">
                                    {{ $seoDescription ?: __('This is a preview of how your website description will appear in search results. Make it catchy and informative!') }}
                                </div>
                            </div>
                        </div>

                        <!-- Social Preview -->
                        <div class="space-y-2">
                            <h4 class="text-xs font-bold uppercase tracking-widest text-on-surface/40 px-1">{{ __('Social Media Preview') }}</h4>
                            <div class="bg-white rounded-xl border border-outline overflow-hidden shadow-sm font-sans max-w-sm">
                                <div class="aspect-[1.91/1] bg-surface-alt flex items-center justify-center overflow-hidden">
                                    @if($seoSocialImage)
                                        <img src="{{ $seoSocialImage->temporaryUrl() }}" class="w-full h-full object-cover">
                                    @elseif($currentSeoSocialImage)
                                        <img src="{{ asset('storage/' . $currentSeoSocialImage) }}" class="w-full h-full object-cover">
                                    @else
                                        <x-icons.sparkles class="size-12 text-on-surface/20" />
                                    @endif
                                </div>
                                <div class="p-3 bg-[#f2f4f7] border-t border-outline">
                                    <div class="text-[12px] text-[#65676b] uppercase">{{ parse_url(config('app.url'), PHP_URL_HOST) }}</div>
                                    <div class="text-[16px] font-bold text-[#1c1e21] leading-tight mt-1 truncate">
                                        {{ $seoTitle ?: ($name ?: __('Your Site Title')) }}
                                    </div>
                                    <div class="text-[14px] text-[#65676b] leading-snug line-clamp-1 mt-1">
                                        {{ $seoDescription ?: __('Discover more about our amazing platform.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-tab-panel>

            <!-- Integrations Settings -->
            <x-tab-panel name="integrations" class="space-y-6">
                <x-card class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="googleAnalyticsId" :value="__('Google Analytics ID (G-XXXXXXX)')" />
                            <x-input id="googleAnalyticsId" type="text" class="mt-1 block w-full" wire:model="googleAnalyticsId" placeholder="G-XXXXXXXXXX" />
                            <x-input-error :messages="$errors->get('googleAnalyticsId')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="gtmId" :value="__('Google Tag Manager ID (GTM-XXXXXXX)')" />
                            <x-input id="gtmId" type="text" class="mt-1 block w-full" wire:model="gtmId" placeholder="GTM-XXXXXXX" />
                            <x-input-error :messages="$errors->get('gtmId')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="metaPixelId" :value="__('Meta (Facebook) Pixel ID')" />
                            <x-input id="metaPixelId" type="text" class="mt-1 block w-full" wire:model="metaPixelId" placeholder="1234567890" />
                            <x-input-error :messages="$errors->get('metaPixelId')" class="mt-2" />
                        </div>
                    </div>
                    <div class="p-4 bg-info/5 rounded-radius border border-info/20 flex gap-3">
                        <div class="size-5 rounded-full bg-info flex items-center justify-center text-white font-bold text-[10px] shrink-0">i</div>
                        <p class="text-xs text-info/80 leading-relaxed">
                            {{ __('These IDs will be used to automatically inject the necessary tracking scripts into your website. Make sure to only use the IDs, not the full script snippets.') }}
                        </p>
                    </div>
                </x-card>
            </x-tab-panel>

            <!-- Advanced Settings -->
            <x-tab-panel name="advanced" class="space-y-6">
                @can(\App\Enums\PermissionEnum::SettingsManage->value)
                    <x-card class="p-6 space-y-6">
                        <div>
                            <x-input-label for="customScriptsHeader" :value="__('Custom Header Scripts')" />
                            <x-textarea id="customScriptsHeader" class="mt-1 block w-full font-mono text-sm" rows="6" wire:model="customScriptsHeader" placeholder="<script>...</script>"></x-textarea>
                            <p class="mt-1 text-xs text-on-surface/60">{{ __('These scripts will be injected before the closing </head> tag.') }}</p>
                        </div>

                        <div>
                            <x-input-label for="customScriptsFooter" :value="__('Custom Footer Scripts')" />
                            <x-textarea id="customScriptsFooter" class="mt-1 block w-full font-mono text-sm" rows="6" wire:model="customScriptsFooter" placeholder="<script>...</script>"></x-textarea>
                            <p class="mt-1 text-xs text-on-surface/60">{{ __('These scripts will be injected before the closing </body> tag.') }}</p>
                        </div>

                        <div class="p-4 bg-danger/5 rounded-radius border border-danger/20 flex gap-3">
                            <x-icons.shield class="size-5 text-danger shrink-0" />
                            <p class="text-xs text-danger/80 leading-relaxed">
                                {{ __('Be careful when adding custom scripts. Incorrect or malicious code can break your website or compromise user security.') }}
                            </p>
                        </div>
                    </x-card>
                @else
                    <x-card class="p-12 flex flex-col items-center justify-center text-center space-y-4">
                        <div class="size-16 rounded-full bg-danger/10 flex items-center justify-center text-danger">
                            <x-icons.shield variant="outline" size="lg" />
                        </div>
                        <x-typography.heading size="lg" level="3">{{ __('Access Denied') }}</x-typography.heading>
                        <p class="text-on-surface/60 max-w-md">
                            {{ __('You do not have the required permissions to modify custom scripts. Please contact a super administrator for assistance.') }}
                        </p>
                    </x-card>
                @endcan
            </x-tab-panel>
        </x-tabs>

        <div class="flex justify-end gap-3 pt-6 border-t border-outline dark:border-outline-dark">
            <x-button type="button" variant="outline" wire:click="$refresh">
                {{ __('Reset Changes') }}
            </x-button>
            <x-button type="submit" variant="primary" wire:loading.attr="disabled">
                <span wire:loading.remove>{{ __('Save Settings') }}</span>
                <span wire:loading>{{ __('Saving...') }}</span>
            </x-button>
        </div>
    </form>
</div>
