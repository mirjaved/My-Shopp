<?php

namespace App\Http\Livewire\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;

class UserChangePasswordComponent extends Component
{
    public $current_password;
    public $password;
    public $password_confirm;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed|different:current_password',
        ]);
    }

    public function changePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed|different:current_password',            
        ]);

        if(Hash::check($this->current_password, Auth::user()->password))
        {
            $user = User::findorFail(Auth::user()->id);
            $user->password = Hash::make($this->password);
            $user->save();
            session()->flash('password_success', 'Password is changed successfully!');
        }
        else
        {
            session()->flash('password_error', 'Password does not match!');
        }
    }

    public function render()
    {
        return view('livewire.user.user-change-password-component')->layout('layouts.index');
    }
}
