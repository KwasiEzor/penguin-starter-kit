<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Livewire\Concerns\HasToast;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;

final class Profile extends Component
{
    use HasToast;

    public string $name = '';

    public string $email = '';

    public string $deletePassword = '';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
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
