<?php

namespace App\Livewire\Public\Resume;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.empty')]
class ResumeView extends Component
{
    public function render()
    {
        return view('livewire.public.resume.resume-view');
    }
}
