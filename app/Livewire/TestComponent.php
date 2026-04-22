<?php

namespace App\Livewire;

use Livewire\Component;

class TestComponent extends Component
{
    public $var = "Bonjour tout le monde ";
    public function render()
    {
        return view('livewire.test-component');
    }
}
