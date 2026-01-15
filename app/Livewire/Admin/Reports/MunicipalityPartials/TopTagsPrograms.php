<?php

namespace App\Livewire\Admin\Reports\MunicipalityPartials;

use App\Models\Program_Tags;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TopTagsPrograms extends Component
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

        $this->dispatch('close-modal', 'filter-trainings-tags-modal');
    }

    private function getTopProgramTags($id = null, $provinceId = null)
    {
        // Start building the query
        $query = Program_Tags::select('job_positions.position_Title', DB::raw('COUNT(program_reg.program_reg_id) as total_count'))
            ->join('programs', 'program_tags.program_id', '=', 'programs.program_id')
            ->join('program_reg', 'program_reg.program_id', '=', 'programs.program_id')
            ->join('job_positions', 'program_tags.position_id', '=', 'job_positions.position_id')
            ->join('peso', 'programs.peso_id', '=', 'peso.peso_id');
    
        // Conditionally add joins based on the presence of provinceId
        if ($provinceId) {
            $query->join('municipality', 'peso.municipality_id', '=', 'municipality.municipality_id')
                  ->join('province', 'municipality.province_id', '=', 'province.province_id'); // Join province table
        } else {
            $query->join('municipality', 'peso.municipality_id', '=', 'municipality.municipality_id'); // Just use municipality
        }
    
        // Apply filtering based on provided ID or province ID
        $query->where(function ($query) use ($id, $provinceId) {
            if ($id) {
                $query->where('municipality.municipality_id', $id); // Filter by municipality_id
            } elseif ($provinceId) {
                $query->where('province.province_id', $provinceId); // Filter by province_id
            }
        })
        ->groupBy('job_positions.position_Title')
        ->orderBy('total_count', 'desc')
        ->limit(5);
    
        // Apply year filter if provided
        if (!empty($this->selectedYear)) {
            $query->whereYear('programs.created_at', $this->selectedYear);
        }
    
        // Apply month filter if provided
        if (!empty($this->selectedMonths) && is_array($this->selectedMonths)) {
            $query->whereIn(DB::raw('MONTH(programs.created_at)'), $this->selectedMonths);
        }
    
        return $query->get();
    }
    

    public function createProgramTagsChart($id = null, $provinceId = null)
    {
        $topProgramTags = $this->getTopProgramTags($id, $provinceId);

        $columnChartModel = new ColumnChartModel();

        foreach ($topProgramTags as $tag) {
            $columnChartModel->addColumn($tag->position_Title, $tag->total_count, '#' . substr(md5(rand()), 0, 6));
        }

        // Optionally customize chart properties
        $columnChartModel
            ->setAnimated(true)
            ->setXAxisVisible(true)
            ->setDataLabelsEnabled(true)
            ->setLegendVisibility(true)
            ->setColumnWidth(50)
            ->setJsonConfig([
                'chart' => [
                    'width' => '100%',
                    'height' => '300px',
                ],
                'yaxis.tickAmount' => 1,
                'yaxis.labels.formatter' => '(val) => Math.floor(val)',
                'xaxis.labels.show' => false,
                'legend' => [
                    'position' => 'top', // 'top', 'bottom', 'left', 'right'
                    'horizontalAlign' => 'center', // Align horizontally at the center
                    'verticalAlign' => 'middle', // Align vertically at the middle
                    'fontSize' => '14px', // Font size
                    'fontFamily' => 'Helvetica, Arial, sans-serif', // Font family
                    'fontWeight' => 'normal', // Font weight (normal, bold, etc.)
                    'labels' => [
                        'colors' => '#333333', // Legend text color
                        'useSeriesColors' => true, // Use series colors for legend labels
                        'formatter' => '(val) => val.toUpperCase()', // Formatter function to modify label text
                    ],
                ],
            ]); // Adjust column width as needed

        return $columnChartModel;
    }

    public function render()
    {
        $programTagsChart = null;

        if ($this->municipalityID) {
            $programTagsChart = $this->createProgramTagsChart($this->municipalityID);

        } elseif ($this->provinceID) {
            $programTagsChart = $this->createProgramTagsChart(null, $this->provinceID);

        }

        return view('livewire.admin.reports.municipality-partials.top-tags-programs', compact('programTagsChart'));
    }
}
