<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Enums\RoleEnum;
use App\Livewire\Concerns\HasToast;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
final class Index extends Component
{
    use HasToast, WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $sortBy = 'created_at';

    #[Url]
    public string $sortDirection = 'desc';

    #[Url]
    public string $roleFilter = '';

    public ?int $deletingUserId = null;

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

    public function updatedRoleFilter(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingUserId = $id;
    }

    public function cancelDelete(): void
    {
        $this->deletingUserId = null;
    }

    public function deleteUser(): void
    {
        $user = User::findOrFail($this->deletingUserId);

        if ($user->id === Auth::id()) {
            $this->toastError('You cannot delete your own account.');
            $this->deletingUserId = null;

            return;
        }

        if ($user->hasRole(RoleEnum::Admin) && User::role(RoleEnum::Admin->value)->count() <= 1) {
            $this->toastError('Cannot delete the last admin user.');
            $this->deletingUserId = null;

            return;
        }

        $user->delete();
        $this->deletingUserId = null;
        $this->toastSuccess('User deleted successfully.');
    }

    public function render()
    {
        $users = User::query()
            ->with('roles')
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            }))
            ->when($this->roleFilter, fn ($q) => $q->role($this->roleFilter))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        return view('livewire.admin.users.index', [
            'users' => $users,
            'roles' => RoleEnum::cases(),
        ]);
    }
}
