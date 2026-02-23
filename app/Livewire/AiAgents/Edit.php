<?php

declare(strict_types=1);

namespace App\Livewire\AiAgents;

use App\Enums\AiProviderEnum;
use App\Livewire\Concerns\HasToast;
use App\Models\AiAgent;
use App\Support\Toast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Livewire component for editing an existing AI agent.
 *
 * Loads the agent's current configuration into the form, allows the user
 * to modify settings, and persists the changes after validation.
 */
#[Layout('components.layouts.app')]
final class Edit extends Component
{
    use HasToast;

    public AiAgent $aiAgent;

    public string $name = '';

    public string $description = '';

    public string $provider = '';

    public string $model = '';

    public string $system_prompt = '';

    public string $temperature = '0.7';

    public string $max_tokens = '1024';

    public bool $is_public = false;

    /**
     * @var list<string>
     */
    public array $availableModels = [];

    /**
     * Initialize the component with the given AI agent's data.
     *
     * @param  AiAgent  $aiAgent  The AI agent to edit.
     * @return void
     */
    public function mount(AiAgent $aiAgent): void
    {
        $this->authorize('update', $aiAgent);

        $this->aiAgent = $aiAgent;
        $this->name = $aiAgent->name;
        $this->description = $aiAgent->description ?? '';
        $this->provider = $aiAgent->provider;
        $this->model = $aiAgent->model;
        $this->system_prompt = $aiAgent->system_prompt;
        $this->temperature = (string) $aiAgent->temperature;
        $this->max_tokens = (string) $aiAgent->max_tokens;
        $this->is_public = $aiAgent->is_public;
        $this->availableModels = $aiAgent->providerEnum()->models();
    }

    /**
     * Update available models when the selected provider changes.
     *
     * @return void
     */
    public function updatedProvider(): void
    {
        $providerEnum = AiProviderEnum::from($this->provider);
        $this->availableModels = $providerEnum->models();
        $this->model = $providerEnum->defaultModel();
    }

    /**
     * Validate the form inputs and update the AI agent with the new configuration.
     *
     * @return void
     */
    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'provider' => ['required', 'string', 'in:'.implode(',', array_column(AiProviderEnum::cases(), 'value'))],
            'model' => ['required', 'string', 'max:100'],
            'system_prompt' => ['required', 'string'],
            'temperature' => ['required', 'numeric', 'min:0', 'max:2'],
            'max_tokens' => ['required', 'integer', 'min:1', 'max:128000'],
            'is_public' => ['boolean'],
        ]);

        $validated['temperature'] = (float) $validated['temperature'];
        $validated['max_tokens'] = (int) $validated['max_tokens'];

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (! $user->isAdmin()) {
            $validated['is_public'] = false;
        }

        $this->aiAgent->update($validated);

        Toast::success('Agent updated successfully.');

        $this->redirect(route('agents.index'), navigate: true);
    }

    /**
     * Render the AI agent edit form view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.ai-agents.edit', [
            'providers' => AiProviderEnum::cases(),
        ]);
    }
}
