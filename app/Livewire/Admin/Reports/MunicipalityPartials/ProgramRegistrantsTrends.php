<?php

namespace App\Livewire\Admin\Reports\MunicipalityPartials;

use App\Models\Program_Reg;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ProgramRegistrantsTrends extends Component
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

        $this->dispatch('close-modal', 'filter-registrant-trends-modal');
    }

    public function getAreaProgramRegistrationsTrend($municipalityId = null, $provinceId = null)
    {
        // Use the provided year or default to the current year
        $year = $this->selectedYear ?? Carbon::now()->year;

        // Use the provided months or default to all months (1 through 12)
        $months = !empty($this->selectedMonths) ? $this->selectedMonths : range(1, 12);

        // Fetch the registrations data from the program_reg table
        $query = Program_Reg::selectRaw('MONTH(program_reg.created_at) as month, COUNT(*) as total')
            ->join('programs', 'program_reg.program_id', '=', 'programs.program_id')
            ->join('peso', 'programs.peso_id', '=', 'peso.peso_id') // Join peso table
            ->join('municipality', 'peso.municipality_id', '=', 'municipality.municipality_id'); // Join municipality table

        // Apply filter for municipality or province
        if ($municipalityId) {
            // Filter by municipality if provided
            $query->where('municipality.municipality_id', $municipalityId);
        } elseif ($provinceId) {
            // Otherwise, filter by all municipalities within the province
            $query->whereHas('programs.peso.municipality.province', function ($query) use ($provinceId) {
                $query->where('province.province_id', $provinceId);
            });
        }

        // Group and order the results by month
        $query->groupByRaw('MONTH(program_reg.created_at)')
            ->orderByRaw('MONTH(program_reg.created_at)');

        // Apply year filter if selectedYear is set
        if ($this->selectedYear) {
            $query->whereYear('program_reg.created_at', $year);
        }

        // Apply months filter if selectedMonths is set
        if (!empty($this->selectedMonths)) {
            $query->whereIn(DB::raw('MONTH(program_reg.created_at)'), $months);
        }

        $monthlyData = $query->get();

        // Define month names
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Initialize an empty array for monthly data
        $data = array_fill(0, 12, 0); // Initialize with 0s for all 12 months

        // Populate the counts
        foreach ($monthlyData as $dataEntry) {
            $index = $dataEntry->month - 1; // Adjust index for zero-based array
            $data[$index] = $dataEntry->total;
        }

        // Create the area chart model
        $chart = LivewireCharts::areaChartModel()
            ->setTitle("Monthly Program Registrations in {$year}")
            ->setAnimated(true)
            ->setSmoothCurve()
            ->setXAxisVisible(true)
            ->setDataLabelsEnabled(true);

        // Filter month names to include only selected months
        $filteredMonthNames = array_filter($monthNames, function ($key) use ($months) {
            return in_array($key + 1, $months);
        }, ARRAY_FILTER_USE_KEY);

        // Add points to the chart for program registrations
        foreach ($filteredMonthNames as $index => $monthName) {
            $chart->addPoint($monthName, $data[$index]);
        }

        // Set X-axis categories to include only selected months
        $chart->setXAxisCategories($filteredMonthNames);

        $chart->setJsonConfig([
            'chart' => [
                'width' => '100%',
                'height' => '300px',
            ],
            'xaxis' => [
                'categories' => $filteredMonthNames,
            ],
            'dataLabels' => [
                'enabled' => true,
            ],
            'stroke' => [
                'curve' => 'smooth',
            ],
            'fill' => [
                'opacity' => 0.3, // Adjust the fill opacity
            ],
            'yaxis.tickAmount' => 1,
            'yaxis.labels.formatter' => '(val) => Math.floor(val)',
        ]);

        return $chart;
    }

    public function render()
    {

        $programRegistrants = null;

        if ($this->municipalityID) {
            $programRegistrants = $this->getAreaProgramRegistrationsTrend($this->municipalityID);

        } elseif ($this->provinceID) {
            $programRegistrants = $this->getAreaProgramRegistrationsTrend(null, $this->provinceID);

        }

        return view('livewire.admin.reports.municipality-partials.program-registrants-trends', compact('programRegistrants'));
    }
}
