<?php

namespace App\Livewire\Admin\Announcement;

use App\Models\Announcements;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class AnnouncementList extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $search;
    public $filter = 'All', $sortDate;

    public $archive, $delete, $restore, $restoredelete;

    public function updatedsearch()
    {
        $this->resetPage(); // Reset pagination for eligibility search
    }

    public function updateSort($value)
    {
        $this->sortDate = $value;
        $this->resetPage(); // Reset pagination for eligibility search

    }

    public function updateFilter($value)
    {
        $this->filter = $value;
        $this->resetPage(); // Reset pagination for eligibility search

    }

    public function confirmationModal($type, $id)
    {
        if ($type == 1) {
            $this->archive = $id;
            $this->dispatch('open-modal', 'archive-modal');
        } elseif ($type == 2) {
            $this->delete = $id;
            $this->dispatch('open-modal', 'delete-modal');
        } elseif ($type == 3) {
            $this->restore = $id;
            $this->dispatch('open-modal', 'restore-modal');
        } elseif ($type == 4) {
            $this->restoredelete = $id;
            $this->dispatch('open-modal', 'restore-del-modal');
        }
    }
    public function editAnnouncement($id)
    {
        session()->put('announcementData', $id);

        $this->redirectRoute('admin-edit-announcement', navigate: true);

    }

    public function archiveAnnouncement()
    {

        $announcementData = Announcements::findOrFail($this->archive);

        if ($announcementData) {
            $announcementData->announcement_Status = 'ARCHIVED';
            $announcementData->save();

            toastr()->success('Announcement Archived');
        } else {
            toastr()->error('Announcement was not found.');

        }
        $this->dispatch('close-modal', 'archive-modal');

    }

    public function restoreAnnouncement()
    {

        $announcementData = Announcements::findOrFail($this->restore);

        if ($announcementData) {
            $announcementData->announcement_Status = 'ACTIVE';
            $announcementData->save();

            toastr()->success('Announcement Restored');
        } else {
            toastr()->error('Announcement was not found.');

        }
        $this->dispatch('close-modal', 'restore-modal');

    }

    public function deleteAnnouncement()
    {
        // Find the announcement or fail if not found
        $announcementData = Announcements::findOrFail($this->delete);

        if ($announcementData) {
            try {
                // Permanently delete the announcement
                $announcementData->delete();

                // Show success message
                toastr()->success('Announcement successfully deleted.');
            } catch (\Exception $e) {
                // Show error message if there's an issue during deletion
                toastr()->error('An error occurred while deleting the announcement.');
            }
        } else {
            // Show error message if announcement was not found
            toastr()->error('Announcement not found.');
        }
        $this->dispatch('close-modal', 'delete-modal');

    }

    public function restoreDelAnnouncement()
    {
        // Find the soft-deleted announcement or fail if not found
        $announcementData = Announcements::withTrashed()->find($this->restoredelete);

        if ($announcementData) {
            try {
                // Restore the announcement
                $announcementData->restore();

                // Update the status to 'ACTIVE' or any other status as needed
                $announcementData->announcement_Status = 'ACTIVE';
                $announcementData->save();

                // Show success message
                toastr()->success('Announcement successfully restored.');
            } catch (\Exception $e) {
                // Show error message if there's an issue during restoration
                toastr()->error('An error occurred while restoring the announcement.');
            }
        } else {
            // Show error message if announcement was not found
            toastr()->error('Announcement not found.');
        }
        $this->dispatch('close-modal', 'restore-del-modal');

    }

    public function render()
    {
        // Get the user's peso_id
        $peso_id = Auth::user()->peso_accounts->peso_id;

        // Build the base query for announcements
        $query = Announcements::where('peso_id', $peso_id)
            ->where('announcement_Title', 'like', '%' . $this->search . '%');

        // Apply filters based on the selected filter value
        switch ($this->filter) {
            case 'Archived':
                $query->where('announcement_Status', 'ARCHIVED');
                break;

            case 'Active':
                $query->where('announcement_Status', 'ACTIVE');
                break;

            case 'Deleted':
                $query->onlyTrashed(); // Show only deleted (trashed) announcements
                break;

            case 'All':
                // Show all, but exclude deleted ones by default
                $query->where(function ($q) {
                    $q->where('announcement_Status', 'ACTIVE')
                        ->orWhere('announcement_Status', 'ARCHIVED');
                });
                break;
        }

        if ($this->sortDate) {
            $query->orderBy('created_at', $this->sortDate);
        }

        // Paginate the results
        $announcement = $query->paginate(10);

        // Return the view with announcements
        return view('livewire.admin.announcement.announcement-list', compact('announcement'));
    }

}
