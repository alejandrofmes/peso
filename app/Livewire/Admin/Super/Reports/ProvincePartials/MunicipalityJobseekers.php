<?php

namespace App\Livewire\Admin\Super\Reports\ProvincePartials;

use App\Models\Municipality;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Livewire\Attributes\On;
use Livewire\Component;

class MunicipalityJobseekers extends Component
{
    public $provinceID;

    #[On('updateProv')]
    public function updateProv($id)
    {
        $this->provinceID = $id;
    }

    public function getMunicipalityChart($provinceId)
    {
        // Get employee counts per municipality
        $municipalities = Municipality::where('province_id', $provinceId)
            ->with(['barangay.employee']) // Load the barangay and its employees
            ->get()
            ->map(function ($municipality) {
                // Count the employees related to the barangays of this municipality
                $employeeCount = $municipality->barangay->flatMap(function ($barangay) {
                    return $barangay->employee;
                })->count();

                // Add employee count as a new attribute
                $municipality->employee_count = $employeeCount;
                return $municipality;
            });
            

        // Create a pie chart model
        $municipalityChartModel = new PieChartModel();

        // Add slices only for municipalities with employees
        foreach ($municipalities as $municipality) {
            if ($municipality->employee_count > 0) {
                $randomColor = '#' . substr(md5(rand()), 0, 6);

                $municipalityChartModel->addSlice(
                    $municipality->municipality_Name,
                    $municipality->employee_count,
                    $randomColor
                );
            }
        }

        // Set chart properties
        $municipalityChartModel->setTitle('Number of Job Seekers per Municipality')
            ->setAnimated(true)
            ->setType('pie')
            ->withOnSliceClickEvent('onSliceClick')
            ->withoutLegend()
            ->setDataLabelsEnabled(true)
            ->setJsonConfig([
                'chart' => [
                    'width' => '100%',
                    'height' => '300px',
                ],
                'plotOptions' => [
                    'pie' => [
                        'dataLabels' => [
                            'offset' => -15,
                            'style' => [
                                'fontSize' => '16px',
                                'fontFamily' => 'Helvetica, Arial, sans-serif',
                                'fontWeight' => 'bold',
                                'colors' => ['#FFFFFF'],
                                'textAlign' => 'center',
                            ],
                        ],
                    ],
                ],
                'dataLabels' => [
                    'style' => [
                        'fontSize' => '16px',
                        'fontWeight' => 'bold',
                    ],
                    'dropShadow' => [
                        'enabled' => true,
                        'top' => 1,
                        'left' => 1,
                        'blur' => 1,
                        'color' => '#000000',
                        'opacity' => 0.5,
                    ],
                ],
            ]);

        return $municipalityChartModel;
    }

    public function render()
    {
        $municipalityChartModel = $this->getMunicipalityChart($this->provinceID);
        return view('livewire.admin.super.reports.province-partials.municipality-jobseekers', compact('municipalityChartModel'));
    }
}
