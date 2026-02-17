<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Roles;

use App\Enums\PermissionEnum;
use App\Support\Toast;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('components.layouts.app')]
final class Create extends Component
{
    public string $name = '';

    public array $selectedPermissions = [];

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'selectedPermissions' => ['array'],
            'selectedPermissions.*' => ['string'],
        ]);

        $role = Role::create(['name' => $this->name, 'guard_name' => 'web']);
        $role->syncPermissions($this->selectedPermissions);

        Toast::success('Role created successfully.');

        $this->redirect(route('admin.roles.index'), navigate: true);
    }

    public function render()
    {
        $permissionsByGroup = collect(PermissionEnum::cases())
            ->groupBy(fn (PermissionEnum $p) => $p->group());

        return view('livewire.admin.roles.create', [
            'permissionsByGroup' => $permissionsByGroup,
        ]);
    }
}
