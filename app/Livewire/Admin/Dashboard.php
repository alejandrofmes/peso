<?php

namespace App\Livewire\Admin;

use App\Models\Employee;
use App\Models\Job_Applicants;
use App\Models\Job_Industry;
use App\Models\Job_Posting;
use App\Models\Job_Preference;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    protected $listeners = ['qrCodeScanned' => 'qrCodeScanned', 'scanQRCode' => 'addQRProduct'];

    public function getTopJobTags($municipalityId)
    {
        // Fetch employees with job preferences and job positions
        $employees = Employee::whereHas('barangay', function ($query) use ($municipalityId) {
            $query->where('municipality_id', $municipalityId);
        })
            ->with(['job_preference.job_positions']) // Eager load job_preference and job_positions
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

                ],
                'yaxis.tickAmount' => 1,
                'yaxis.labels.formatter' => '(val) => Math.floor(val)',
                'xaxis.labels.show' => false,
            ]);
        // dd($columnChartModel);
        return $columnChartModel;
    }

    public function getTopIndustries($municipalityId)
    {
        // Fetch employees with industry preferences and job industries
        $employees = Employee::whereHas('barangay', function ($query) use ($municipalityId) {
            $query->where('municipality_id', $municipalityId);
        })
            ->with(['industry_preference.job_industry']) // Ensure the relationships are correct
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
                    'height' => '450px', // Specify the height for the chart
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
                // 'legend' => [
                //     'position' => 'bottom', // Legend position
                //     'horizontalAlign' => 'center', // Horizontal alignment of legend
                //     'verticalAlign' => 'middle', // Vertical alignment of legend
                //     'fontSize' => '14px', // Font size for legend
                //     'fontFamily' => 'Helvetica, Arial, sans-serif', // Font family for legend
                //     'fontWeight' => 'normal', // Font weight for legend
                //     'labels' => [
                //         'colors' => '#333333', // Legend text color
                //         'useSeriesColors' => true, // Use series colors for legend labels
                //         'formatter' => '(val) => val.toUpperCase()', // Formatter function for legend labels
                //     ],
                //     'markers' => [
                //         'width' => 10, // Width of legend markers
                //         'height' => 10, // Height of legend markers
                //         'strokeWidth' => 0, // Stroke width of markers
                //         'strokeColor' => '#000000', // Stroke color of markers
                //         'fillColors' => ['#FFFFFF'], // Fill color for markers
                //     ],
                // ],
            ]);

        return $pieChartModel;
    }

    public function render()
    {
        $user = Auth::user(); // Fetch the current authenticated user

        // Get the current user's municipality ID from PESO relation
        $pesoMunicipalityId = optional($user->peso_accounts)->peso->municipality_id;

        // Fetch totals and recent counts
        $jobPostings = Job_Posting::selectRaw('
            COUNT(*) AS total_job_postings,
            SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) AS recent_job_postings
        ', [Carbon::now()->subHours(24)])
            ->whereHas('peso.municipality', function ($query) use ($pesoMunicipalityId) {
                $query->where('municipality_id', $pesoMunicipalityId);
            })
            ->first();

        $employees = Employee::selectRaw('
            COUNT(*) AS total_job_seekers,
            SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) AS recent_job_seekers,
            SUM(CASE WHEN empstatus = 1 THEN 1 ELSE 0 END) AS total_employed,
            SUM(CASE WHEN empstatus = 2 THEN 1 ELSE 0 END) AS total_unemployed
        ', [Carbon::now()->subHours(24)])
            ->whereHas('barangay.municipality', function ($query) use ($pesoMunicipalityId) {
                $query->where('municipality_id', $pesoMunicipalityId);
            })
            ->first();

        $activeApplicants = Job_Applicants::selectRaw('
            COUNT(*) AS total_active_applicants,
            SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) AS recent_active_applicants
        ', [Carbon::now()->subHours(24)])
            ->whereNotIn('applicant_Status', ['REJECTED', 'ACCEPTED', 'CANCELLED'])
            ->whereHas('job_posting.peso.municipality', function ($query) use ($pesoMunicipalityId) {
                $query->where('municipality_id', $pesoMunicipalityId);
            })
            ->first();

        $recentJobPost = Job_Posting::whereHas('peso.municipality', function ($query) use ($pesoMunicipalityId) {
            $query->where('municipality_id', $pesoMunicipalityId);
        })
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $recentApplicants = Job_Applicants::with('job_posting')
            ->whereHas('job_posting.peso.municipality', function ($query) use ($pesoMunicipalityId) {
                $query->where('municipality_id', $pesoMunicipalityId);
            })
            ->where('peso_Status', 'PENDING')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Generate chart models
        $columnChartModel = $this->getTopJobTags($pesoMunicipalityId);
        $pieChartModel = $this->getTopIndustries($pesoMunicipalityId);

        return view('livewire.admin.dashboard', [
            'totalJobPostings' => $jobPostings->total_job_postings,
            'recentJobPostings' => $jobPostings->recent_job_postings,
            'totalJobSeekers' => $employees->total_job_seekers,
            'recentJobSeekers' => $employees->recent_job_seekers,
            'totalEmployed' => $employees->total_employed,
            'totalUnemployed' => $employees->total_unemployed,
            'totalActiveApplicants' => $activeApplicants->total_active_applicants,
            'recentActiveApplicants' => $activeApplicants->recent_active_applicants,
            'recentJobPost' => $recentJobPost,
            'recentApplicants' => $recentApplicants,
            'columnChartModel' => $columnChartModel,
            'pieChartModel' => $pieChartModel,
        ]);
    }

}
