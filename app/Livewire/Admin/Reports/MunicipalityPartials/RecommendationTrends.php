<?php

namespace App\Livewire\Admin\Reports\MunicipalityPartials;

use App\Models\Job_Applicants;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class RecommendationTrends extends Component
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

        $this->dispatch('close-modal', 'filter-recommendation-trends-modal');
    }

    public function getRecommendationTrends($pesoMunicipalityId = null, $provinceId = null)
    {
        // Use the provided year or default to $this->currentYear
        $year = $this->selectedYear ?? $this->currentYear;

        // Use the provided months or default to all months (1 through 12)
        $months = !empty($this->selectedMonths) ? $this->selectedMonths : range(1, 12);

        // Fetch the job applicants with relevant data
        $query = Job_Applicants::whereHas('job_posting', function ($query) use ($pesoMunicipalityId, $provinceId) {
            if ($pesoMunicipalityId) {
                // Filter by municipality if provided
                $query->whereHas('peso', function ($query) use ($pesoMunicipalityId) {
                    $query->where('municipality_id', $pesoMunicipalityId);
                });
            } elseif ($provinceId) {
                // Otherwise, filter by all municipalities within the province
                $query->whereHas('peso.municipality', function ($query) use ($provinceId) {
                    $query->whereHas('province', function ($query) use ($provinceId) {
                        $query->where('province_id', $provinceId);
                    });
                });
            }
        })
            ->whereNotNull('responded_at')
            ->selectRaw('MONTH(responded_at) as month, peso_Status, COUNT(*) as count')
            ->groupBy('month', 'peso_Status')
            ->orderBy('month');

        // Apply year filter if selectedYear is set
        if ($this->selectedYear) {
            $query->whereYear('responded_at', $year);
        }

        // Apply months filter if selectedMonths is set
        if (!empty($this->selectedMonths)) {
            $query->whereIn(DB::raw('MONTH(responded_at)'), $months);
        }

        $jobApplicants = $query->get();

        // Define month names
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Initialize arrays for recommended and not recommended counts
        $recommended = array_fill(0, 12, 0);
        $notRecommended = array_fill(0, 12, 0);

        // Populate the counts
        foreach ($jobApplicants as $applicant) {
            $index = $applicant->month - 1; // Adjust index for zero-based array
            if ($applicant->peso_Status == 'RECOMMENDED') {
                $recommended[$index] = $applicant->count;
            } else if ($applicant->peso_Status == 'REJECT') {
                $notRecommended[$index] = $applicant->count;
            }
        }

        // Filter month names to include only selected months
        $filteredMonthNames = array_filter($monthNames, function ($key) use ($months) {
            return in_array($key + 1, $months);
        }, ARRAY_FILTER_USE_KEY);

        // Create the multi-line chart model
        $multiLineChartModel = LivewireCharts::multiLineChartModel()
            ->setTitle("Monthly Job Applicant Recommendations for {$year}")
            ->setAnimated(true)
            ->multiLine()
            ->setSmoothCurve()
            ->setDataLabelsEnabled(true)
            ->setColors(['#00FF00', '#FF0000']); // Green for RECOMMENDED, Red for NOT RECOMMENDED

        // Add data points for each selected month
        foreach ($filteredMonthNames as $index => $monthName) {
            $multiLineChartModel
                ->addSeriesPoint('RECOMMENDED', $monthName, $recommended[$index])
                ->addSeriesPoint('NOT RECOMMENDED', $monthName, $notRecommended[$index]);
        }

        return $multiLineChartModel
            ->setYAxisVisible(true)
            ->setDataLabelsEnabled(true)
            ->setJsonConfig([
                'chart' => [
                    'width' => '100%',
                    'height' => '300px',
                ],
                'yaxis.tickAmount' => 1,
                'yaxis.labels.formatter' => '(val) => Math.floor(val)',
                'legend' => [
                    'position' => 'top',
                    'horizontalAlign' => 'center',
                    'verticalAlign' => 'middle',
                    'fontSize' => '14px',
                    'fontFamily' => 'Helvetica, Arial, sans-serif',
                    'fontWeight' => 'normal',
                    'labels' => [
                        'colors' => '#333333',
                        'useSeriesColors' => true,
                        'formatter' => '(val) => val.toUpperCase()',
                    ],
                ],
            ]);
    }

    public function render()
    {

        $recommendedLineModel = null;

        
        if ($this->municipalityID) {
            $recommendedLineModel = $this->getRecommendationTrends($this->municipalityID);

        } elseif ($this->provinceID) {
            $recommendedLineModel = $this->getRecommendationTrends(null, $this->provinceID);

        }

        return view('livewire.admin.reports.municipality-partials.recommendation-trends', compact('recommendedLineModel'));
    }
}
