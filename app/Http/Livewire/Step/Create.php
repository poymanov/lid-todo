<?php

namespace App\Http\Livewire\Step;

use Livewire\Component;

class Create extends Component
{
    public $steps = [];

    public function add()
    {
        $this->steps[] = '';
    }

    public function remove($index)
    {
        unset($this->steps[$index]);
    }

    public function render()
    {
        return view('livewire.step.create');
    }
}
