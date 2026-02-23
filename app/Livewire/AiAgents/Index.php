<?php

declare(strict_types=1);

namespace App\Livewire\AiAgents;

use App\Enums\AiProviderEnum;
use App\Livewire\Concerns\HasToast;
use App\Models\AiAgent;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Livewire component for listing and managing AI agents.
 *
 * Displays a paginated, searchable, and sortable table of AI agents
 * accessible by the authenticated user, with support for provider
 * filtering and agent deletion.
 */
#[Layout('components.layouts.app')]
final class Index extends Component
{
    use HasToast;
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $sortBy = 'created_at';

    #[Url]
    public string $sortDirection = 'desc';

    #[Url]
    public string $providerFilter = '';

    public ?int $deletingAgentId = null;

    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedProviderFilter(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingAgentId = $id;
    }

    public function cancelDelete(): void
    {
        $this->deletingAgentId = null;
    }

    public function deleteAgent(): void
    {
        $agent = AiAgent::findOrFail($this->deletingAgentId);
        $this->authorize('delete', $agent);
        $agent->delete();

        $this->deletingAgentId = null;
        $this->toastSuccess('Agent deleted successfully.');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $agents = AiAgent::query()
            ->accessibleBy($user)
            ->when($this->search, fn (\Illuminate\Database\Eloquent\Builder $q) => $q->where(function (\Illuminate\Database\Eloquent\Builder $q): void {
                $q->where('name', 'like', sprintf('%%%s%%', $this->search))
                    ->orWhere('description', 'like', sprintf('%%%s%%', $this->search));
            }))
            ->when($this->providerFilter, fn (\Illuminate\Database\Eloquent\Builder $q) => $q->where('provider', $this->providerFilter))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.ai-agents.index', [
            'agents' => $agents,
            'providers' => AiProviderEnum::cases(),
        ]);
    }
}
