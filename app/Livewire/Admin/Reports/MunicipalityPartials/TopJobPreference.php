<?php

namespace App\Livewire\Admin\Reports\MunicipalityPartials;

use App\Models\Job_Preference;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TopJobPreference extends Component
{
    public $municipalityID;

    public $provinceID;

    public $filter = 'All';

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

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

    public function getTopJobPreferences($municipalityId = null, $provinceId = null)
    {
        $query = Job_Preference::select('position_id', DB::raw('COUNT(*) as total_count'))
            ->whereHas('employee', function ($query) use ($municipalityId, $provinceId) {
                $query->whereHas('barangay', function ($query) use ($municipalityId, $provinceId) {
                    if ($municipalityId) {
                        $query->where('municipality_id', $municipalityId);
                    } elseif ($provinceId) {
                        $query->whereHas('municipality', function ($query) use ($provinceId) {
                            $query->where('province_id', $provinceId);
                        });
                    }
                });
                if ($this->filter === 'Employed') {
                    $query->where('empStatus', 1); // empStatus = 1 for Employed
                } elseif ($this->filter === 'Unemployed') {
                    $query->where('empStatus', 2); // empStatus = 2 for Unemployed
                }
            })
            ->with('job_positions') // Eager load job_positions relationship
            ->groupBy('position_id')
            ->orderByDesc('total_count')
            ->limit(5)
            ->get();

        // Prepare data for the column chart
        $columnChartModel = new ColumnChartModel();
        // $columnChartModel->setTitle('Top Job Preferences');

        foreach ($query as $jobPreference) {
            // Add each job preference as a column in the chart
            $positionTitle = $jobPreference->job_positions->position_Title ?? 'Unknown'; // Get position_Title, fallback to 'Unknown'
            $totalCount = $jobPreference->total_count;

            $columnChartModel->addColumn($positionTitle, $totalCount, '#' . substr(md5(rand()), 0, 6)); // Generate random color for each column
        }

        // Optionally customize chart properties
        $columnChartModel
            ->setAnimated(true)
            ->setYAxisVisible(false)
            ->setDataLabelsEnabled(true)
            ->setLegendVisibility(true)
            ->setJsonConfig([
                'chart' => [
                    'width' => '100%',
                    'height' => '300px',
                ],
                'yaxis.tickAmount' => 1,
                'yaxis.labels.formatter' => '(val) => Math.floor(val)',
                'xaxis.labels.show' => false,
            ]); // Adjust column width as needed

        return $columnChartModel;
    }

    public function render()
    {

        $topJobPreference = null;

        if ($this->municipalityID) {
            $topJobPreference = $this->getTopJobPreferences($this->municipalityID);

        } elseif ($this->provinceID) {
            $topJobPreference = $this->getTopJobPreferences(null, $this->provinceID);

        }

        return view('livewire.admin.reports.municipality-partials.top-job-preference', compact('topJobPreference'));
    }
}
