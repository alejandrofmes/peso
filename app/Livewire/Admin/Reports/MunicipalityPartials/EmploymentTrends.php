<?php

namespace App\Livewire\Admin\Reports\MunicipalityPartials;

use App\Models\Job_Applicants;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
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

        $this->dispatch('close-modal', 'filter-employment-trends-modal');
    }

    public function getEmploymentTrends($pesoMunicipalityId = null, $provinceId = null)
    {
        // Use the provided year or default to the current year
        $year = $this->selectedYear ?? Carbon::now()->year;

        // Use the provided months or default to all months (1 through 12)
        $months = !empty($this->selectedMonths) ? $this->selectedMonths : range(1, 12);

        // Build the base query
        $query = Job_Applicants::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
            ->where('applicant_Status', 'PENDING');

        // If a municipality ID is provided, filter by municipality
        if ($pesoMunicipalityId) {
            $query->whereHas('employee.barangay', function ($query) use ($pesoMunicipalityId) {
                $query->where('municipality_id', $pesoMunicipalityId);
            });
        }

        // If a province ID is provided (and municipality is not), filter by province
        if ($provinceId && !$pesoMunicipalityId) {
            $query->whereHas('employee.barangay.municipality', function ($query) use ($provinceId) {
                $query->where('province_id', $provinceId);
            });
        }

        // Apply year filter if selectedYear is set
        if ($this->selectedYear) {
            $query->whereYear('updated_at', $year);
        }

        // Apply months filter if selectedMonths is set
        if (!empty($this->selectedMonths)) {
            $query->whereIn(DB::raw('MONTH(updated_at)'), $months);
        }

        // Group the results by month and order them
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

        $employmentLineModel = null;


        if ($this->municipalityID) {
            $employmentLineModel = $this->getEmploymentTrends($this->municipalityID);

        } elseif ($this->provinceID) {
            $employmentLineModel = $this->getEmploymentTrends(null, $this->provinceID);

        }

        return view('livewire.admin.reports.municipality-partials.employment-trends', compact('employmentLineModel'));
    }
}
