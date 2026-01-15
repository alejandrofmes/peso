<?php

namespace App\Livewire\Public\Profile\Peso;

use App\Models\Announcements;
use App\Models\PESO;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class PesoProfile extends Component
{

    public $id;

    public function mount()
    {
        $PESO = PESO::find($this->id);

        if (!$PESO) {
            return $this->redirectRoute('dashboard');
        }

    }

    public function render()
    {

        $pesoInfo = PESO::find($this->id);

        $pesoAnnouncements = Announcements::where('peso_id', $this->id)
            ->where('announcement_Status', 'ACTIVE')->get();

        return view('livewire.public.profile.peso.peso-profile', compact('pesoInfo', 'pesoAnnouncements'));
    }
}
