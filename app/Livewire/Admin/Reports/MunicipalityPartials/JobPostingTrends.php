<?php

namespace App\Livewire\Admin\Reports\MunicipalityPartials;

use App\Models\Job_Posting;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class JobPostingTrends extends Component
{
    public $startYear, $currentYear;

    public $selectedMonths = [], $selectedYear;
    public $mountSelectedMonths = [], $mountSelectedYear;
    public $municipalityID;
    public $provinceID;

    #[On('updateProv')]
    public function updateProv($id)
    {
        $this->provinceID = $id;
    }

    #[On('updateMun')]
    public function updateMun($id)
    {
        $this->municipalityID = $id;
    }

    public function mount()
    {
        $this->startYear = 2024;
        $this->currentYear = date('Y');

    }

    public function resetFilter()
    {
        $this->reset('mountSelectedMonths', 'mountSelectedYear', 'selectedMonths', 'selectedYear');

    }

    public function mountFilter()
    {

        $this->selectedMonths = $this->mountSelectedMonths;
        $this->selectedYear = $this->mountSelectedYear;

        $this->dispatch('close-modal', 'filter-jobposting-trends-modal');
    }
    public function getJobPostingsTrend($municipalityId = null, $provinceId = null)
    {
        // Use the provided year or default to the current year
        $year = $this->selectedYear ?? Carbon::now()->year;

        // Use the provided months or default to all months (1 through 12)
        $months = !empty($this->selectedMonths) ? $this->selectedMonths : range(1, 12);

        // Build the base query
        $query = Job_Posting::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year) // Apply year filter
            ->whereIn(DB::raw('MONTH(created_at)'), $months); // Apply month filter

        // If a municipality ID is provided, filter by municipality
        if ($municipalityId) {
            $query->whereHas('peso.municipality', function ($query) use ($municipalityId) {
                $query->where('municipality_id', $municipalityId);
            });
        }

        // If a province ID is provided (and municipality is not), filter by province
        if ($provinceId && !$municipalityId) {
            $query->whereHas('peso.municipality', function ($query) use ($provinceId) {
                $query->where('province_id', $provinceId);
            });
        }

        // Group the results by month and order them
        $monthlyPostings = $query->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Define month names
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Initialize an empty array for monthly data
        $monthlyData = array_fill(0, 12, 0); // Initialize with 0s for all 12 months

        // Populate the counts
        foreach ($monthlyPostings as $data) {
            $index = $data->month - 1; // Adjust index for zero-based array
            $monthlyData[$index] = $data->total;
        }

        // Create the line chart model
        $chart = LivewireCharts::lineChartModel()
            ->setTitle("Monthly Job Postings for " . ($municipalityId ? "Municipality ID {$municipalityId}" : "Province ID {$provinceId}") . " in {$year}")
            ->setAnimated(true)
            ->setSmoothCurve()
            ->setXAxisVisible(true)
            ->setDataLabelsEnabled(true);

        // Filter month names to include only selected months
        $filteredMonthNames = array_filter($monthNames, function ($key) use ($months) {
            return in_array($key + 1, $months);
        }, ARRAY_FILTER_USE_KEY);

        // Add points to the chart
        foreach ($filteredMonthNames as $index => $monthName) {
            $chart->addPoint($monthName, $monthlyData[$index]);
        }

        // Set X-axis categories to include only selected months
        $chart->setXAxisCategories($filteredMonthNames);

        // Set additional chart configuration
        $chart->setJsonConfig([
            'chart' => [
                'width' => '100%',
                'height' => '300px',
            ],
            'yaxis.tickAmount' => 1,
            'yaxis.labels.formatter' => '(val) => Math.floor(val)',
        ]);

        return $chart;
    }

    public function render()
    {

        $jobPostingTrend = null;


        if ($this->municipalityID) {
            $jobPostingTrend = $this->getJobPostingsTrend($this->municipalityID);

        } elseif ($this->provinceID) {
            $jobPostingTrend = $this->getJobPostingsTrend(null, $this->provinceID);

        }

        return view('livewire.admin.reports.municipality-partials.job-posting-trends', compact('jobPostingTrend'));
    }
}
