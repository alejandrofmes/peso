<?php

namespace App\Livewire\Admin\Announcement;

use App\Models\Announcements;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class EditAnnouncement extends Component
{
    use WithFileUploads;

    public $announcementData;

    public $title, $contentPost;

    #[Validate]
    public $announcementImage;

    public function rules()
    {
        return [
            // BASIC INFORMATION
            'announcementImage' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // Validation rules
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

    public function mount()
    {
        $this->announcementData = session()->get('announcementData');

        // dd($this->programData);
        $this->mountData($this->announcementData);

    }

    public function validateInput()
    {

        $rules = [
            'title' => 'required|string|max:255',
            'contentPost' => 'required|string',
            'announcementImage' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // Validation rules

        ];

        $messages = [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title must not exceed 255 characters.',

            'contentPost.required' => 'The content field is required.',
            'contentPost.string' => 'The content must be a valid string.',
            'announcementImage.image' => 'The file must be an image.',
            'announcementImage.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            'announcementImage.max' => 'The image may not be greater than 10 MB.',
        ];

        $this->validate($rules, $messages);

        $this->dispatch('open-modal', 'confirm-modal');

    }

    public function mountData($id)
    {
        $announcementInfo = Announcements::findOrFail($id);
        if ($announcementInfo) {
            $this->title = $announcementInfo->announcement_Title;
            $this->contentPost = $announcementInfo->announcement_Content;

        } else {

            $this->redirectRoute('admin-announcement', navigate: true);
            toastr()->error('There was an error fetching the data.');

        }
    }

    public function saveAnnouncement()
    {
        // Find the announcement or fail if not found
        $announcementInfo = Announcements::findOrFail($this->announcementData);

        $imgPath = null;

        if ($this->announcementImage) {
            // Store the new image and get the path
            $imgPath = $this->announcementImage->store('images/announcements', 'public');
        }

        DB::beginTransaction();

        try {
            // Delete old image if a new one is uploaded and there is an existing image
            if ($this->announcementImage && $announcementInfo->announcement_pubmat) {
                Storage::disk('public')->delete($announcementInfo->announcement_pubmat);
            }

            // Update model attributes
            $announcementInfo->announcement_Title = $this->title; // Ensure you're updating the correct fields
            $announcementInfo->announcement_Content = $this->contentPost; // Update this field if it is correct

            // Set the new image path or retain the old one
            $announcementInfo->announcement_pubmat = $imgPath ?? $announcementInfo->announcement_pubmat;

            // Check if any attributes have changed
            if ($announcementInfo->isDirty()) {
                $announcementInfo->save();
                DB::commit();

                // Redirect to the updated announcement route
                $this->redirectRoute('announcement.show', ['id' => $announcementInfo->announcement_id], navigate: true);

                toastr()->success('Announcement has been updated!');
            } else {
                DB::rollBack();
                toastr()->info('No changes detected.');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete new image if it was uploaded and an error occurred
            if ($imgPath) {
                Storage::disk('public')->delete($imgPath);
            }

            toastr()->error('There was an error updating the announcement: ' . $e->getMessage());
        }

        // Reload component or page state
        $this->mount();
        $this->dispatch('close-modal', 'confirm-modal');
    }

    public function render()
    {

        $announcementInfo = Announcements::findOrFail($this->announcementData);
        if (!$announcementInfo) {

        }

        return view('livewire.admin.announcement.edit-announcement', compact('announcementInfo'));
    }
}
