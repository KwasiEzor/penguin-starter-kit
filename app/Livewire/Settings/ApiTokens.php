<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Livewire\Concerns\HasToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class ApiTokens extends Component
{
    use HasToast;

    public string $tokenName = '';

    public ?string $newToken = null;

    public ?int $deletingTokenId = null;

    public function createToken(): void
    {
        $this->validate([
            'tokenName' => ['required', 'string', 'max:255'],
        ]);

        $token = Auth::user()->createToken($this->tokenName);

        $this->newToken = $token->plainTextToken;
        $this->tokenName = '';
        $this->toastSuccess('API token created.');
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingTokenId = $id;
    }

    public function deleteToken(): void
    {
        Auth::user()->tokens()->where('id', $this->deletingTokenId)->delete();
        $this->deletingTokenId = null;
        $this->toastSuccess('API token revoked.');
    }

    public function render()
    {
        return view('livewire.settings.api-tokens', [
            'tokens' => Auth::user()->tokens()->latest()->get(),
        ]);
    }
}
