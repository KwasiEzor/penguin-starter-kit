<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Livewire\Concerns\HasToast;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

final class Profile extends Component
{
    use HasToast, WithFileUploads;

    public string $name = '';

    public string $email = '';

    public string $deletePassword = '';

    public $avatar;

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updatedAvatar(): void
    {
        $this->validate([
            'avatar' => ['image', 'max:1024'],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->addMedia($this->avatar->getRealPath())
            ->usingFileName($this->avatar->hashName())
            ->toMediaCollection('avatar');

        $this->reset('avatar');
        $this->toastSuccess('Avatar updated successfully.');
    }

    public function removeAvatar(): void
    {
        /** @var User $user */
        $user = Auth::user();
        $user->clearMediaCollection('avatar');

        $this->toastSuccess('Avatar removed.');
    }

    public function updateProfile(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->toastSuccess('Profile updated successfully.');
    }

    public function deleteAccount(): void
    {
        $this->validate([
            'deletePassword' => ['required', 'string', 'current_password'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        Auth::logout();

        $user->delete();

        Session::invalidate();
        Session::regenerateToken();

        $this->redirect(route('home'), navigate: true);
    }

    public function render()
    {
        return view('livewire.settings.profile');
    }
}
