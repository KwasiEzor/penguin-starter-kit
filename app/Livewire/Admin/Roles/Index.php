<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Roles;

use App\Enums\RoleEnum;
use App\Livewire\Concerns\HasToast;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('components.layouts.app')]
final class Index extends Component
{
    use HasToast;

    public ?int $deletingRoleId = null;

    public bool $showDeleteModal = false;

    public function confirmDelete(int $id): void
    {
        $this->deletingRoleId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->deletingRoleId = null;
        $this->showDeleteModal = false;
    }

    public function deleteRole(): void
    {
        $role = Role::findOrFail($this->deletingRoleId);

        if ($role->name === RoleEnum::Admin->value) {
            $this->toastError('Cannot delete the admin role.');
            $this->deletingRoleId = null;
            $this->showDeleteModal = false;

            return;
        }

        if ($role->users()->count() > 0) {
            $this->toastError('Cannot delete a role that has users assigned.');
            $this->deletingRoleId = null;
            $this->showDeleteModal = false;

            return;
        }

        $role->delete();
        $this->deletingRoleId = null;
        $this->showDeleteModal = false;
        $this->toastSuccess('Role deleted successfully.');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $roles = Role::withCount(['users', 'permissions'])->get();

        return view('livewire.admin.roles.index', [
            'roles' => $roles,
        ]);
    }
}
