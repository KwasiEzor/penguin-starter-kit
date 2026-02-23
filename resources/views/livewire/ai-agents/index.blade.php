<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <x-typography.heading accent size="xl" level="1">{{ __('AI Agents') }}</x-typography.heading>
            <x-typography.subheading size="lg">{{ __('Manage your AI agents') }}</x-typography.subheading>
        </div>
        <x-button href="{{ route('agents.create') }}">{{ __('Create Agent') }}</x-button>
    </div>

    <x-separator />

    <!-- Filters -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="flex-1">
            <x-input type="search" wire:model.live.debounce.300ms="search" placeholder="{{ __('Search agents...') }}" />
        </div>
        <div class="w-full sm:w-40">
            <x-select wire:model.live="providerFilter">
                <option value="">{{ __('All Providers') }}</option>
                @foreach ($providers as $provider)
                    <option value="{{ $provider->value }}">{{ $provider->label() }}</option>
                @endforeach
            </x-select>
        </div>
    </div>

    <!-- Table -->
    @if ($agents->count())
        <x-table>
            <x-slot name="head">
                <x-table-heading
                    :sortable="true"
                    :direction="$sortBy === 'name' ? $sortDirection : null"
                    wire:click="sortBy('name')"
                >
                    {{ __('Name') }}
                </x-table-heading>
                <x-table-heading>{{ __('Provider') }}</x-table-heading>
                <x-table-heading>{{ __('Model') }}</x-table-heading>
                <x-table-heading>{{ __('Visibility') }}</x-table-heading>
                <x-table-heading>{{ __('Status') }}</x-table-heading>
                <x-table-heading
                    :sortable="true"
                    :direction="$sortBy === 'created_at' ? $sortDirection : null"
                    wire:click="sortBy('created_at')"
                >
                    {{ __('Created') }}
                </x-table-heading>
                <x-table-heading>{{ __('Actions') }}</x-table-heading>
            </x-slot>

            @foreach ($agents as $agent)
                <tr class="hover:bg-surface-alt/50 dark:hover:bg-surface-dark/50" wire:key="agent-{{ $agent->id }}">
                    <x-table-cell class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                        <a href="{{ route('agents.show', $agent) }}" class="hover:underline">{{ $agent->name }}</a>
                    </x-table-cell>
                    <x-table-cell>
                        <x-badge variant="info">
                            {{ \App\Enums\AiProviderEnum::from($agent->provider)->label() }}
                        </x-badge>
                    </x-table-cell>
                    <x-table-cell>
                        <span class="text-xs">{{ $agent->model }}</span>
                    </x-table-cell>
                    <x-table-cell>
                        <x-badge :variant="$agent->is_public ? 'success' : 'default'">
                            {{ $agent->is_public ? __('Public') : __('Private') }}
                        </x-badge>
                    </x-table-cell>
                    <x-table-cell>
                        <x-badge :variant="$agent->is_active ? 'success' : 'default'">
                            {{ $agent->is_active ? __('Active') : __('Inactive') }}
                        </x-badge>
                    </x-table-cell>
                    <x-table-cell>
                        {{ $agent->created_at->format('M d, Y') }}
                    </x-table-cell>
                    <x-table-cell>
                        <div class="flex items-center gap-2">
                            <x-button size="xs" variant="ghost" href="{{ route('agents.show', $agent) }}">
                                {{ __('View') }}
                            </x-button>
                            @can('update', $agent)
                                <x-button size="xs" variant="ghost" href="{{ route('agents.edit', $agent) }}">
                                    {{ __('Edit') }}
                                </x-button>
                            @endcan

                            @can('delete', $agent)
                                <x-button
                                    size="xs"
                                    variant="ghost"
                                    wire:click="confirmDelete({{ $agent->id }})"
                                    class="text-danger hover:text-danger"
                                >
                                    {{ __('Delete') }}
                                </x-button>
                            @endcan
                        </div>
                    </x-table-cell>
                </tr>
            @endforeach
        </x-table>

        <div>
            {{ $agents->links() }}
        </div>
    @else
        <x-empty-state
            title="{{ __('No agents found') }}"
            description="{{ $search || $providerFilter ? __('Try adjusting your search or filters.') : __('Create your first AI agent to get started.') }}"
        >
            @unless ($search || $providerFilter)
                <x-slot name="action">
                    <x-button href="{{ route('agents.create') }}">{{ __('Create Agent') }}</x-button>
                </x-slot>
            @endunless
        </x-empty-state>
    @endif

    <!-- Delete Confirmation Modal -->
    <x-modal :show="$deletingAgentId !== null" maxWidth="md">
        <x-slot name="trigger"><span></span></x-slot>
        <x-slot name="header">
            <x-typography.subheading accent size="lg">{{ __('Delete Agent') }}</x-typography.subheading>
        </x-slot>
        <div class="p-4">
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Are you sure you want to delete this agent? This action cannot be undone.') }}
            </p>
        </div>
        <div
            class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end"
        >
            <x-button variant="ghost" type="button" wire:click="cancelDelete">{{ __('Cancel') }}</x-button>
            <x-button variant="danger" type="button" wire:click="deleteAgent">{{ __('Delete Agent') }}</x-button>
        </div>
    </x-modal>
</div>
