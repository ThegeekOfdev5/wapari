<?php

namespace App\Http\Livewire\Employee\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class Logout extends Component
{
    public function logout()
    {
        Auth::guard('employee')->logout();

        session()->forget('url.intended');

        $this->redirect(RouteServiceProvider::HOME);
    }

    public function render()
    {
        return view('livewire.employee.auth.logout')->layout('layouts.blank');
    }
}
