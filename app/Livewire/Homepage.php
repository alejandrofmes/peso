<?php

namespace App\Livewire;

use App\Models\Announcements;
use App\Models\Job_Industry;
use App\Models\Job_Positions;
use App\Models\Job_Posting;
use App\Models\Partnerships;
use App\Models\Programs;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;

class Homepage extends Component
{

    public function getTopJobOpenings()
    {

        $jobPositions = Job_Positions::whereHas('job_tags.job_posting', function ($query) {
            // Ensure job postings are ACTIVE
            $query->where('job_Status', 'ACTIVE');
        })
        // Count active job postings associated with each position
            ->withCount(['job_tags as active_job_posting_count' => function ($query) {
                $query->whereHas('job_posting', function ($subQuery) {
                    $subQuery->where('job_Status', 'ACTIVE'); // Count only active postings

                });
            }])
            ->orderBy('active_job_posting_count', 'desc') // Order by count of active job postings
            ->take(5) // Limit to top 5 positions
            ->get();

        // Prepare data for the column chart
        $columnChartModel = new ColumnChartModel();
        // $columnChartModel->setTitle('Top Job Tags for Municipality ID ' . $municipalityId);

        foreach ($jobPositions as $tagName) {
            $columnChartModel->addColumn($tagName->position_Title, $tagName->active_job_posting_count, '#' . substr(md5(rand()), 0, 6)); // Generate random color for each column
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

                ],
                'yaxis.tickAmount' => 1,
                'yaxis.labels.formatter' => '(val) => Math.floor(val)',
                'xaxis.labels.show' => false,
            ]);
        // dd($columnChartModel);
        return $columnChartModel;
    }

    public function getEmployerTrends()
    {

        $jobIndustry = Job_Industry::whereHas('job_posting.job_industry', function ($query) {
            // Filter to ensure we're only considering relevant postings
            $query->whereIn('job_Status', ['ACTIVE', 'CLOSED', 'COMPLETED']);
        })
            ->withCount(['job_posting as posted_industry_count' => function ($query) {
                // Count only postings with statuses we care about
                $query->whereIn('job_Status', ['ACTIVE', 'CLOSED', 'COMPLETED']);
            }])
            ->orderBy('posted_industry_count', 'desc') // Order by count of postings
            ->take(5) // Limit to top 5 positions
            ->get();

        // Prepare data for the column chart
        $columnChartModel = new ColumnChartModel();
        // $columnChartModel->setTitle('Top Job Tags for Municipality ID ' . $municipalityId);

        foreach ($jobIndustry as $industryName) {
            $columnChartModel->addColumn($industryName->industry_Title, $industryName->posted_industry_count, '#' . substr(md5(rand()), 0, 6)); // Generate random color for each column
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

                ],
                'yaxis.tickAmount' => 1,
                'yaxis.labels.formatter' => '(val) => Math.floor(val)',
                'xaxis.labels.show' => false,
                'legend' => [
                    'show' => true,
                    'position' => 'bottom', // Options: 'top', 'bottom', 'left', 'right'
                    'horizontalAlign' => 'center', // Options: 'left', 'center', 'right'
                    'floating' => false,
                    'fontSize' => '12px', // Customize font size
                    'itemMargin' => [
                        'horizontal' => 9, // Horizontal spacing
                        'vertical' => 5, // Vertical spacing
                    ],
                ],
            ]);
        // dd($columnChartModel);
        return $columnChartModel;
    }

    public function render()
    {
        $announ = Announcements::orderBy('created_at', 'desc')
            ->where('announcement_Status', 'ACTIVE')
            ->limit(5)
            ->get();

        $chartn = $this->getTopJobOpenings();
        $employmentTrend = $this->getEmployerTrends();

        $openjobs = Job_Posting::where('job_Status', 'ACTIVE')->count();
        $opentrainings = Programs::where('program_Status', 'ACTIVE')->count();
        $partners = Partnerships::where('partnership_Status', 'APPROVED')
            ->distinct('company_id')
            ->count('company_id');

        return view('livewire.homepage', compact('announ', 'chartn', 'employmentTrend', 'openjobs', 'opentrainings', 'partners'));
    }
}
