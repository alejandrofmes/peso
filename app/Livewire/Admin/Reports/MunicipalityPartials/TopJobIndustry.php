<?php

namespace App\Livewire\Admin\Reports\MunicipalityPartials;

use App\Models\Job_Posting;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TopJobIndustry extends Component
{
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

    public function getTopJobIndustriesDonut($municipalityId = null, $provinceId = null)
    {
        // Fetch the top job industries with a join to Job_Industry
        $query = Job_Posting::select('job_industry.industry_Title', DB::raw('COUNT(job_posting.industry_id) as total_count'))
            ->join('job_industry', 'job_posting.industry_id', '=', 'job_industry.industry_id') // Join Job_Industry
            ->join('peso', 'job_posting.peso_id', '=', 'peso.peso_id') // Join Peso
            ->where('job_posting.job_Status', 'ACTIVE')
            ->groupBy('job_industry.industry_Title')
            ->orderByDesc('total_count')
            ->limit(5);

        if ($municipalityId) {
            // Filter by municipality if provided
            $query->where('peso.municipality_id', $municipalityId);
        } elseif ($provinceId) {
            // Filter by all municipalities within the province if provided
            $query->whereHas('peso.municipality', function ($query) use ($provinceId) {
                $query->whereHas('province', function ($query) use ($provinceId) {
                    $query->where('province_id', $provinceId);
                });
            });
        }

        $topIndustries = $query->get();

        // Calculate the total count of all active job postings for the given municipality or province
        $totalQuery = Job_Posting::where('job_Status', 'ACTIVE')
            ->join('peso', 'job_posting.peso_id', '=', 'peso.peso_id'); // Join Peso

        if ($municipalityId) {
            // Filter by municipality if provided
            $totalQuery->where('peso.municipality_id', $municipalityId);
        } elseif ($provinceId) {
            // Filter by all municipalities within the province if provided
            $totalQuery->whereHas('peso.municipality', function ($query) use ($provinceId) {
                $query->whereHas('province', function ($query) use ($provinceId) {
                    $query->where('province_id', $provinceId);
                });
            });
        }

        $totalCount = $totalQuery->count();

        // Calculate the total count of the top industries
        $topIndustryCount = $topIndustries->sum('total_count');

        // Calculate "Others" count
        $otherCount = $totalCount - $topIndustryCount;

        // Prepare data for the donut chart
        $donutChartModel = LivewireCharts::pieChartModel()
            ->setAnimated(true)
            ->asDonut()
            ->setDataLabelsEnabled(true)
            ->setJsonConfig([
                'chart' => [
                    'type' => 'donut',
                    'height' => '300px',
                ],
                'plotOptions' => [
                    'pie' => [
                        'donut' => [
                            'size' => '40%',
                        ],
                    ],
                ],
                'dataLabels' => [
                    'enabled' => true,
                ],
                'legend' => [
                    'show' => true,
                ],
            ]);

        // Add slices to the chart
        foreach ($topIndustries as $industry) {
            $donutChartModel->addSlice($industry->industry_Title, $industry->total_count, '#' . substr(md5(rand()), 0, 6)); // Generate random color for each slice
        }

        // Add "Others" category to the chart if there are any
        if ($otherCount > 0) {
            $donutChartModel->addSlice('Others', $otherCount, '#' . substr(md5(rand()), 0, 6)); // Generate random color for "Others"
        }

        return $donutChartModel;
    }

    public function render()
    {

        $topJobIndustries = null;


        if ($this->municipalityID) {
            $topJobIndustries = $this->getTopJobIndustriesDonut($this->municipalityID);

        } elseif ($this->provinceID) {
            $topJobIndustries = $this->getTopJobIndustriesDonut(null, $this->provinceID);

        }

        return view('livewire.admin.reports.municipality-partials.top-job-industry', compact('topJobIndustries'));
    }
}
