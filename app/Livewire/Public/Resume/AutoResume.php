<?php

namespace App\Livewire\Public\Resume;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.empty')]
class AutoResume extends Component
{
    public function render()
    {
        return view('livewire.public.resume.auto-resume');
    }
}
