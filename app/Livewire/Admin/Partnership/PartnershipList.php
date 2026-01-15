<?php

namespace App\Livewire\Admin\Partnership;

use App\Models\Partnerships;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class PartnershipList extends Component
{

    use WithPagination;
    use WithoutUrlPagination;
    public $search;

    public $filter = '';
    public function updatedsearch()
    {
        $this->resetPage();
    }

    public function updateFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();

    }

    public function render()
    {
        $user = Auth::user();

        // Base query for fetching partnerships
        $query = Partnerships::where('peso_id', $user->peso_accounts->peso_id)
            ->whereHas('company', function ($query) {
                $query->where(function ($query) {
                    $query->where('trade_Name', 'like', '%' . $this->search . '%')
                        ->orWhere('business_Name', 'like', '%' . $this->search . '%');
                });
            });

        // Apply filters based on the filter value
        if ($this->filter == "") {
            $query->orderByRaw("FIELD(partnership_Status, 'PENDING') DESC");
        } elseif ($this->filter == 'OTHERS') {
            $query->whereIn('partnership_Status', ['REJECTED', 'CANCELLED']);
        } else {
            $query->where('partnership_Status', $this->filter);
        }

        // Paginate results
        $partnersData = $query->paginate(10);

        return view('livewire.admin.partnership.partnership-list', compact('partnersData'));
    }

}
