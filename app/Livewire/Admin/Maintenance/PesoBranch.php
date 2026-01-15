<?php

namespace App\Livewire\Admin\Maintenance;

use App\Mail\NewManagerNotification;
use App\Mail\PESOBranchNotification;
use App\Models\Municipality;
use App\Models\PESO;
use App\Models\PESO_Accounts;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class PesoBranch extends Component
{
    public $searchMun, $searchName;

    public $fname, $mname, $lname, $email, $phone;

    public $munID, $mun, $prov;

    // EDIT MANAGER
    public $upfname, $upmname, $uplname, $upemail, $upphone;
    public $pesofname, $pesolname, $pesoid, $pesoemail, $pesophone;
    public $option;

    public $selectedBranch;

    public $agreeBox = false;
    public $newBox = false;
    public $existingBox = false;

    public function selectBranch($id)
    {

        $this->selectedBranch = $id;
        $this->selectPESO($id);
        $this->resetExcept('selectedBranch');

    }

    public function resetValues()
    {
        $this->reset();
    }

    public function validateAccount()
    {
        $rules = [
            'fname' => 'required|string|min:2|max:255',
            'mname' => 'nullable|string|min:2|max:255',
            'lname' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => [
                'required',
                'regex:/^09\d{9}$/', // Starts with '09' followed by 9 digits
            ],
            'munID' => 'required|unique:peso,municipality_id', // Required and must be unique in the peso table
        ];

        $messages = [
            'fname.required' => 'First name is required.',
            'fname.string' => 'First name must be a string.',
            'fname.min' => 'First name must be at least 2 characters.',
            'fname.max' => 'First name cannot exceed 255 characters.',
            'mname.string' => 'Middle name must be a string.',
            'mname.min' => 'Middle name must be at least 2 characters.',
            'mname.max' => 'Middle name cannot exceed 255 characters.',
            'lname.required' => 'Last name is required.',
            'lname.string' => 'Last name must be a string.',
            'lname.min' => 'Last name must be at least 2 characters.',
            'lname.max' => 'Last name cannot exceed 255 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already taken.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must start with 09 and be 11 digits long.',
            'munID.required' => 'Municipality is required.',
            'munID.unique' => 'The selected municipality already has a PESO account.',
        ];

        $this->validate($rules, $messages);

        $this->dispatch('open-modal', 'confirm-modal');

    }

    public function validateUpdate()
    {
        $rules = [
            'option' => 'required',
        ];
        $messages = [
            'option.required' => 'You must select an option.',
        ];
        $this->validate($rules, $messages);

        if ($this->option == 1) {
            // dd('hello');
            $rules = [
                'fname' => 'required|string|min:2|max:255',
                'mname' => 'nullable|string|min:2|max:255',
                'lname' => 'required|string|min:2|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => [
                    'required',
                    'regex:/^09\d{9}$/', // Starts with '09' followed by 9 digits
                ],

            ];

            $messages = [
                'fname.required' => 'First name is required.',
                'fname.string' => 'First name must be a string.',
                'fname.min' => 'First name must be at least 2 characters.',
                'fname.max' => 'First name cannot exceed 255 characters.',
                'mname.string' => 'Middle name must be a string.',
                'mname.min' => 'Middle name must be at least 2 characters.',
                'mname.max' => 'Middle name cannot exceed 255 characters.',
                'lname.required' => 'Last name is required.',
                'lname.string' => 'Last name must be a string.',
                'lname.min' => 'Last name must be at least 2 characters.',
                'lname.max' => 'Last name cannot exceed 255 characters.',
                'email.required' => 'Email is required.',
                'email.email' => 'Email must be a valid email address.',
                'email.unique' => 'This email is already taken.',
                'phone.required' => 'Phone number is required.',
                'phone.regex' => 'Phone number must start with 09 and be 11 digits long.',

            ];

            $this->validate($rules, $messages);
            $this->dispatch('open-modal', 'new-manager-modal');
        } elseif ($this->option == 2) {
            $rules = [
                'pesoid' => 'required', // Required and must be unique in the peso table
            ];
            $messages = [
                'pesoid.required' => 'You must select a PESO Employee.',
            ];

            $this->validate($rules, $messages);
            $this->dispatch('open-modal', 'existing-manager-modal');
        }
    }

    public function generatePassword()
    {
        // Define the password criteria
        $length = 12;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+';

        // Generate a random password
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Set the generated password to the pwdPost property
        return $password;

        //dd($password);
    }

    public function createPESO()
    {
        // Validation rules and messages
        $rules = [
            'agreeBox' => 'required|boolean',
        ];
        $messages = [
            'agreeBox.required' => 'Please check before you continue.',
        ];
        $this->validate($rules, $messages);

        // Generate a password
        $password = $this->generatePassword();

        DB::beginTransaction();

        try {
            // Create the PESO entry
            $peso = PESO::create([
                'municipality_id' => $this->munID,
            ]);

            // Create the user
            $user = User::create([
                'email' => $this->email,
                'password' => Hash::make($password),
                'usertype' => 10, // Assuming 'usertype' indicates the user type
            ]);

            // Create PESO_Accounts entry with user ID and PESO ID
            PESO_Accounts::create([
                'user_id' => $user->id,
                'peso_id' => $peso->peso_id, // Use $peso->id to get the correct ID
                'peso_accounts_Fname' => $this->fname,
                'peso_accounts_Mname' => $this->mname,
                'peso_accounts_Lname' => $this->lname,
                'peso_accounts_Pnumber' => $this->phone,
            ]);

            // Generate email verification URL
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60), // URL expiration time
                ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
            );

            // Send notification email
            Mail::to($user->email)->queue(new PESOBranchNotification($user, $password, $verificationUrl));

            DB::commit();

            toastr()->success('PESO Branch has been created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            toastr()->error('Failed to create the account. Please try again.');
            Log::error('Failed to create PESO Branch: ' . $e->getMessage()); // Log the error
        }

        // Dispatch an event or close the modal
        $this->reset();
        $this->resetValidation();
        $this->dispatch('close-modal', 'confirm-modal');
    }

    public function newManager()
    {
        // Validation rules and messages
        $rules = [
            'newBox' => 'required|boolean',
        ];
        $messages = [
            'newBox.required' => 'Please check before you continue.',
        ];
        $this->validate($rules, $messages);

        // Generate a password
        $password = $this->generatePassword();

        DB::beginTransaction();

        try {
            // Create the PESO entry

            // Create the user
            $user = User::create([
                'email' => $this->email,
                'password' => Hash::make($password),
                'usertype' => 10, // Assuming 'usertype' indicates the user type
            ]);

            // Create PESO_Accounts entry with user ID and PESO ID
            PESO_Accounts::create([
                'user_id' => $user->id,
                'peso_id' => $this->selectedBranch, // Use $peso->id to get the correct ID
                'peso_accounts_Fname' => $this->fname,
                'peso_accounts_Mname' => $this->mname,
                'peso_accounts_Lname' => $this->lname,
                'peso_accounts_Pnumber' => $this->phone,
            ]);

            // Generate email verification URL
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60), // URL expiration time
                ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
            );

            // Send notification email
            Mail::to($user->email)->queue(new NewManagerNotification($user, $password, $verificationUrl, 1));

            DB::commit();

            toastr()->success('PESO Manager has been successfully created.');

        } catch (\Exception $e) {
            DB::rollBack();

            toastr()->error('Failed to create the account. Please try again.');
            Log::error('Failed to create PESO Manager: ' . $e->getMessage()); // Log the error
        }

        // Dispatch an event or close the modal
        $this->reset();
        $this->resetValidation();
        $this->dispatch('close-modal', 'new-manager-modal');
    }

    public function existingManager()
    {
        $rules = [
            'existingBox' => 'required|boolean',
        ];
        $messages = [
            'existingBox.required' => 'Please check before you continue.',
        ];
        $this->validate($rules, $messages);

        // Generate a password
        $password = $this->generatePassword();

        DB::beginTransaction();

        try {
            // Find the PESO entry
            $pesoAccount = PESO_Accounts::findOrFail($this->pesoid);

            // Fetch the associated user
            $user = $pesoAccount->user; // Assuming the relation 'user' exists on PESO_Accounts model

            // Update the user's usertype to 10
            $user->usertype = 10;
            $user->save();

            // Send notification email
            Mail::to($user->email)->queue(new NewManagerNotification($user, $password = null, $verificationUrl = null, 2));

            DB::commit();

            toastr()->success('PESO Manager has been successfully created.');

        } catch (\Exception $e) {
            DB::rollBack();

            toastr()->error('Failed to create the account. Please try again.');
            Log::error('Failed to create PESO Manager: ' . $e->getMessage()); // Log the error
        }

        // Dispatch an event or close the modal
        $this->reset();
        $this->resetValidation();
        $this->dispatch('close-modal', 'existing-manager-modal');
    }

    public function selectMunicipality($id)
    {
        $municipality = Municipality::findOrFail($id);
        if ($municipality) {
            $this->munID = $id;
            $this->mun = $municipality->municipality_Name;
            $this->prov = $municipality->province->province_Name;
        }
    }

    public function selectPESO($id)
    {
        $peso = PESO_Accounts::findOrFail($id);
        if ($peso) {
            $this->pesoid = $id;
            $this->pesofname = $peso->peso_accounts_Fname;
            $this->pesolname = $peso->peso_accounts_Lname;
            $this->pesophone = $peso->peso_accounts_Pnumber;
            $this->pesoemail = $peso->user->email;
        }
    }
    public function render()
    {

        $pesoBranchAdmins = null;
        $pesoBranch = null;

        $pesoData = PESO::withCount('peso_accounts as peso_accounts_count')
            ->with(['peso_accounts' => function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('usertype', 10);
                });
            }])->paginate(10);

        $municipalityData = Municipality::query()
            ->where(function ($query) {
                if (!empty($this->searchMun)) {
                    $query->where('municipality_Name', 'like', '%' . $this->searchMun . '%')
                        ->orWhereHas('province', function ($query) {
                            $query->where('province_Name', 'like', '%' . $this->searchMun . '%');
                        });
                }
            })
            ->whereNotIn('municipality_id', function ($query) {
                $query->select('municipality_id')
                    ->from('peso'); // Replace with actual table name if different
            })
            ->get();
        if ($this->selectedBranch) {
            $pesoBranch = PESO::find($this->selectedBranch);

            if ($pesoBranch) {
                $pesoBranchAdmins = PESO_Accounts::where('peso_id', $this->selectedBranch)
                    ->whereHas('user', function ($query) {
                        $query->whereIn('userstatus', [8, 9]);
                    })
                    ->where(function ($query) {
                        $query->where('peso_accounts_Fname', 'like', '%' . $this->searchName . '%')
                            ->orWhere('peso_accounts_Mname', 'like', '%' . $this->searchName . '%')
                            ->orWhere('peso_accounts_Lname', 'like', '%' . $this->searchName . '%');
                    })
                    ->get();
            }

        }

        return view('livewire.admin.maintenance.peso-branch', compact('pesoData', 'municipalityData', 'pesoBranch', 'pesoBranchAdmins'));
    }
}
