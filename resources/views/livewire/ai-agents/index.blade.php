<div class="flex flex-col gap-8">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('AI Intelligence') }}
            </h1>
            <p class="text-on-surface/60 dark:text-on-surface-dark/60 font-medium mt-1">
                {{ __('Manage your custom-built AI agents and automated workflows.') }}
            </p>
        </div>
        <x-button href="{{ route('agents.create') }}" class="shadow-lg shadow-primary/20">
            <x-icons.plus variant="outline" size="sm" class="mr-1" />
            {{ __('New Agent') }}
        </x-button>
    </div>

    <!-- Filters -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center">
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                <x-icons.magnifying-glass variant="outline" size="sm" class="text-on-surface/40" />
            </div>
            <x-input 
                type="search" 
                wire:model.live.debounce.300ms="search" 
                placeholder="{{ __('Search agents by name or model...') }}" 
                class="pl-11 !bg-surface border-transparent shadow-sm focus:!bg-surface"
            />
        </div>
        <div class="w-full sm:w-48">
            <x-select wire:model.live="providerFilter" class="!bg-surface border-transparent shadow-sm">
                <option value="">{{ __('All Providers') }}</option>
                @foreach ($providers as $provider)
                    <option value="{{ $provider->value }}">{{ $provider->label() }}</option>
                @endforeach
            </x-select>
        </div>
    </div>

    <!-- Agents Grid -->
    @if ($agents->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($agents as $agent)
                <div class="group flex flex-col overflow-hidden rounded-3xl border border-outline bg-surface shadow-premium transition-all duration-300 hover:shadow-xl hover:-translate-y-1 dark:border-outline-dark dark:bg-surface-dark-alt" wire:key="agent-{{ $agent->id }}">
                    <div class="p-6">
                        <!-- Provider & Status -->
                        <div class="flex items-center justify-between mb-4">
                            <div @class([
                                'size-10 rounded-xl flex items-center justify-center font-black text-xs text-white shadow-lg shadow-black/5',
                                'bg-black' => $agent->provider === 'openai',
                                'bg-[#D97757]' => $agent->provider === 'anthropic',
                                'bg-blue-600' => $agent->provider === 'gemini',
                            ])>
                                {{ strtoupper(substr($agent->provider, 0, 1)) }}
                            </div>
                            <div class="flex gap-2">
                                @if($agent->is_public)
                                    <x-badge variant="success" size="sm">{{ __('Public') }}</x-badge>
                                @endif
                                <x-badge :variant="$agent->is_active ? 'primary' : 'default'" size="sm">
                                    {{ $agent->is_active ? __('Active') : __('Inactive') }}
                                </x-badge>
                            </div>
                        </div>

                        <!-- Name & Model -->
                        <div class="space-y-1 mb-4">
                            <h3 class="text-lg font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong group-hover:text-primary transition-colors line-clamp-1">
                                {{ $agent->name }}
                            </h3>
                            <p class="text-[10px] font-mono font-bold uppercase tracking-widest text-on-surface/40 bg-surface-alt dark:bg-surface-dark px-2 py-0.5 rounded-md inline-block">
                                {{ $agent->model }}
                            </p>
                        </div>

                        <!-- Description -->
                        @if($agent->description)
                            <p class="text-sm text-on-surface/60 line-clamp-2 leading-relaxed mb-6">
                                {{ $agent->description }}
                            </p>
                        @else
                            <div class="h-10 mb-6 italic text-on-surface/30 text-xs flex items-center">{{ __('No description provided.') }}</div>
                        @endif

                        <!-- Actions -->
                        <div class="flex items-center gap-2 mt-auto pt-4 border-t border-outline/50 dark:border-outline-dark/50">
                            <x-button href="{{ route('agents.show', $agent) }}" size="sm" class="flex-1">
                                <x-icons.sparkles size="xs" class="mr-1" />
                                {{ __('Run') }}
                            </x-button>
                            
                            @can('update', $agent)
                                <a href="{{ route('agents.edit', $agent) }}" class="size-9 flex items-center justify-center rounded-xl bg-surface-alt hover:bg-primary/10 hover:text-primary text-on-surface/60 transition-all dark:bg-surface-dark">
                                    <x-icons.pencil-square size="xs" />
                                </a>
                            @endcan

                            @can('delete', $agent)
                                <button wire:click="confirmDelete({{ $agent->id }})" class="size-9 flex items-center justify-center rounded-xl bg-surface-alt hover:bg-danger/10 hover:text-danger text-on-surface/60 transition-all dark:bg-surface-dark">
                                    <x-icons.trash size="xs" />
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $agents->links() }}
        </div>
    @else
        <x-card class="py-20">
            <div class="flex flex-col items-center justify-center text-center">
                <div class="bg-surface-alt dark:bg-surface-dark rounded-full p-8 mb-6">
                    <x-icons.sparkles variant="outline" size="xl" class="text-on-surface/20" />
                </div>
                <h3 class="text-xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('No agents found') }}
                </h3>
                <p class="text-on-surface/60 max-w-sm mt-2 leading-relaxed">
                    {{ $search || $providerFilter ? __('We couldn\'t find any agents matching your filters.') : __('Create your first AI agent to automate your tasks.') }}
                </p>
                <div class="mt-8">
                    <x-button href="{{ route('agents.create') }}" class="shadow-lg shadow-primary/20">
                        {{ __('Create First Agent') }}
                    </x-button>
                </div>
            </div>
        </x-card>
    @endif

    <!-- Delete Modal -->
    <x-modal :show="$deletingAgentId !== null" maxWidth="md">
        <div class="p-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="flex size-12 items-center justify-center rounded-full bg-danger/10 text-danger">
                    <x-icons.trash variant="outline" size="md" />
                </div>
                <div>
                    <h3 class="text-xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Delete Agent') }}
                    </h3>
                    <p class="text-sm text-on-surface/60">{{ __('This action is permanent.') }}</p>
                </div>
            </div>
            
            <p class="text-on-surface dark:text-on-surface-dark mb-8 leading-relaxed">
                {{ __('Are you sure you want to delete this agent? All execution history will be lost.') }}
            </p>

            <div class="flex items-center justify-end gap-3">
                <x-button variant="ghost" type="button" wire:click="cancelDelete">{{ __('Cancel') }}</x-button>
                <x-button variant="danger" type="button" wire:click="deleteAgent">{{ __('Delete Agent') }}</x-button>
            </div>
        </div>
    </x-modal>
</div>
