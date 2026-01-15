<?php

namespace App\Livewire\Admin\Reports\BarangayPartials;

use App\Models\Job_Applicants;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class EmploymentTrends extends Component
{

    public $startYear, $currentYear;

    public $selectedMonths = [], $selectedYear;
    public $mountSelectedMonths = [], $mountSelectedYear;

    public $barangayID;

    #[On('updateBar')]
    public function updateBar($id)
    {
        $this->barangayID = $id;
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

        $this->dispatch('close-modal', 'filter-employment-trends-modal');
    }

    public function getEmploymentTrend($id)
    {
        // Use the provided year or default to the current year
        $year = $this->selectedYear ?? Carbon::now()->year;

        // Use the provided months or default to all months (1 through 12)
        $months = !empty($this->selectedMonths) ? $this->selectedMonths : range(1, 12);

        // Fetch the job applicants with relevant data
        $query = Job_Applicants::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
            ->where('applicant_Status', 'PENDING')
            ->whereHas('employee', function ($query) use ($id) {
                $query->where('barangay_id', $id);
            });

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
            ->get()
            ->keyBy('month');

        // Define month names
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Initialize array with months
        $monthlyData = array_fill(0, 12, 0);

        // Populate the counts
        foreach ($monthlyHiredCounts as $month => $data) {
            if (in_array($month, $months)) {
                $index = $month - 1; // Adjust index for zero-based array
                $monthlyData[$index] = $data->total;
            }
        }

        // Filter month names to include only selected months
        $filteredMonthNames = array_filter($monthNames, function ($key) use ($months) {
            return in_array($key + 1, $months);
        }, ARRAY_FILTER_USE_KEY);

        // Create the line chart model
        $chart = new LineChartModel();
        $chart->setAnimated(true)
            ->setTitle("Monthly Employment for {$year}")
            ->withOnPointClickEvent('onPointClick')
            ->setSmoothCurve()
            ->setXAxisVisible(true)
            ->setDataLabelsEnabled(true)
            ->setXAxisCategories($filteredMonthNames)
            ->setJsonConfig([
                'chart' => [
                    'width' => '100%',
                    'height' => '300px',
                ],
                'yaxis.tickAmount' => 1,
                'yaxis.labels.formatter' => '(val) => Math.floor(val)',
            ]);

        // Add points to the chart
        foreach ($filteredMonthNames as $index => $monthName) {
            $chart->addPoint($monthName, $monthlyData[$index]);
        }

        return $chart;
    }

    public function render()
    {

        $employmentTrend = $this->getEmploymentTrend($this->barangayID);

        return view('livewire.admin.reports.barangay-partials.employment-trends', compact('employmentTrend'));
    }
}
