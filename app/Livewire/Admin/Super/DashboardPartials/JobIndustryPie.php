<?php

namespace App\Livewire\Admin\Super\DashboardPartials;

use App\Models\Employee;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Livewire\Component;

class JobIndustryPie extends Component
{

    public function getTopIndustries()
    {
        // Fetch employees with industry preferences and job industries
        $employees = Employee::with(['industry_preference.job_industry']) // Ensure the relationships are correct
            ->get();

        // Count industry titles
        $tagCounts = $employees->flatMap(function ($employee) {
            return $employee->industry_preference->map(function ($industryPreference) {
                return $industryPreference->job_industry->industry_Title ?? 'Unknown';
            });
        })->countBy();

        // Get top 5 industries
        $topIndustries = $tagCounts->sortDesc()->take(5);

        // Initialize the pie chart model
        $pieChartModel = new PieChartModel();

        foreach ($topIndustries as $industryName => $totalCount) {
            $pieChartModel->addSlice($industryName, $totalCount, '#' . substr(md5(rand()), 0, 6)); // Generate random color for each slice
        }

        // Customize the pie chart model
        $pieChartModel
            ->setAnimated(true)
            ->setType('pie')
            ->withOnSliceClickEvent('onSliceClick')
            ->legendPositionBottom()
            ->legendHorizontallyAlignedCenter()
            ->setDataLabelsEnabled(true)
            ->setColors([
                '#' . substr(md5(rand()), 0, 6),
                '#' . substr(md5(rand()), 0, 6),
                '#' . substr(md5(rand()), 0, 6),
                '#' . substr(md5(rand()), 0, 6),
                '#' . substr(md5(rand()), 0, 6),
            ])
            ->setJsonConfig([
                'chart' => [
                    'width' => '100%', // Set to 100% or specify a pixel value like 400, 500, etc.
                    'height' => '400px', // Specify the height for the chart
                ],
                'plotOptions' => [
                    'pie' => [
                        'dataLabels' => [
                            'offset' => -15, // Adjust this to center the labels vertically
                            'style' => [
                                'fontSize' => '16px', // Font size
                                'fontFamily' => 'Helvetica, Arial, sans-serif',
                                'fontWeight' => 'bold',
                                'colors' => ['#FFFFFF'], // Text color
                                'textAlign' => 'center', // Align text in the center of each slice
                            ],
                        ],
                    ],
                ],
                'dataLabels' => [
                    'style' => [
                        'fontSize' => '16px', // Font size for data labels
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

        return $pieChartModel;
    }
    public function render()
    {

        $pieChartModel = $this->getTopIndustries();

        return view('livewire.admin.super.dashboard-partials.job-industry-pie', compact('pieChartModel'));
    }
}
