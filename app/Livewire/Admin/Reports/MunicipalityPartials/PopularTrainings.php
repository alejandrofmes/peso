<?php

namespace App\Livewire\Admin\Reports\MunicipalityPartials;

use App\Models\PESO;
use App\Models\Programs;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;

class PopularTrainings extends Component
{

    public $municipalityID;
    public $startYear, $currentYear;

    public $selectedMonths = [], $selectedYear;
    public $mountSelectedMonths = [], $mountSelectedYear;

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

        $this->dispatch('close-modal', 'filter-trainings-modal');
    }

    private function getTopPrograms($municipalityId = null, $provinceId = null)
    {
        return Programs::withCount(['program_reg as registration_count' => function ($query) use ($municipalityId, $provinceId) {
            // Apply filter based on municipality or province
            $query->whereHas('employee.barangay', function ($query) use ($municipalityId, $provinceId) {
                if ($municipalityId) {
                    // Filter by municipality if provided
                    $query->where('municipality_id', $municipalityId);
                } elseif ($provinceId) {
                    // Otherwise, filter by all municipalities within the province
                    $query->whereHas('municipality', function ($query) use ($provinceId) {
                        $query->where('province_id', $provinceId);
                    });
                }
            });
        }])
            ->when($this->selectedYear, function ($query) {
                // Filter by year if provided
                $query->whereYear('created_at', $this->selectedYear);
            })
            ->when(!empty($this->mountSelectedMonths), function ($query) {
                // Filter by months if provided
                $query->whereIn(DB::raw('MONTH(created_at)'), $this->mountSelectedMonths);
            })
            ->having('registration_count', '>', 0) // Ensure registration count is greater than zero
            ->orderBy('registration_count', 'desc')
            ->limit(5)
            ->get();
    }

    public function exportExcel()
    {
        $topPrograms = null;

        if ($this->municipalityID) {
            $topPrograms = $this->getTopPrograms($this->municipalityID);

        } elseif ($this->provinceID) {
            $topPrograms = $this->getTopPrograms(null, $this->provinceID);

        }

        if (!$topPrograms->isEmpty()) {

            $fileName = 'Top_Programs-' . now()->format('Y-m-d-H-i-s') . '.xlsx';

            $writer = SimpleExcelWriter::streamDownload($fileName);

            foreach ($topPrograms as $data) {
                $writer->addRow([
                    'Program Title' => $data->program_Title,
                    'Host' => $data->program_Host,
                    'Type' => $data->program_Type,
                    'Date Posted' => $data->created_at->format('F j, Y'),
                    'Deadline' => $data->program_Deadline->format('F j, Y'),
                    'Event Time' => $data->program_Datetime ? $data->program_Datetime->format('F j, Y g:i A') : null,
                    'Status' => $data->program_Status,
                    'Registrants' => $data->registration_count,
                    'Total Slots' => $data->program_Slots,
                ]);
            }

            toastr()->success('Data Exported');
            return Response::streamDownload(function () use ($writer) {
                $writer->close();
            }, $fileName, ['Content-Type' => 'text/csv']);
        }

        return toastr()->warning('No data in the table to be exported.');

    }
    public function exportPdf()
    {
        $topPrograms = null;
        $pesoInformation = [];

        if ($this->municipalityID) {
            $topPrograms = $this->getTopPrograms($this->municipalityID);
            $pesoBranch = PESO::where('municipality_id', $this->municipalityID)->first();
            $pesoInformation = [
                'pesoMunicipality' => $pesoBranch->municipality->municipality_Name,
                'pesoProvince' => $pesoBranch->municipality->province->province_Name,
                'pesoEmail' => $pesoBranch->peso_Email,
                'pesoPhone' => $pesoBranch->peso_Phone,
                'pesoTel' => $pesoBranch->peso_Tel,
                'pesoFax' => $pesoBranch->peso_Fax,
            ];

        } elseif ($this->provinceID) {
            $topPrograms = $this->getTopPrograms(null, $this->provinceID);
            $province = Province::findOrFail($this->provinceID);
            $pesoInformation = [
                'pesoMunicipality' => '',
                'pesoProvince' => $province->province_Name,
                'pesoEmail' => '',
                'pesoPhone' => '',
                'pesoTel' => '',
                'pesoFax' => '',
            ];

        }

        if (!$topPrograms->isEmpty()) {

            $fileName = 'Top_Programs-' . now()->format('Y-m-d-H-i-s') . '.pdf';


            $programs = $topPrograms->map(function ($data) {
                return [
                    'programTitle' => $data->program_Title,
                    'programHost' => $data->program_Host,
                    'programType' => $data->program_Type,
                    'datePosted' => $data->created_at->format('F j, Y'),
                    'registrantsCount' => $data->registration_count,
                ];
            });

            // Combine both datasets
            $data = [
                'programs' => $programs,
                'peso' => $pesoInformation,
                'fileName' => $fileName,

            ];

            $encryptedData = Crypt::encryptString(json_encode($data));

            return redirect()->route('export.programs', ['data' => $encryptedData]);
        }

        return toastr()->warning('No data in the table to be exported.');

    }

    public function render()
    {

        $topPrograms = null;

        if ($this->municipalityID) {
            $topPrograms = $this->getTopPrograms($this->municipalityID);

        } elseif ($this->provinceID) {
            $topPrograms = $this->getTopPrograms(null, $this->provinceID);

        }

        return view('livewire.admin.reports.municipality-partials.popular-trainings', compact('topPrograms'));
    }
}
