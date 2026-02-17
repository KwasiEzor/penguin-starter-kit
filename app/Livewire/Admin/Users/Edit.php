<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Enums\RoleEnum;
use App\Livewire\Concerns\HasToast;
use App\Models\User;
use App\Support\Toast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
final class Edit extends Component
{
    use HasToast, WithFileUploads;

    public User $user;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $role = '';

    public $avatar;

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()?->name ?? RoleEnum::User->value;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:'.implode(',', array_column(RoleEnum::cases(), 'value'))],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $this->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            ...($validated['password'] ? ['password' => $validated['password']] : []),
        ]);

        // Only change role if it's not the current user
        if ($this->user->id !== Auth::id()) {
            // Prevent demoting the last admin
            if ($this->user->hasRole(RoleEnum::Admin) && $validated['role'] !== RoleEnum::Admin->value) {
                if (User::role(RoleEnum::Admin->value)->count() <= 1) {
                    $this->toastError('Cannot demote the last admin user.');

                    return;
                }
            }

            $this->user->syncRoles([RoleEnum::from($validated['role'])]);
        }

        if ($this->avatar) {
            $this->user->addMedia($this->avatar->getRealPath())
                ->usingFileName($this->avatar->hashName())
                ->toMediaCollection('avatar');
        }

        Toast::success('User updated successfully.');

        $this->redirect(route('admin.users.index'), navigate: true);
    }

    public function removeAvatar(): void
    {
        $this->user->clearMediaCollection('avatar');
        $this->toastSuccess('Avatar removed.');
    }

    public function render()
    {
        return view('livewire.admin.users.edit', [
            'roles' => RoleEnum::cases(),
            'isSelf' => $this->user->id === Auth::id(),
        ]);
    }
}
