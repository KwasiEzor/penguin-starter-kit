<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <x-breadcrumbs class="mb-4">
                <x-breadcrumb-item href="{{ route('agents.index') }}">{{ __('AI Agents') }}</x-breadcrumb-item>
                <x-breadcrumb-item :active="true">{{ $aiAgent->name }}</x-breadcrumb-item>
            </x-breadcrumbs>

            <x-typography.heading accent size="xl" level="1">{{ $aiAgent->name }}</x-typography.heading>
            @if ($aiAgent->description)
                <x-typography.subheading size="lg">{{ $aiAgent->description }}</x-typography.subheading>
            @endif
        </div>
        @can('update', $aiAgent)
            <x-button href="{{ route('agents.edit', $aiAgent) }}">{{ __('Edit Agent') }}</x-button>
        @endcan
    </div>

    <x-separator />

    <!-- Agent Info -->
    <x-card>
        <div class="flex flex-wrap gap-3">
            <x-badge variant="info">{{ \App\Enums\AiProviderEnum::from($aiAgent->provider)->label() }}</x-badge>
            <x-badge variant="default">{{ $aiAgent->model }}</x-badge>
            <x-badge :variant="$aiAgent->is_active ? 'success' : 'default'">
                {{ $aiAgent->is_active ? __('Active') : __('Inactive') }}
            </x-badge>
            <x-badge :variant="$aiAgent->is_public ? 'success' : 'default'">
                {{ $aiAgent->is_public ? __('Public') : __('Private') }}
            </x-badge>
            <x-badge variant="default">{{ __('Temp:') }} {{ $aiAgent->temperature }}</x-badge>
            <x-badge variant="default">{{ __('Max tokens:') }} {{ $aiAgent->max_tokens }}</x-badge>
        </div>
    </x-card>

    <!-- Task Execution -->
    @can('execute', $aiAgent)
        <x-card>
            <x-slot name="header">
                <x-typography.heading accent>{{ __('Execute Task') }}</x-typography.heading>
            </x-slot>

            <form wire:submit="executeTask" class="flex flex-col gap-4">
                <div>
                    <x-input-label for="taskInput" value="{{ __('Input') }}" />
                    <x-textarea
                        id="taskInput"
                        wire:model="taskInput"
                        rows="4"
                        class="mt-1"
                        placeholder="{{ __('Enter your task or question...') }}"
                    />
                    <x-input-error :messages="$errors->get('taskInput')" class="mt-2" />
                </div>

                <div class="flex items-center gap-3">
                    <x-button type="submit" wire:loading.attr="disabled" wire:target="executeTask">
                        <span wire:loading.remove wire:target="executeTask">{{ __('Execute') }}</span>
                        <span wire:loading wire:target="executeTask">{{ __('Executing...') }}</span>
                    </x-button>
                </div>
            </form>
        </x-card>

        <!-- Latest Result -->
        @if ($latestExecution)
            <x-card>
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <x-typography.heading accent>{{ __('Result') }}</x-typography.heading>
                        <div class="flex gap-2">
                            @if ($latestExecution->tokens_input)
                                <x-badge variant="default" size="sm">
                                    {{ __('In:') }} {{ number_format($latestExecution->tokens_input) }}
                                    {{ __('tokens') }}
                                </x-badge>
                            @endif

                            @if ($latestExecution->tokens_output)
                                <x-badge variant="default" size="sm">
                                    {{ __('Out:') }} {{ number_format($latestExecution->tokens_output) }}
                                    {{ __('tokens') }}
                                </x-badge>
                            @endif

                            @if ($latestExecution->execution_time_ms)
                                <x-badge variant="default" size="sm">
                                    {{ number_format($latestExecution->execution_time_ms) }}ms
                                </x-badge>
                            @endif
                        </div>
                    </div>
                </x-slot>

                @if ($latestExecution->status === 'completed')
                    <div class="prose dark:prose-invert max-w-none text-sm">
                        {!! nl2br(e($latestExecution->output)) !!}
                    </div>
                @elseif ($latestExecution->status === 'failed')
                    <div class="text-sm text-danger">
                        {{ $latestExecution->error_message }}
                    </div>
                @endif
            </x-card>
        @endif
    @endcan

    <!-- Recent Executions -->
    @if ($recentExecutions->count())
        <x-card>
            <x-slot name="header">
                <x-typography.heading accent>{{ __('Recent Executions') }}</x-typography.heading>
            </x-slot>

            <x-table>
                <x-slot name="head">
                    <x-table-heading>{{ __('Input') }}</x-table-heading>
                    <x-table-heading>{{ __('Status') }}</x-table-heading>
                    <x-table-heading>{{ __('Tokens') }}</x-table-heading>
                    <x-table-heading>{{ __('Time') }}</x-table-heading>
                    <x-table-heading>{{ __('Date') }}</x-table-heading>
                </x-slot>

                @foreach ($recentExecutions as $execution)
                    <tr
                        class="hover:bg-surface-alt/50 dark:hover:bg-surface-dark/50"
                        wire:key="exec-{{ $execution->id }}"
                    >
                        <x-table-cell class="max-w-xs truncate">
                            {{ Str::limit($execution->input, 60) }}
                        </x-table-cell>
                        <x-table-cell>
                            <x-badge
                                :variant="$execution->status === 'completed' ? 'success' : ($execution->status === 'failed' ? 'danger' : 'default')"
                            >
                                {{ ucfirst($execution->status) }}
                            </x-badge>
                        </x-table-cell>
                        <x-table-cell>
                            @if ($execution->tokens_input || $execution->tokens_output)
                                {{ number_format(($execution->tokens_input ?? 0) + ($execution->tokens_output ?? 0)) }}
                            @else
                                -
                            @endif
                        </x-table-cell>
                        <x-table-cell>
                            {{ $execution->execution_time_ms ? number_format($execution->execution_time_ms) . 'ms' : '-' }}
                        </x-table-cell>
                        <x-table-cell>
                            {{ $execution->created_at->format('M d, Y H:i') }}
                        </x-table-cell>
                    </tr>
                @endforeach
            </x-table>
        </x-card>
    @endif
</div>
