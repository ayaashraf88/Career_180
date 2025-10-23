<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class NavbarCourseSearch extends Component
{
    public $searchTerm = '';
    public $showDropdown = false;
    public $results = [];

    public function updatedSearchTerm()
    {
        if (strlen($this->searchTerm) > 1) {
            $this->showDropdown = true;
            $this->results = Course::where('name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('description', 'like', '%' . $this->searchTerm . '%')
                ->take(5)
                ->get();
        } else {
            $this->showDropdown = false;
            $this->results = [];
        }
    }

    public function showDropdown()
    {
        if (strlen($this->searchTerm) > 1) {
            $this->showDropdown = true;
        }
    }

    public function hideDropdown()
    {
        $this->showDropdown = false;
    }

    public function render()
    {
        return view('livewire.navbar-course-search');
    }
}