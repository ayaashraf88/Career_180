<?php

namespace App\Livewire;

use Livewire\Component;

class Toasts extends Component
{
    public $toasts = [];

    protected $listeners = ['notify' => 'addToast'];

    public function addToast($payload)
    {
        $this->toasts[] = $payload;

        // auto remove after 6 seconds
        $this->dispatch('remove-toast', ['index' => count($this->toasts) - 1]);
    }

    public function render()
    {
        return view('livewire.toasts');
    }
}
