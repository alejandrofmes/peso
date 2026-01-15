<?php

namespace App\Livewire\Admin\Super\DashboardPartials;

use App\Models\Job_Applicants;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EmploymentTrends extends Component
{

    public $startYear, $currentYear;

    public $selectedMonths = [], $selectedYear;
    public $mountSelectedMonths = [], $mountSelectedYear;

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

        $this->dispatch('close-modal', 'filter-employment-trends-modal');
    }

    public function getEmploymentTrends()
    {
        // Use the provided year or default to the current year
        $year = $this->selectedYear ?? Carbon::now()->year;

        // Use the provided months or default to all months (1 through 12)
        $months = !empty($this->selectedMonths) ? $this->selectedMonths : range(1, 12);

        // Fetch the job applicants with relevant data
        $query = Job_Applicants::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
            ->where('applicant_Status', 'PENDING');

        // Apply year filter if selectedYear is set
        if ($this->selectedYear) {
            $query->whereYear('updated_at', $year);
        }

        // Apply months filter if selectedMonths is set
        if (!empty($this->selectedMonths)) {
            $query->whereIn(DB::raw('MONTH(updated_at)'), $months);
        }

        $monthlyHiredCounts = $query->groupByRaw('MONTH(updated_at)')
            ->orderByRaw('MONTH(updated_at)')
            ->get();

        // Define month names
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Initialize an empty array for monthly data
        $monthlyData = array_fill(0, 12, 0); // Initialize with 0s for all 12 months

        // Populate the counts
        foreach ($monthlyHiredCounts as $dataEntry) {
            $index = $dataEntry->month - 1; // Adjust index for zero-based array
            $monthlyData[$index] = $dataEntry->total;
        }

        // Filter month names to include only selected months
        $filteredMonthNames = array_filter($monthNames, function ($key) use ($months) {
            return in_array($key + 1, $months);
        }, ARRAY_FILTER_USE_KEY);

        // Create the line chart model
        $chart = LivewireCharts::lineChartModel()
            ->setTitle("Monthly Employment for {$year}")
            ->setAnimated(true)
            ->setSmoothCurve()
            ->setXAxisVisible(true)
            ->setDataLabelsEnabled(true);

        // Add points to the chart for employment trends
        foreach ($filteredMonthNames as $index => $monthName) {
            $chart->addPoint($monthName, $monthlyData[$index]);
        }

        // Set X-axis categories to include only selected months
        $chart->setXAxisCategories($filteredMonthNames);

        $chart->setJsonConfig([
            'chart' => [
                'width' => '100%',
                'height' => '400px',
            ],
            'yaxis.tickAmount' => 1,
            'yaxis.labels.formatter' => '(val) => Math.floor(val)',
        ]);

        return $chart;
    }
    public function render()
    {

        $employmentLineModel = $this->getEmploymentTrends();

        return view('livewire.admin.super.dashboard-partials.employment-trends',compact('employmentLineModel'));
    }
}
