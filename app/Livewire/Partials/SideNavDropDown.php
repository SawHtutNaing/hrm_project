<?php

namespace App\Livewire\Partials;

use Livewire\Component;

class SideNavDropDown extends Component
{
    public $label;

    public $icon;

    public $lists;

    public function mount($label, $icon, $lists)
    {
        $this->label = $label;
        $this->icon = $icon;
        $this->lists = $lists;
    }

    public function render()
    {
        return view('livewire.side-nav-drop-down');
    }
}
