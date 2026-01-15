<?php

namespace App\Livewire\Admin\Announcement;

use App\Mail\AnnouncementNotification;
use App\Models\Announcements;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class CreateAnnouncement extends Component
{

    use WithFileUploads;

    public $title, $contentPost;

    #[Validate]
    public $announcementImage;

    public function rules()
    {
        return [
            // BASIC INFORMATION
            'announcementImage' => 'required|image|mimes:jpeg,png,jpg|max:10240', // Validation rules
        ];
    }

    public function messages()
    {
        return [
            // Custom messages for validation rules
            'announcementImage.image' => 'The file must be an image.',
            'announcementImage.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            'announcementImage.max' => 'The image may not be greater than 10 MB.',
        ];
    }

    public function validateInput()
    {

        $rules = [
            'title' => 'required|string|max:255',
            'contentPost' => 'required|string',
            'announcementImage' => 'required|image|mimes:jpeg,png,jpg|max:10240', // Validation rules

        ];

        $messages = [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title must not exceed 255 characters.',

            'contentPost.required' => 'The content field is required.',
            'contentPost.string' => 'The content must be a valid string.',
            'announcementImage.required' => 'An image is required.',
            'announcementImage.image' => 'The file must be an image.',
            'announcementImage.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            'announcementImage.max' => 'The image may not be greater than 10 MB.',
        ];

        $this->validate($rules, $messages);

        $this->dispatch('open-modal', 'confirm-modal');

    }

    public function getResidents($announcement)
    {
        // Get the municipality_id from the announcement's PESO
        $announcementMunicipalityId = $announcement->peso->municipality_id;

        // Find jobseekers that belong to the same municipality and have userstatus == 1
        $matchedResidents = Employee::whereHas('user', function ($query) {
            $query->where('userstatus', 1); // Ensure userstatus == 1
        })
            ->whereHas('barangay', function ($query) use ($announcementMunicipalityId) {
                $query->where('municipality_id', $announcementMunicipalityId);
            })->get();

        return $matchedResidents;
    }

    public function saveAnnouncement()
    {
        $peso_id = Auth::user()->peso_accounts->peso->peso_id;

        $data = [
            'announcement_Title' => $this->title,
            'announcement_Content' => $this->contentPost,
            'announcement_Status' => 'ACTIVE',
            'peso_id' => $peso_id,
        ];

        if ($this->announcementImage) {
            $imgPath = $this->announcementImage->store('images/announcements', 'public');
            $data['announcement_pubmat'] = $imgPath;

        }
        DB::beginTransaction();

        try {
            $announcements = Announcements::create($data);

            DB::commit();

            $residents = $this->getResidents($announcements);

            if (!empty($residents)) {
                foreach ($residents as $employee) {
                    Mail::to($employee->user->email)->queue(new AnnouncementNotification($employee, $announcements));
                }
            }

            $this->dispatch('close-modal', 'confirm-modal');
            $this->redirectRoute('admin-announcement', navigate: true);
            toastr()->success('Announcement has been posted!');
        } catch (\Exception $e) {

            DB::rollback();
            if (isset($imgPath)) {
                Storage::disk('public')->delete($imgPath);
            }
            $this->dispatch('close-modal', 'confirm-modal');
            // Return error response or handle the error
            toastr()->error('There was an error in posting the announcement.');
            // toastr()->error($e->getMessage());
        }

    }
    public function render()
    {
        return view('livewire.admin.announcement.create-announcement');
    }
}
