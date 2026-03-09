<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Livewire\Concerns\HasToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class ApiTokens extends Component
{
    use HasToast;

    public const AVAILABLE_ABILITIES = [
        'posts:read' => 'Read posts',
        'posts:write' => 'Create & update posts',
        'posts:delete' => 'Delete posts',
    ];

    public string $tokenName = '';

    public ?string $newToken = null;

    public ?int $deletingTokenId = null;

    public bool $showDeleteModal = false;

    /** @var array<int, string> */
    public array $selectedAbilities = [];

    public function createToken(): void
    {
        $this->validate([
            'tokenName' => ['required', 'string', 'max:255'],
            'selectedAbilities' => ['array'],
            'selectedAbilities.*' => ['string', 'in:'.implode(',', array_keys(self::AVAILABLE_ABILITIES))],
        ]);

        $abilities = empty($this->selectedAbilities) ? ['*'] : $this->selectedAbilities;

        $token = Auth::user()->createToken($this->tokenName, $abilities);

        $this->newToken = $token->plainTextToken;
        $this->tokenName = '';
        $this->selectedAbilities = [];
        $this->toastSuccess('API token created.');
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingTokenId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->deletingTokenId = null;
        $this->showDeleteModal = false;
    }

    public function deleteToken(): void
    {
        Auth::user()->tokens()->where('id', $this->deletingTokenId)->delete();
        $this->deletingTokenId = null;
        $this->showDeleteModal = false;
        $this->toastSuccess('API token revoked.');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.settings.api-tokens', [
            'tokens' => Auth::user()->tokens()->latest()->get(),
            'availableAbilities' => self::AVAILABLE_ABILITIES,
        ]);
    }
}
