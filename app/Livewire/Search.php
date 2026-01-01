<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $enrolledCourses;
    public $results = [];
    protected $rules = [
        'searchTerm'  => 'required|min:3',
    ];
    public function clear()
    {
        logger('Clear clicked ' . $this->searchTerm);
        $this->searchTerm = '';
        logger('Clear clicked ' . $this->searchTerm);
    }

    public function render()
    {
        return view('livewire.search');
    }

    public function mount($courses)
    {

        $this->enrolledCourses = $courses;
        $this->results = $courses;
    }
    public function updatedSearchTerm()
    {
        $this->validate();
        session()->flash('success', 'User created successfully');

        if (strlen($this->searchTerm) < 1) {
            return $this->results = $this->enrolledCourses;
        }

        return $this->results = $this->enrolledCourses->filter(function ($course) {
            return stripos($course->name, $this->searchTerm) !== false;
        });
    }
}
