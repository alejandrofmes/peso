<?php

namespace App\Livewire\Admin\Reports\BarangayPartials;

use App\Models\Job_Preference;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class JobTagsColumn extends Component
{

    public $barangayID;

    public $filter = 'All';

    #[On('updateBar')]
    public function updateBar($id)
    {
        $this->barangayID = $id;
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

    private function createJobTagsChart()
    {
        $topJobPreferences = Job_Preference::select('position_id', DB::raw('COUNT(*) as total_count'))
            ->whereHas('employee', function ($query) {
                $query->whereHas('barangay', function ($query) {
                    $query->where('barangay_id', $this->barangayID);
                });
                // Add the filter for empStatus based on the "filter" variable
                if ($this->filter === 'Employed') {
                    $query->where('empStatus', 1); // empStatus = 1 for Employed
                } elseif ($this->filter === 'Unemployed') {
                    $query->where('empStatus', 2); // empStatus = 2 for Unemployed
                }
            })
            ->groupBy('position_id')
            ->orderByDesc('total_count')
            ->limit(5)
            ->get();

        $chart = new ColumnChartModel();
        $chart->setTitle('JOB TAGS');

        foreach ($topJobPreferences as $preference) {
            $positionTitle = $preference->job_positions->position_Title ?? 'Unknown';
            $chart->addColumn($positionTitle, $preference->total_count, '#' . substr(md5(rand()), 0, 6));
        }

        return $chart->setAnimated(true)
            ->setYAxisVisible(true)
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
            ]);
    }
    public function render()
    {

        $prefJobTags = $this->createJobTagsChart();

        return view('livewire.admin.reports.barangay-partials.job-tags-column', compact('prefJobTags'));
    }
}
