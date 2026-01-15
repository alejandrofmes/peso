<?php

namespace App\Livewire\Admin\Maintenance;

use App\Helpers\AuditFormatter;
use App\Models\Announcements;
use App\Models\Job_Applicants;
use App\Models\Job_Posting;
use App\Models\Programs;
use App\Models\Program_Reg;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use OwenIt\Auditing\Models\Audit;

#[Layout('layouts.admin')]
class Audits extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $filter = '';

    public function updateFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function render()
    {
        // Define models for filtering
        $models = [
            '2' => Job_Posting::class,
            '3' => Job_Applicants::class,
            '4' => Programs::class,
            '5' => Program_Reg::class,
            '6' => Announcements::class,
        ];

        // Build the query
        $query = Audit::query();

        if ($this->filter === '1') {
            // Filter for system updates
            $query->where('user_id', 0);
        } elseif (isset($models[$this->filter])) {
            // Filter by model type
            $query->where('auditable_type', $models[$this->filter]);
        } elseif ($this->filter === '' || $this->filter === '0') {
            // Show all audits if no filter or 'All' is selected
        } else {
            // Handle invalid or unknown filter
            $query->whereNull('id'); // This will effectively return no results
        }

        // Order by latest and paginate
        $audits = $query->latest()->paginate(10);

        // Extract the collection of items
        $items = $audits->items();

        // Format the collection of items
        $formattedItems = collect($items)->map(function ($audit) {
            return AuditFormatter::format($audit);
        });

        // Create a new LengthAwarePaginator with the formatted items
        $formattedAudits = new LengthAwarePaginator(
            $formattedItems,
            $audits->total(),
            $audits->perPage(),
            $audits->currentPage(),
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );

        return view('livewire.admin.maintenance.audits', compact('formattedAudits', 'audits'));
    }
}
