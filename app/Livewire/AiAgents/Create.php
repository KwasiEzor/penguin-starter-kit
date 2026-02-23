<?php

declare(strict_types=1);

namespace App\Livewire\AiAgents;

use App\Enums\AiProviderEnum;
use App\Livewire\Concerns\HasToast;
use App\Support\Toast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Livewire component for creating a new AI agent.
 *
 * Provides a form to configure an AI agent's name, provider, model,
 * system prompt, and generation parameters, then persists it to the database.
 */
#[Layout('components.layouts.app')]
final class Create extends Component
{
    use HasToast;

    public string $name = '';

    public string $description = '';

    public string $provider = 'openai';

    public string $model = 'gpt-4o';

    public string $system_prompt = '';

    public string $temperature = '0.7';

    public string $max_tokens = '1024';

    public bool $is_public = false;

    /**
     * @var list<string>
     */
    public array $availableModels = ['gpt-4o', 'gpt-4o-mini', 'gpt-4-turbo'];

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
     * Validate the form inputs and create a new AI agent for the authenticated user.
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

        $user->aiAgents()->create($validated);

        Toast::success('Agent created successfully.');

        $this->redirect(route('agents.index'), navigate: true);
    }

    /**
     * Render the AI agent creation form view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.ai-agents.create', [
            'providers' => AiProviderEnum::cases(),
        ]);
    }
}
