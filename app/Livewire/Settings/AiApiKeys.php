<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Enums\AiProviderEnum;
use App\Livewire\Concerns\HasToast;
use App\Models\AiApiKey;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class AiApiKeys extends Component
{
    use HasToast;

    public string $openaiKey = '';

    public string $anthropicKey = '';

    public string $geminiKey = '';

    public function saveKeys(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->saveApiKey($user->id, AiProviderEnum::OpenAi, $this->openaiKey);
        $this->saveApiKey($user->id, AiProviderEnum::Anthropic, $this->anthropicKey);
        $this->saveApiKey($user->id, AiProviderEnum::Gemini, $this->geminiKey);

        $this->openaiKey = '';
        $this->anthropicKey = '';
        $this->geminiKey = '';

        $this->toastSuccess('API keys saved successfully.');
    }

    private function saveApiKey(int $userId, AiProviderEnum $provider, string $key): void
    {
        if ($key === '') {
            return;
        }

        AiApiKey::updateOrCreate(
            ['user_id' => $userId, 'provider' => $provider->value],
            ['api_key' => $key, 'is_active' => true],
        );
    }

    public function removeKey(string $provider): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        AiApiKey::where('user_id', $user->id)
            ->where('provider', $provider)
            ->delete();

        $this->toastSuccess('API key removed.');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $userKeys = AiApiKey::where('user_id', $user->id)->get();

        $hasKeys = [];
        foreach (AiProviderEnum::cases() as $provider) {
            $hasKeys[$provider->value] = $userKeys->contains('provider', $provider->value);
        }

        return view('livewire.settings.ai-api-keys', [
            'providers' => AiProviderEnum::cases(),
            'hasKeys' => $hasKeys,
        ]);
    }
}
