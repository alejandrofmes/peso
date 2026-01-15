<?php

namespace App\Livewire\Admin\Requirements;

use App\Models\Requirements as ModelsRequirements;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Requirements extends Component
{

    use WithPagination;
    use WithoutUrlPagination;

    public function updatedsearch()
    {
        $this->resetPage('');
    }
    public $search;
    public $filter = '';
    public $rows = 10;

    public $reqPost, $reqType;

    public $editreqID, $editreqPost, $editstatusPost;

    public function updateFilter($filter)
    {
        $this->filter = $filter;
    }

    public function saveRequirement()
    {
        $rules = [
            'reqPost' => ['required', 'string', Rule::unique('requirements', 'requirement_Title')],
            'reqType' => ['required'],
        ];

        $messages = [
            'reqPost.required' => 'The requirement title is required.',
            'reqPost.string' => 'The requirement title must be a string.',
            'reqPost.unique' => 'The requirement title has already been taken.',
            'reqType.required' => 'The requirement status is required.',
        ];

        $this->validate($rules, $messages);

        DB::beginTransaction();
        try {
            ModelsRequirements::create([
                'requirement_Title' => strtoupper($this->reqPost),
                'requirement_Status' => 1,
                'requirement_Type' => $this->reqType,

            ]);

            // $this->reset();
            DB::commit();
            toastr()->success('New Requirement Added!');

            $this->reset('reqPost', 'reqType');
            $this->resetValidation();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->reset('reqPost', 'reqType');
            $this->resetValidation();
            toastr()->error('There was an error.');
        }
    }

    public function editReq($id)
    {
        $requirement = ModelsRequirements::find($id);

        if ($requirement) {
            $this->editreqID = $requirement->requirement_id;
            $this->editreqPost = $requirement->requirement_Title;
            $this->editstatusPost = $requirement->requirement_Status;
            $this->dispatch('open-modal', 'requirement-modal');
        } else {
            toastr()->error('There was an error fetching the data.');
        }
    }

    public function updateReq()
    {
        $rules = [
            'editreqPost' => ['required', 'string', Rule::unique('requirements', 'requirement_Title')->ignore($this->editreqID, 'requirement_id')],
            'editstatusPost' => ['required'],
        ];
        $messages = [
            'editreqPost.required' => 'The requirement title is required.',
            'editreqPost.string' => 'The requirement title must be a string.',
            'editreqPost.unique' => 'The requirement title has already been taken.',
            'editstatusPost.required' => 'The requirement status is required.',
        ];

        $this->validate($rules, $messages);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Retrieve the model instance
            $requirement = ModelsRequirements::find($this->editreqID);

            if (!$requirement) {
                toastr()->error('Requirement not found!');
                DB::rollBack();
                return;
            }

            // Update the requirement using Eloquent
            $requirement->requirement_Title = strtoupper($this->editreqPost);
            $requirement->requirement_Status = $this->editstatusPost;

            // Check if there are any changes
            if ($requirement->isDirty()) {
                $requirement->save();
                // Commit the transaction if changes were made
                DB::commit();
                toastr()->success('Requirement Updated!');
            } else {
                // No changes to save
                DB::rollBack();
                toastr()->info('No changes detected.');
            }
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollBack();
            toastr()->error('There was an error.');
        }

        // Close the modal after updating
        $this->close();
    }

    public function close()
    {
        $this->dispatch('close-modal', 'requirement-modal');
        $this->resetValidation();
        $this->reset('editreqID', 'editreqPost', 'editstatusPost');
    }

    public function render()
    {

        $query = ModelsRequirements::where('requirement_Title', 'like', '%' . $this->search . '%');

        if (!empty($this->filter)) {
            $query->where('requirement_Type', '=', $this->filter);
        }

        $requirements = $query->orderBy('requirement_Title', 'asc')->paginate($this->rows);
        return view('livewire.admin.requirements.requirements', compact('requirements'));
    }
}
