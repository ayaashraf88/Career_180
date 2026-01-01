<?php

namespace App\Livewire;

use Livewire\Component;

class Tweet extends Component
{
    public $maxLength=2;
    public $tweet='';
    public function render()
    {
        return view('livewire.tweet');
    }
}
