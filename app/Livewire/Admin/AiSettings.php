<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Enums\AiProviderEnum;
use App\Livewire\Concerns\HasToast;
use App\Models\AiApiKey;
use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Livewire component for managing global AI settings and API keys.
 *
 * Allows administrators to enable/disable AI features and configure
 * API keys for supported AI providers (OpenAI, Anthropic, Gemini).
 */
#[Layout('components.layouts.app')]
final class AiSettings extends Component
{
    use HasToast;

    public bool $aiEnabled = false;

    public string $openaiKey = '';

    public string $anthropicKey = '';

    public string $geminiKey = '';

    /**
     * Initialize the component state with the current AI enabled setting.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->aiEnabled = (bool) Setting::get('ai.enabled', false);
    }

    /**
     * Persist AI settings and API keys to the database.
     *
     * Saves the AI enabled/disabled toggle and any non-empty API keys
     * for each provider, then clears the key fields for security.
     *
     * @return void
     */
    public function saveSettings(): void
    {
        Setting::set('ai.enabled', $this->aiEnabled ? '1' : '0', 'ai');

        $this->saveApiKey(AiProviderEnum::OpenAi, $this->openaiKey);
        $this->saveApiKey(AiProviderEnum::Anthropic, $this->anthropicKey);
        $this->saveApiKey(AiProviderEnum::Gemini, $this->geminiKey);

        $this->openaiKey = '';
        $this->anthropicKey = '';
        $this->geminiKey = '';

        $this->toastSuccess('AI settings saved successfully.');
    }

    /**
     * Save or update a global API key for a specific AI provider.
     *
     * Skips saving if the key is empty, allowing partial updates.
     *
     * @param  AiProviderEnum  $provider  The AI provider to save the key for.
     * @param  string  $key  The API key value to store.
     * @return void
     */
    private function saveApiKey(AiProviderEnum $provider, string $key): void
    {
        if ($key === '') {
            return;
        }

        AiApiKey::updateOrCreate(
            ['user_id' => null, 'provider' => $provider->value],
            ['api_key' => $key, 'is_active' => true],
        );
    }

    /**
     * Render the AI settings view with provider information and existing key status.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $globalKeys = AiApiKey::global()->get();

        $hasKeys = [];
        foreach (AiProviderEnum::cases() as $provider) {
            $hasKeys[$provider->value] = $globalKeys->contains('provider', $provider->value);
        }

        return view('livewire.admin.ai-settings', [
            'providers' => AiProviderEnum::cases(),
            'hasKeys' => $hasKeys,
        ]);
    }
}
