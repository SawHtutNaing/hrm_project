<?php

namespace App\Livewire\Components;

use App\Livewire\Actions\Logout;
use Livewire\Component;

class Navigation extends Component
{
    public function logout(Logout $logout): void
    {

        $logout();

        $this->redirect('/', navigate: true);
    }

    public function render()
    {

        return view('App.main.navBar');
    }
}
