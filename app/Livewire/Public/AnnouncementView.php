<?php

namespace App\Livewire\Public;

use App\Models\Announcements;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class AnnouncementView extends Component
{

    public $id;
    public function render()
    {

        $announcementInfo = Announcements::findOrFail($this->id);

        return view('livewire.public.announcement-view', compact('announcementInfo'));
    }
}
