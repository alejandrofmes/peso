<?php

namespace App\Livewire\Admin\Accounts\Peso;

use App\Mail\AdminCreationNotification;
use App\Models\PESO;
use App\Models\PESO_Accounts;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class PesoManagement extends Component
{

    use WithFileUploads;
    use WithPagination, WithoutUrlPagination;

    public $fname, $mname, $lname, $email, $phone, $role = '';

    public $pesoEmail, $pesoPhone, $pesoTel, $pesoFax, $pesoDesc;

    #[Validate]
    public $pesoImg;

    public $agreeBox = false;

    public $search, $filter;

    public function updatedSearch()
    {
        $this->resetPage(); // Reset pagination for eligibility search
    }

    public function rules()
    {
        return [
            // BASIC INFORMATION
            'pesoImg' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'pesoImg.image' => 'The file must be an image.',
            'pesoImg.mimes' => 'The image must be of type: jpeg, png, jpg.',
            'pesoImg.max' => 'The image size must not exceed 5 MB.',
        ];
    }

    public function mount()
    {
        $peso_id = Auth::user()->peso_accounts->peso_id;

        $this->mountData($peso_id);
    }

    public function updateFilter($type)
    {
        $this->filter = $type;
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
            'role' => 'required',
        ];
        $messages = [
            'fname.required' => 'First name is required.',
            'fname.string' => 'First name must be a string.',
            'fname.min' => 'First name must be at least 2 characters.',
            'fname.max' => 'First name cannot exceed 50 characters.',
            'mname.string' => 'Middle name must be a string.',
            'mname.min' => 'Middle name must be at least 2 characters.',
            'mname.max' => 'Middle name cannot exceed 50 characters.',
            'lname.required' => 'Last name is required.',
            'lname.string' => 'Last name must be a string.',
            'lname.min' => 'Last name must be at least 2 characters.',
            'lname.max' => 'Last name cannot exceed 50 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already taken.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must start with 09 and be 11 digits long.',
            'role.required' => 'Role is required.',
        ];

        $this->validate($rules, $messages);

        $this->dispatch('open-modal', 'confirm-modal');

    }

    public function createAccount()
    {
        $rules = [
            'agreeBox' => 'required|boolean',
        ];
        $messages = [
            'agreeBox.required' => 'Please check before you continue.',
        ];
        $this->validate($rules, $messages);

        $pesoID = Auth::user()->peso_accounts->peso_id;

        $password = $this->generatePassword();
        DB::beginTransaction();

        try {
            // Create the user
            $user = User::create([
                'email' => $this->email,
                'password' => Hash::make($password),
                'usertype' => $this->role, // Assuming 'role' is what you use to indicate user type
            ]);

            // Create PESO entry
            PESO_Accounts::create([
                'user_id' => $user->id,
                'peso_id' => $pesoID,
                'peso_accounts_Fname' => $this->fname,
                'peso_accounts_Mname' => $this->mname,
                'peso_accounts_Lname' => $this->lname,
                'peso_accounts_Pnumber' => $this->phone,
            ]);

            $name = $this->fname . ' ' . $this->lname;

            // Generate email verification URL
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60), // URL expiration time
                ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
            );

            // Send notification email
            Mail::to($user->email)->queue(new AdminCreationNotification($name, $user->email, $password, $verificationUrl));

            DB::commit();

            toastr()->success('Account has been created and notified.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Handle the exception (log it, rethrow it, show an error message, etc.)
            toastr()->error('Failed to create the account. Please try again.');
            dd($e->getMessage());
        }
        $this->dispatch('close-modal', 'confirm-modal');

    }

    public function mountData($id)
    {
        $pesoData = PESO::findOrFail($id);

        if ($pesoData) {
            $this->pesoEmail = $pesoData->peso_Email;
            $this->pesoPhone = $pesoData->peso_Phone;
            $this->pesoTel = $pesoData->peso_Tel;
            $this->pesoFax = $pesoData->peso_Fax;
            $this->pesoDesc = $pesoData->peso_Description;

        }
    }

    public function savePESO()
    {

        $peso_id = Auth::user()->peso_accounts->peso_id;

        $rules = [
            'pesoEmail' => [
                'required',
                'email',
                Rule::unique('peso', 'peso_Email')->ignore($peso_id, 'peso_id'),
            ],
            'pesoPhone' => ['required', 'regex:/^09\d{9}$/'],
            'pesoTel' => ['nullable', 'regex:/^0[0-9]{9,10}$/'],
            'pesoFax' => ['nullable', 'digits:10'],
            'pesoDesc' => ['nullable', 'min:10'],
        ];

        $messages = [
            'pesoEmail.required' => 'The PESO email is required.',
            'pesoEmail.email' => 'The PESO email must be a valid email address.',
            'pesoEmail.unique' => 'The PESO email has already been taken.',
            'pesoPhone.required' => 'The PESO phone number is required.',
            'pesoPhone.regex' => 'The PESO phone number must start with 09 and be followed by 9 digits.',
            'pesoTel.regex' => 'The PESO telephone number must start with 0 and be followed by 9 or 10 digits.',
            'pesoFax.digits' => 'The PESO fax number must be exactly 10 digits.',
            // 'pesoDesc.required' => 'The PESO description is required.',
            'pesoDesc.min' => 'The PESO description must be at least 10 characters long.',
        ];

        $this->validate($rules, $messages);

        $pesoData = PESO::findOrFail($peso_id);
        $imgPath = null;

        if ($this->pesoImg) {
            $imgPath = $this->pesoImg->store('images/peso_branch', 'public');
        }

        DB::beginTransaction();

        try {
            // Delete old image if a new one is uploaded and there is an existing image
            if ($this->pesoImg && $pesoData->peso_Img) {
                Storage::disk('public')->delete($pesoData->peso_Img);
            }

            // Update model attributes
            $pesoData->peso_Email = $this->pesoEmail;
            $pesoData->peso_Phone = $this->pesoPhone;
            $pesoData->peso_Tel = $this->pesoTel;
            $pesoData->peso_Fax = $this->pesoFax;
            $pesoData->peso_Description = $this->pesoDesc;

            // Set the new image path if it exists
            $pesoData->peso_Img = $imgPath ?? $pesoData->peso_Img;

            // Check if any attributes have changed
            if ($pesoData->isDirty()) {
                $pesoData->save();
                DB::commit();
                toastr()->success('PESO profile has been updated!');
            } else {
                DB::rollBack();
                toastr()->info('No changes detected.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('There was an error updating the PESO details.');
        }
    }

    public function render()
    {
        $municipality = Auth::user()->peso_accounts->peso->municipality->municipality_Name;
        $municipalityId = Auth::user()->peso_accounts->peso->municipality_id;

        // Query with search functionality using whereHas

        $adminAccounts = User::whereIn('usertype', [8, 9, 10])
            ->whereHas('peso_accounts.peso', function ($query) use ($municipalityId) {
                $query->where('municipality_id', $municipalityId);
            })
            ->where(function ($query) {
                $query->whereHas('peso_accounts', function ($subQuery) {
                    $subQuery->where('peso_accounts_Fname', 'like', '%' . $this->search . '%')
                        ->orWhere('peso_accounts_Mname', 'like', '%' . $this->search . '%')
                        ->orWhere('peso_accounts_Lname', 'like', '%' . $this->search . '%');
                });
            });
        if ($this->filter) {
            $adminAccounts = $adminAccounts->where('usertype', $this->filter);
        }

        $adminAccounts = $adminAccounts->paginate(10);

        $pesoInfo = PESO::findOrFail(Auth::user()->peso_accounts->peso_id);

        return view('livewire.admin.accounts.peso.peso-management', compact('adminAccounts', 'municipality', 'pesoInfo'));
    }
}
