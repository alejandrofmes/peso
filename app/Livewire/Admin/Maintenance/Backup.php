<?php

namespace App\Livewire\Admin\Maintenance;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use ZipArchive;

#[Layout('layouts.admin')]
class Backup extends Component
{

    public $restore, $delete;

    public $password;
    public function mount()
    {

        // $this->listFiles();
    }
    // public function listFiles()
    // {
    //     try {
    //         // Access the Google Drive disk
    //         $googleDisk = Storage::disk('google');

    //         // List files in the specified folder
    //         $files = $googleDisk->allFiles();

    //         $this->files = collect($files)->map(function ($file) use ($googleDisk) {
    //             return [
    //                 'name' => basename($file),
    //                 'path' => $file,
    //                 'date' => \Carbon\Carbon::createFromTimestamp($googleDisk->lastModified($file))->toDateTimeString(),
    //             ];
    //         })->sortByDesc('date'); // Optionally sort by date, newest first
    //     } catch (\Exception $e) {
    //         // \Log::error('Failed to list files from Google Drive: ' . $e->getMessage());
    //         $this->files = []; // Clear files on error
    //     }
    // }

    // public function restoreDatabase($filePath)
    // {
    //     try {
    //         $googleDisk = Storage::disk('google');

    //         $fileContent = $googleDisk->get($filePath);

    //         // Ensure the temp directory exists
    //         $tempDir = storage_path('app/PESO/');
    //         if (!File::exists($tempDir)) {
    //             File::makeDirectory($tempDir, 0755, true); // Create the directory with proper permissions
    //         }

    //         $backupDisk = Storage::disk('local');
    //         $backupDisk->put('PESO/' . basename($filePath), $fileContent);

    //         // Run the restore command with Artisan
    //         $exitCode = Artisan::call('backup:restore', [
    //             '--disk' => 'local', // Use 'local' since the file is saved locally
    //             '--backup' => 'PESO/' . basename($filePath), // Path within the local disk
    //             '--connection' => 'mysql', // Database connection
    //             '--password' => env('BACKUP_ENCRYPTION_PASSWORD', ''), // Encryption password if needed
    //             '--no-interaction' => true,
    //         ]);

    //         if ($exitCode !== 0) {
    //             throw new \Exception('Restore command failed with exit code: ' . $exitCode);
    //         }

    //         // Capture the output for debugging
    //         $commandOutput = Artisan::output();
    //         Log::info('Backup restore command output: ' . $commandOutput);

    //         toastr()->success('Database restored successfully.');

    //     } catch (\Exception $e) {
    //         // Log the error
    //         Log::error('Failed to restore database: ' . $e->getMessage());

    //         toastr()->error('Failed to restore database: ' . $e->getMessage());
    //     }
    // }

    public function restoreDatabase($type)
    {
        if ($type == 1) {

            try {
                // Initialize Google disk and get file content
                $googleDisk = Storage::disk('google');
                if (!$googleDisk->exists($this->restore)) {
                    throw new \Exception('Backup file does not exist on Google Disk.');
                }

                $fileContent = $googleDisk->get($this->restore);

                // Ensure the temp directory exists
                $tempDir = storage_path('app/PESO/');
                if (!File::exists($tempDir)) {
                    File::makeDirectory($tempDir, 0755, true); // Create the directory with proper permissions
                }

                // Save file locally
                $localFilePath = 'PESO/' . basename($this->restore);
                $backupDisk = Storage::disk('local');
                if (!$backupDisk->put($localFilePath, $fileContent)) {
                    throw new \Exception('Failed to save backup file locally.');
                }

                // Verify if the file was successfully saved
                if (!$backupDisk->exists($localFilePath)) {
                    throw new \Exception('Backup file not found locally after transfer.');
                }

                // Run the restore command with Artisan
                $exitCode = Artisan::call('backup:restore', [
                    '--disk' => 'local', // Use 'local' since the file is saved locally
                    '--backup' => $localFilePath, // Path within the local disk
                    '--connection' => 'mysql', // Database connection
                    '--password' => env('BACKUP_ENCRYPTION_PASSWORD', ''), // Encryption password if needed
                    '--no-interaction' => true,
                ]);

                // Check for restore command success
                if ($exitCode !== 0) {
                    $commandOutput = Artisan::output();
                    throw new \Exception('Restore command failed with exit code: ' . $exitCode . ' and output: ' . $commandOutput);
                }

                // Success message
                $this->closeModal("database-restore");

                toastr()->success('Database restored successfully.');

            } catch (\Exception $e) {
                // Log the error with detailed message
                Log::error('Failed to restore database: ' . $e->getMessage());
                $this->closeModal("database-restore");

                toastr()->error('Failed to restore database: ' . $e->getMessage());
            }
        } elseif ($type == 2) {
            try {
                // Initialize Google disk and get the file content
                $googleDisk = Storage::disk('googleFiles');
                if (!$googleDisk->exists($this->restore)) {
                    throw new \Exception('Backup file does not exist on Google Disk.');
                }

                // Get the file content from Google Disk
                $fileContent = $googleDisk->get($this->restore);

                // Ensure the temporary directory exists locally
                $tempDir = storage_path('app/temp/extract/');
                if (!File::exists($tempDir)) {
                    File::makeDirectory($tempDir, 0755, true); // Create the directory with proper permissions
                }

                // Save the file locally
                $localFilePath = 'temp/extract/' . basename($this->restore);
                $localDisk = Storage::disk('local');
                if (!$localDisk->put($localFilePath, $fileContent)) {
                    throw new \Exception('Failed to save backup file locally.');
                }

                // Verify if the file was successfully saved locally
                if (!$localDisk->exists($localFilePath)) {
                    throw new \Exception('Backup file not found locally after transfer.');
                }

                // Path where the file will be extracted
                $zipFilePath = storage_path('app/' . $localFilePath);
                $extractToPath = storage_path('app/temp/extract/'); // Extract to the temporary directory

                // Extract the ZIP file
                $zip = new ZipArchive;
                if ($zip->open($zipFilePath) === true) {
                    // Extract the contents to the temporary directory
                    $zip->extractTo($extractToPath);
                    $zip->close();

                    // Optionally, remove the ZIP file after extraction
                    File::delete($zipFilePath);

                    // Move files from `app/temp/extract/public/storage` to `public/storage`
                    $sourcePath = $extractToPath . 'public/storage';
                    $destinationPath = public_path('storage'); // Target directory

                    if (File::exists($sourcePath)) {
                        $files = File::allFiles($sourcePath);
                        foreach ($files as $file) {
                            try {
                                // Define the target path for each file
                                // Remove the base path from the source path to get the relative path
                                $relativePath = str_replace($sourcePath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                                $targetFilePath = $destinationPath . DIRECTORY_SEPARATOR . $relativePath;

                                // Debugging: Dump paths for each file operation
                                // dd([
                                //     'sourceFilePath' => $file->getPathname(),
                                //     'targetFilePath' => $targetFilePath,
                                // ]);

                                // Create the directory if it doesn't exist
                                if (!File::exists(dirname($targetFilePath))) {
                                    File::makeDirectory(dirname($targetFilePath), 0755, true);
                                }

                                // Move the file
                                File::move($file->getPathname(), $targetFilePath);
                            } catch (\Exception $fileException) {
                                // Log::error('Failed to move file: ' . $file->getPathname() . ' to ' . $targetFilePath . '. Error: ' . $fileException->getMessage());
                            }
                        }

                        // Optionally, remove the source directory after moving files
                        File::deleteDirectory($sourcePath);
                    }

                    // Success message
                    toastr()->success('Files restored and moved successfully to the public/storage directory.');
                    $this->closeModal("files-restore");

                } else {
                    $this->closeModal("files-restore");

                    throw new \Exception('Failed to open the ZIP file.');

                }

            } catch (\Exception $e) {
                // Log the error with a detailed message
                Log::error('Failed to restore files: ' . $e->getMessage() . ' in path: ' . $zipFilePath . ' extracting to: ' . $extractToPath);

                // Notify the user of the error
                toastr()->error('Failed to restore files: ' . $e->getMessage());
                $this->closeModal("files-restore");

            }

        }

    }

    public function startBackup($type)
    {
        if ($type == 1) {
            try {
                // Call the Artisan command to start the backup
                Artisan::call('backup:run', [
                    '--only-db' => true, // To backup only the database
                    '--only-to-disk' => 'google', // Specify the disk where the backup should be stored
                ]);
                // Set success message
                // $this->status = 'Backup started successfully.';
                $this->closeModal("database-backup");

                toastr()->success('Backup started successfully');

                // Optional: You can use session or flash messages for real-time feedback

            } catch (\Exception $e) {
                // Log the error
                Log::error('Failed to start backup: ' . $e->getMessage());
                $this->closeModal("database-backup");

                toastr()->error('Failed to start backup: ' . $e->getMessage());

            }
        } elseif ($type == 2) {
            try {
                // Call the Artisan command to start the backup
                Artisan::call('backup:run', [
                    '--only-files' => true, // To backup only the database
                    '--only-to-disk' => 'googleFiles', // Specify the disk where the backup should be stored
                ]);
                // Set success message
                // $this->status = 'Backup started successfully.';

                toastr()->success('Backup started successfully');

                // Optional: You can use session or flash messages for real-time feedback
                $this->closeModal("files-backup");

            } catch (\Exception $e) {
                // Log the error
                Log::error('Failed to start backup: ' . $e->getMessage());
                $this->closeModal("files-backup");

                toastr()->error('Failed to start backup: ' . $e->getMessage());

            }
        }
    }

    public function listDB()
    {
        try {
            // Access the Google Drive disk
            $googleDisk = Storage::disk('google');

            // List files in the specified folder
            $files = $googleDisk->allFiles();

            return collect($files)->map(function ($file) use ($googleDisk) {
                return [
                    'name' => basename($file),
                    'path' => $file,
              'date' => \Carbon\Carbon::createFromTimestamp($googleDisk->lastModified($file))
                        ->setTimezone('Asia/Manila')
                        ->toDateTimeString(),

                    'size' => $this->formatSizeUnits($googleDisk->size($file)), // Add file size
                ];
            })->sortByDesc('date'); // Optionally sort by date, newest first
        } catch (\Exception $e) {
            // Log the error if needed
            Log::error('Failed to list files from Google Drive: ' . $e->getMessage());
            return collect(); // Return an empty collection
        }
    }
    public function listFiles()
    {
        try {
            // Access the Google Drive disk
            $googleDisk = Storage::disk('googleFiles');

            // List files in the specified folder
            $files = $googleDisk->allFiles();

            return collect($files)->map(function ($file) use ($googleDisk) {
                return [
                    'name' => basename($file),
                    'path' => $file,
                    'date' => \Carbon\Carbon::createFromTimestamp($googleDisk->lastModified($file))
                        ->setTimezone('Asia/Manila')
                        ->toDateTimeString(),

                    'size' => $this->formatSizeUnits($googleDisk->size($file)), // Add file size
                ];
            })->sortByDesc('date'); // Optionally sort by date, newest first
        } catch (\Exception $e) {
            // Log the error if needed
            Log::error('Failed to list files from Google Drive: ' . $e->getMessage());
            return collect(); // Return an empty collection
        }
    }
    private function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public function removeBackup($type)
    {
        if ($type == 1) {
            try {
                $disk = Storage::disk('google'); // Adjust if needed
                if ($disk->exists($this->delete)) {
                    $disk->delete($this->delete);
                    Log::info("Deleted backup file: {$this->delete}");
                    toastr()->success('Backup removed successfully.');
                } else {
                    toastr()->error('Backup file not found.');
                }
                $this->closeModal("database-deletion");

            } catch (\Exception $e) {
                $this->closeModal("database-deletion");

                Log::error("Failed to delete backup file {$this->delete}: " . $e->getMessage());
                toastr()->error('error', 'Failed to remove backup.');
            }
        } elseif ($type == 2) {
            try {
                $disk = Storage::disk('googleFiles'); // Adjust if needed
                if ($disk->exists($this->delete)) {
                    $disk->delete($this->delete);
                    Log::info("Deleted system files file: {$this->delete}");
                    toastr()->success('Backup removed successfully.');
                    
                } else {
                    toastr()->error('Backup file not found.');
                }
                $this->closeModal("files-deletion");

            } catch (\Exception $e) {
                $this->closeModal("files-deletion");

                Log::error("Failed to delete backup system files {$this->delete}: " . $e->getMessage());
                toastr()->error('error', 'Failed to remove backup.');
            }
        }

    }

    public function confirmResponse($type)
    {
        $rules = [
            'password' => 'required|string|min:6',
        ];

        $messages = [
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 6 characters.',
        ];

        $this->validate($rules, $messages);

        if (!Hash::check($this->password, Auth::user()->password)) {
            // Use Laravel's validation system to return error messages
            $this->reset('password');
            return $this->addError('password', 'The provided password is incorrect.');

        } else {
            if ($type == 1) {
                $this->restoreDatabase(1);
                $this->closeModal("database-restore");

            } elseif ($type == 2) {
                $this->removeBackup(1);
                $this->closeModal("database-deletion");

            } elseif ($type == 3) {
                $this->startBackup(1);
                $this->closeModal("database-backup");

            } elseif ($type == 5) {
                $this->restoreDatabase(2);
                $this->closeModal("database-restore");

            } elseif ($type == 4) {
                $this->removeBackup(2);
                $this->closeModal("database-deletion");

            } elseif ($type == 6) {
                $this->startBackup(2);
                $this->closeModal("database-backup");

            } else {

                toastr()->error('There was an unexpected error. Please try again later.');
            }
        }

    }

    public function closeModal($modal)
    {
        $this->reset('password');
        $this->reset('restore', 'delete');
        $this->dispatch('close-modal', $modal);

    }

    public function confirmAction($type, $data = null)
    {
        $this->reset('restore', 'delete');
        if ($type == 1) {
            $this->restore = $data;
            $this->dispatch('open-modal', 'database-restore');

        } elseif ($type == 2) {
            $this->delete = $data;
            $this->dispatch('open-modal', 'database-deletion');

        } elseif ($type == 3) {
            $this->dispatch('open-modal', 'database-backup');

        } elseif ($type == 4) {
            $this->restore = $data;
            $this->dispatch('open-modal', 'files-restore');

        } elseif ($type == 5) {
            $this->delete = $data;
            $this->dispatch('open-modal', 'files-deletion');

        } elseif ($type == 6) {
            $this->dispatch('open-modal', 'files-backup');

        }
    }
    public function render()
    {

        $dbs = $this->listDB();
        $files = $this->listFiles();
        return view('livewire.admin.maintenance.backup', compact('dbs', 'files'));
    }
}
