<?php

namespace App\Livewire\Admin\Reports\BarangayPartials;

use App\Models\Programs;
use Livewire\Attributes\On;
use Livewire\Component;

class PopularTrainings extends Component
{
    public $barangayID;

    #[On('updateBar')]
    public function updateBar($id)
    {
        $this->barangayID = $id;
    }

    private function getTopPrograms()
    {
        return Programs::withCount(['program_reg as registration_count' => function ($query) {
            $query->whereHas('employee', function ($query) {
                $query->where('barangay_id', $this->barangayID);
            });
        }])
            ->having('registration_count', '>', 0) // Ensure registration count is greater than zero
            ->orderBy('registration_count', 'desc')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        $topPrograms = $this->getTopPrograms();

        return view('livewire.admin.reports.barangay-partials.popular-trainings', compact('topPrograms'));
    }
}
