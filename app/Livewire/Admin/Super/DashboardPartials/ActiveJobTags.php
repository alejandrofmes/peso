<?php

namespace App\Livewire\Admin\Super\DashboardPartials;

use App\Models\Job_Posting;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;

class ActiveJobTags extends Component
{

    public function getTopJobTags()
    {
        // Fetch job postings with job tags and job positions
        $jobPostings = Job_Posting::with(['job_tags.job_positions'])
            ->where('job_Status', 'ACTIVE')
            ->get();

        // Count job tags
        $tagCounts = $jobPostings->flatMap(function ($jobPosting) {
            return $jobPosting->job_tags->map(function ($jobTag) {
                return $jobTag->job_positions->position_Title ?? 'Unknown';
            });
        })->countBy();

        // Get top 5 tags
        $topJobTags = $tagCounts->sortDesc()->take(5);

        // Prepare data for the column chart
        $columnChartModel = new ColumnChartModel();
        // $columnChartModel->setTitle('Top Job Tags for Active Postings in Municipality ID ' . $municipalityId);

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
        $topJobCharts = $this->getTopJobTags();

        return view('livewire.admin.super.dashboard-partials.active-job-tags', compact('topJobCharts'));
    }
}
