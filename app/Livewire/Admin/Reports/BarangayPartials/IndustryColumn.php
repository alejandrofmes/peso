<?php

namespace App\Livewire\Admin\Reports\BarangayPartials;

use App\Models\Industry_preference;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class IndustryColumn extends Component
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

    private function createIndustriesChart()
    {
        $topJobIndustries = Industry_preference::select('industry_id', DB::raw('COUNT(*) as total_count'))
            ->whereHas('employee', function ($query) {
                $query->whereHas('barangay', function ($query) {
                    $query->where('barangay_id', $this->barangayID);
                });
                if ($this->filter === 'Employed') {
                    $query->where('empStatus', 1); // empStatus = 1 for Employed
                } elseif ($this->filter === 'Unemployed') {
                    $query->where('empStatus', 2); // empStatus = 2 for Unemployed
                }
            })
            ->groupBy('industry_id')
            ->orderByDesc('total_count')
            ->limit(5)
            ->get();

        $chart = new ColumnChartModel();
        $chart->setTitle('INDUSTRIES');

        foreach ($topJobIndustries as $industry) {
            $industryTitle = $industry->job_industry->industry_Title ?? 'Unknown';
            $chart->addColumn($industryTitle, $industry->total_count, '#' . substr(md5(rand()), 0, 6));
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
        $industries_chart = $this->createIndustriesChart();
        return view('livewire.admin.reports.barangay-partials.industry-column', compact('industries_chart'));
    }
}
