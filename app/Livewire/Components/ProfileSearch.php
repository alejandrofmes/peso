<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ProfileSearch extends Component
{

    public $search;

    public function searchProfile()
    {
        $this->redirectRoute('search.profiles', ['q' => $this->search], navigate: true);
    }
    public function render()
    {
        return view('livewire.components.profile-search');
    }
}
