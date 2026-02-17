<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Roles;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Support\Toast;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('components.layouts.app')]
final class Edit extends Component
{
    public Role $role;

    public string $name = '';

    public array $selectedPermissions = [];

    public function mount(Role $role): void
    {
        $this->role = $role;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($this->role->id)],
            'selectedPermissions' => ['array'],
            'selectedPermissions.*' => ['string'],
        ]);

        // Don't allow renaming the admin role
        if ($this->role->name !== RoleEnum::Admin->value) {
            $this->role->update(['name' => $this->name]);
        }

        $this->role->syncPermissions($this->selectedPermissions);

        Toast::success('Role updated successfully.');

        $this->redirect(route('admin.roles.index'), navigate: true);
    }

    public function render()
    {
        $permissionsByGroup = collect(PermissionEnum::cases())
            ->groupBy(fn (PermissionEnum $p) => $p->group());

        return view('livewire.admin.roles.edit', [
            'permissionsByGroup' => $permissionsByGroup,
            'isAdminRole' => $this->role->name === RoleEnum::Admin->value,
        ]);
    }
}
