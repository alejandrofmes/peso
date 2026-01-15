<?php

namespace App\Livewire\Admin\Super\DashboardPartials;

use App\Models\Employee;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;

class JobTagsCol extends Component
{

    public function getTopJobTags()
    {
        // Fetch employees with job preferences and job positions
        $employees = Employee::with(['job_preference.job_positions']) // Eager load job_preference and job_positions
            ->get();

        $tagCounts = $employees->flatMap(function ($employee) {
            return $employee->job_preference->map(function ($jobPreference) {
                return $jobPreference->job_positions->position_Title ?? 'Unknown';
            });
        })->countBy();

        // Get top 5 tags
        $topJobTags = $tagCounts->sortDesc()->take(5);

        // Prepare data for the column chart
        $columnChartModel = new ColumnChartModel();
        // $columnChartModel->setTitle('Top Job Tags for Municipality ID ' . $municipalityId);

        foreach ($topJobTags as $tagName => $totalCount) {
            $columnChartModel->addColumn($tagName, $totalCount, '#' . substr(md5(rand()), 0, 6)); // Generate random color for each column
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
                    'height' => '400px',
                ],
                'yaxis.tickAmount' => 1,
                'yaxis.labels.formatter' => '(val) => Math.floor(val)',
                // 'xaxis.labels.show' => false,
            ]);
        // dd($columnChartModel);
        return $columnChartModel;
    }

    public function render()
    {

        $columnChartModel = $this->getTopJobTags();

        return view('livewire.admin.super.dashboard-partials.job-tags-col', compact('columnChartModel'));
    }
}
