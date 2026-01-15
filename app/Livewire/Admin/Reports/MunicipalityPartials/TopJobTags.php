<?php

namespace App\Livewire\Admin\Reports\MunicipalityPartials;

use App\Models\Job_Posting;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Attributes\On;
use Livewire\Component;

class TopJobTags extends Component
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

    public function getTopJobTags($municipalityId = null, $provinceId = null)
    {
        // Fetch job postings with job tags and job positions
        $jobPostings = Job_Posting::with(['job_tags.job_positions'])
            ->where('job_Status', 'ACTIVE')
            ->when($municipalityId, function ($query) use ($municipalityId) {
                $query->whereHas('peso.municipality', function ($subQuery) use ($municipalityId) {
                    $subQuery->where('municipality_id', $municipalityId);
                });
            })
            ->when(!$municipalityId && $provinceId, function ($query) use ($provinceId) {
                $query->whereHas('peso.municipality', function ($subQuery) use ($provinceId) {
                    $subQuery->whereHas('province', function ($subQuery) use ($provinceId) {
                        $subQuery->where('province_id', $provinceId);
                    });
                });
            })
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
        // $columnChartModel->setTitle('Top Job Tags for Active Postings');

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

        $topJobCharts = null;

        if ($this->municipalityID) {
            $topJobCharts = $this->getTopJobTags($this->municipalityID);

        } elseif ($this->provinceID) {
            $topJobCharts = $this->getTopJobTags(null, $this->provinceID);

        }

        return view('livewire.admin.reports.municipality-partials.top-job-tags', compact('topJobCharts'));
    }
}
