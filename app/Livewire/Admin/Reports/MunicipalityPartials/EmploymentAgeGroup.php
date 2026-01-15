<?php

namespace App\Livewire\Admin\Reports\MunicipalityPartials;

use App\Models\Employee;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class EmploymentAgeGroup extends Component
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
    public function getEmploymentByAgeGroup($municipalityId = null, $provinceId = null)
    {
        // Age groups
        $ageGroups = [
            '18-19' => [18, 19],
            '20-29' => [20, 29],
            '30-39' => [30, 39],
            '40-49' => [40, 49],
            '50-59' => [50, 59],
            '60-69' => [60, 69],
            '70+' => [70, 150], // Adjust the upper limit as needed
        ];
    
        $employedCounts = [];
        $unemployedCounts = [];
    
        foreach ($ageGroups as $label => $range) {
            [$minAge, $maxAge] = $range;
    
            // Base query for employed employees
            $employedQuery = Employee::whereBetween(DB::raw('TIMESTAMPDIFF(YEAR, birthdate, CURDATE())'), [$minAge, $maxAge])
                ->where('empStatus', 1);
    
            // Base query for unemployed employees
            $unemployedQuery = Employee::whereBetween(DB::raw('TIMESTAMPDIFF(YEAR, birthdate, CURDATE())'), [$minAge, $maxAge])
                ->where('empStatus', 2);
    
            // If municipalityId is provided, filter by municipality
            if ($municipalityId) {
                $employedQuery->whereHas('barangay', function ($query) use ($municipalityId) {
                    $query->where('municipality_id', $municipalityId);
                });
    
                $unemployedQuery->whereHas('barangay', function ($query) use ($municipalityId) {
                    $query->where('municipality_id', $municipalityId);
                });
            }
    
            // If provinceId is provided, filter by province
            if ($provinceId) {
                $employedQuery->whereHas('barangay.municipality', function ($query) use ($provinceId) {
                    $query->where('province_id', $provinceId);
                });
    
                $unemployedQuery->whereHas('barangay.municipality', function ($query) use ($provinceId) {
                    $query->where('province_id', $provinceId);
                });
            }
    
            // Count the number of employed and unemployed in the age group
            $employedCount = $employedQuery->count();
            $unemployedCount = $unemployedQuery->count();
    
            // Add the counts to the respective arrays
            $employedCounts[$label] = $employedCount;
            $unemployedCounts[$label] = $unemployedCount;
        }
    
        // Create column chart model
        $columnChartModel = LivewireCharts::multiColumnChartModel()
            ->setTitle('Employment by Age Group')
            ->setAnimated(true)
            ->setSmoothCurve()
            ->setXAxisVisible(true)
            ->setDataLabelsEnabled(true)
            ->setXAxisCategories(array_keys($ageGroups))
            ->setJsonConfig([
                'chart' => [
                    'width' => '100%',
                    'height' => '300px',
                ],
                'yaxis.tickAmount' => 1,
                'yaxis.labels.formatter' => '(val) => Math.floor(val)',
            ]);
    
        // Add employed data to the chart
        foreach ($employedCounts as $ageGroup => $count) {
            $columnChartModel->addSeriesColumn('Employed', $ageGroup, $count);
        }
    
        // Add unemployed data to the chart
        foreach ($unemployedCounts as $ageGroup => $count) {
            $columnChartModel->addSeriesColumn('Unemployed', $ageGroup, $count);
        }
    
        return $columnChartModel;
    }
    
    public function render()
    {

        $employmentAgeGroup = null;

        if($this->municipalityID){
            $employmentAgeGroup = $this->getEmploymentByAgeGroup($this->municipalityID);

        }elseif($this->provinceID){
            $employmentAgeGroup = $this->getEmploymentByAgeGroup(null, $this->provinceID);

        }

        return view('livewire.admin.reports.municipality-partials.employment-age-group', compact('employmentAgeGroup'));
    }
}
