<?php

declare(strict_types=1);

namespace App\Http\Livewire\Step;

use Livewire\Component;

class Update extends Component
{
    public $steps = [];

    public function mount($steps)
    {
        $this->steps = $steps->toArray();
    }

    public function add()
    {
        $this->steps[] = ['title' => ''];
    }

    public function remove($index)
    {
        unset($this->steps[$index]);
    }

    public function render()
    {
        return view('livewire.step.update');
    }
}
