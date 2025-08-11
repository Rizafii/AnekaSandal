<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserProfile extends Component
{
    public $user;
    public $username;
    public $email;
    public $full_name;
    public $phone;
    public $address;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public $activeTab = 'profile';

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->user = Auth::user();
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->full_name = $this->user->full_name;
        $this->phone = $this->user->phone;
        $this->address = $this->user->address;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPasswordFields();
    }

    public function updateProfile()
    {
        $this->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($this->user->id)
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($this->user->id)
            ],
            'full_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'address' => 'nullable|string|max:500',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 3 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, dash, dan underscore.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'full_name.max' => 'Nama lengkap maksimal 100 karakter.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'address.max' => 'Alamat maksimal 500 karakter.',
        ]);

        try {
            $this->user->update([
                'username' => $this->username,
                'email' => $this->email,
                'full_name' => $this->full_name,
                'phone' => $this->phone,
                'address' => $this->address,
            ]);

            session()->flash('success', 'Profil berhasil diperbarui!');
            $this->dispatch('refreshComponent');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat memperbarui profil.');
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|different:current_password',
            'new_password_confirmation' => 'required|same:new_password',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.different' => 'Password baru harus berbeda dengan password saat ini.',
            'new_password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'new_password_confirmation.same' => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($this->current_password, $this->user->password)) {
            $this->addError('current_password', 'Password saat ini tidak benar.');
            return;
        }

        try {
            $this->user->update([
                'password' => Hash::make($this->new_password),
            ]);

            $this->resetPasswordFields();
            session()->flash('password_success', 'Password berhasil diperbarui!');
        } catch (\Exception $e) {
            session()->flash('password_error', 'Terjadi kesalahan saat memperbarui password.');
        }
    }

    private function resetPasswordFields()
    {
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
        $this->resetErrorBag(['current_password', 'new_password', 'new_password_confirmation']);
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
