<?php

namespace App\Livewire\Admin\Reports\MunicipalityPartials;

use App\Models\Barangay;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Livewire\Attributes\On;
use Livewire\Component;

class BarangayJobseekers extends Component
{
    public $municipalityID;

    #[On('updateMun')]
    public function updateMun($id)
    {
        $this->municipalityID = $id;
    }

    public function getBarangayChart($id)
    {
        $barangays = Barangay::where('municipality_id', $id)
            ->withCount('employee') // Ensure this relationship exists
            ->get();

        // Calculate the total count of residents across all barangays
        $totalResidents = $barangays->sum('employee_count');

        // Create a pie chart model
        $barangayChartModel = new PieChartModel();

        // Add each barangay to the pie chart
        // foreach ($barangays as $barangay) {
        //     $barangayChartModel->addSlice(
        //         $barangay->barangay_Name,
        //         $barangay->employee_count,
        //         $this->colors[$barangay->barangay_id] ?? '#' . substr(md5(rand()), 0, 6) // Use a default color if not set
        //     );
        // }
        foreach ($barangays as $barangay) {
            // Generate a random color for each barangay
            $randomColor = '#' . substr(md5(rand()), 0, 6);

            $barangayChartModel->addSlice(
                $barangay->barangay_Name,
                $barangay->employee_count,
                $randomColor // Use the random color for each barangay
            );
        }

        // Optionally add a slice for 'Others' if there are remaining residents
        // if ($totalResidents > 0) {
        //     $otherCount = 0; // You can define logic for counting 'Others' if needed
        //     if ($otherCount > 0) {
        //         $barangayChartModel->addSlice('Others', $otherCount, '#' . substr(md5(rand()), 0, 6));
        //     }
        // }

        if ($totalResidents > 0) {
            $otherCount = 0; // You can define logic for counting 'Others' if needed
            if ($otherCount > 0) {
                $barangayChartModel->addSlice('Others', $otherCount, '#' . substr(md5(rand()), 0, 6)); // Random color for 'Others'
            }
        }

        $barangayChartModel->setTitle('Number of Job Seekers per Barangay')
            ->setAnimated(true)
            ->setType('pie')
            ->withOnSliceClickEvent('onSliceClick')
            ->withoutLegend()
            ->setDataLabelsEnabled(true)

            ->setJsonConfig([
                'chart' => [
                    'width' => '100%', // Set to 100% or specify a pixel value like 400, 500, etc.
                    'height' => '300px', // Specify the height for the chart
                ],
                'plotOptions' => [
                    'pie' => [
                        'dataLabels' => [
                            'offset' => -15, // Adjust this to center the labels vertically
                            'style' => [
                                'fontSize' => '16px', // Corrected from '16x' to '16px'
                                'fontFamily' => 'Helvetica, Arial, sans-serif',
                                'fontWeight' => 'bold',
                                'colors' => ['#FFFFFF'], // Set text color
                                'textAlign' => 'center', // Align text in the center of each slice
                            ],
                        ],
                    ],
                ],
                'dataLabels' => [
                    'style' => [
                        'fontSize' => '16px', // Adjust font size for data labels
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

        return $barangayChartModel;
    }
    public function render()
    {
        $barangayChartModel = $this->getBarangayChart($this->municipalityID);

        return view('livewire.admin.reports.municipality-partials.barangay-jobseekers', compact('barangayChartModel'));
    }
}
