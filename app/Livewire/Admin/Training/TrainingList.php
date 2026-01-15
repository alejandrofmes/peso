<?php

namespace App\Livewire\Admin\Training;

use App\Models\Programs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\SimpleExcel\SimpleExcelWriter;

#[Layout('layouts.admin')]
class TrainingList extends Component
{

    use WithPagination, WithoutUrlPagination;
    public $search;

    public $rows = 10;

    public $filter, $sortType, $sortDate;

    public function updatedsearch()
    {
        $this->resetPage();
    }

    public function updateFilter($filter)
    {
        $this->filter = $filter;
        $this->reset('sortType', 'sortDate', 'search');
    }

    public function updateSort($value, $type)
    {

        if ($type == 1) {
            $this->sortType = $value;
        } else if ($type == 2) {
            $this->sortDate = $value;
        }
        $this->reset('search');

    }

    public function exportExcel()
    {
        $user = Auth::user();

        $programList = $this->getProgramList($user->peso_accounts->peso->municipality_id)->get();

        if (!$programList->isEmpty()) {

            $fileName = 'training_list-' . now()->format('Y-m-d-H-i-s') . '.xlsx';

            $writer = SimpleExcelWriter::streamDownload($fileName);

            foreach ($programList as $data) {
                $writer->addRow([
                    'Program Title' => $data->program_Title,
                    'Host' => $data->program_Host,
                    'Type' => $data->program_Type,
                    'Date Posted' => $data->created_at->format('F j, Y'),
                    'Deadline' => $data->program_Deadline->format('F j, Y'),
                    'Event Time' => $data->program_Datetime ? $data->program_Datetime->format('F j, Y g:i A') : null,
                    'Status' => $data->program_Status,
                    'Registrants' => $data->program_reg_count,
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

        $user = Auth::user();

        $programList = $this->getProgramList($user->peso_accounts->peso->municipality_id)->get();

        if (!$programList->isEmpty()) {

            $fileName = 'Programs-List-' . now()->format('Y-m-d-H-i-s') . '.pdf';

            $programs = $programList->map(function ($data) {
                return [
                    'programTitle' => $data->program_Title,
                    'programHost' => $data->program_Host,
                    'programType' => $data->program_Type,
                    'datePosted' => $data->created_at->format('F j, Y'),
                    'registrantsCount' => $data->program_reg_count,
                ];
            });

            $pesoInformation = [
                'pesoMunicipality' => $user->peso_accounts->peso->municipality->municipality_Name,
                'pesoProvince' => $user->peso_accounts->peso->municipality->province->province_Name,
                'pesoEmail' => $user->peso_accounts->peso->peso_Email,
                'pesoPhone' => $user->peso_accounts->peso->peso_Phone,
                'pesoTel' => $user->peso_accounts->peso->peso_Tel,
                'pesoFax' => $user->peso_accounts->peso->peso_Fax,
            ];

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

    public function getProgramList($id)
    {

        $programList = Programs::whereHas('peso', function ($query) use ($id) {
            $query->where('municipality_id', $id);
        })
            ->withCount(['program_reg', 'attendedJobseekers'])
            ->where(function ($query) {
                $query->where('program_Title', 'like', '%' . $this->search . '%')
                    ->orWhereHas('job_industry', function ($query) {
                        $query->where('industry_Title', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('program_tags.job_positions', function ($query) {
                        $query->where('position_Title', 'like', '%' . $this->search . '%');
                    });
            });

        if ($this->filter === "ALL") {
            $programList->orderByRaw("FIELD(program_Status, 'ACTIVE') DESC");
        } elseif ($this->filter === 'ACTIVE') {
            $programList->where('program_Status', 'ACTIVE');
        } elseif ($this->filter === 'OTHERS') {
            $programList->whereNotIn('program_Status', ['ACTIVE']);
        }

        if ($this->sortType) {
            $programList->where('program_Type', $this->sortType);
        }
        if ($this->sortDate) {
            $programList->orderBy('created_at', $this->sortDate);
        }

        return $programList->orderBy('created_at', 'DESC');
    }

    public function render()
    {
        $user = Auth::user();

        $programList = $this->getProgramList($user->peso_accounts->peso->municipality_id)->paginate($this->rows);

        return view('livewire.admin.training.training-list', compact('programList'));
    }
}
