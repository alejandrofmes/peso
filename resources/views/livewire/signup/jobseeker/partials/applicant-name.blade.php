<div class="flex flex-col w-full h-full">
    <h1 class="text-2xl font-bold">Applicant Name</h1>
    <span class="text-sm text-gray-600">Fields with * are required.</span>
    <div class="flex flex-col items-center mt-5">
        <div class="flex flex-col items-center">
            <x-input-label for="image" :value="__('Upload Profile Image*')" />
            <div
                class="flex items-center justify-center overflow-hidden bg-gray-200 border border-gray-300 rounded-lg shrink-0 grow-0">
                <!-- Display uploaded image here -->
                @if ($pimage)
                    <img id="uploadedImage" class="flex uploaded-image object-cover w-[200px] h-[200px] shrink-0 grow-0"
                        src="{{ $pimage->temporaryUrl() }}" alt="Uploaded Image" />
                @else
                    <img id="uploadedImage"
                        class="flex uploaded-image object-cover  w-[200px] h-[200px] shrink-0 grow-0"
                        src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"
                        alt="Uploaded Image" />
                @endif
            </div>
        </div>


        <x-input-error :messages="$errors->get('pimage')" class="mt-2" />
        <div class="flex justify-center mt-4 w-160">
            <label for="imageUpload" wire:loading.attr="disabled" wire:target="pimage"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md cursor-pointer hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Upload Image
                <div wire:loading.delay.long wire:target="pimage" role="status">
                    <svg aria-hidden="true" class="w-6 h-6 ml-4 text-gray-200 animate-spin fill-blue-600"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </label>
            <input wire:model='pimage' type="file" id="imageUpload" class="hidden" accept="image/*">

        </div>
    </div>



    <div class="flex flex-col w-full gap-4 mt-4 lg:flex-row">
        <div class="flex flex-col w-full">
            <x-input-label for="fname" :value="__('First Name*')" />
            <x-text-input wire:model='fname' class="block w-full mt-1" type="text" />
            <x-input-error :messages="$errors->get('fname')" class="mt-2" />

        </div>
        <div class="flex flex-col w-full">
            <x-input-label for="lname" :value="__('Last Name*')" />
            <x-text-input wire:model='lname' class="block w-full mt-1" type="text" />
            <x-input-error :messages="$errors->get('lname')" class="mt-2" />
        </div>
    </div>
    <div class="flex flex-col gap-4 mt-4 lg:flex-row">
        <div class="flex flex-col w-full">
            <x-input-label for="mname" :value="__('Middle Name')" />
            <x-text-input wire:model='mname' class="block w-full mt-1" type="text" />
            <x-input-error :messages="$errors->get('mname')" class="mt-2" />
        </div>
        <div class="flex flex-col w-full">
            <x-input-label for="suffix" :value="__('Suffix')" />
            <select wire:model='suffix' class="block w-full mt-1 rounded">
                <option value="" disabled selected>Select Suffix</option>
                <option value="">None</option>
                <option value="Jr.">Jr. (Junior)</option>
                <option value="Sr.">Sr. (Senior)</option>
                <option value="I">I</option>
                <option value="II">II</option>
                <option value="III">III</option>
                <option value="IV">IV</option>
                <option value="V">V</option>
                <option value="VI">VI</option>
                <option value="VII">VII</option>
                <option value="VIII">VIII</option>
                <option value="IX">IX</option>
                <option value="X">X</option>
            </select>
            <x-input-error :messages="$errors->get('suffix')" class="mt-2" />
        </div>
    </div>
    <div class="flex flex-col gap-4 mt-4 lg:flex-row">
        <div wire:model='bday' class="flex flex-col w-full">
            <x-input-label for="birthdate" :value="__('Birthdate*')" />
            <x-text-input class="block w-full mt-1" type="date" />
            <x-input-error :messages="$errors->get('bday')" class="mt-2" />
        </div>
        <div class="flex flex-col w-full">
            <x-input-label for="gender" :value="__('Gender*')" />
            <select wire:model='gender' class="block w-full mt-1 rounded">
                <option value="" disabled selected>Select Gender</option>
                <option value="1">Male</option>
                <option value="2">Female</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>
    </div>
    <div class="flex flex-row justify-end mt-4 space-x-4">

        <x-blue-button wire:loading.attr='disabled' wire:click.prevent='next' type="button">
            Next
            <div wire:loading.delay.long wire:target="next" role="status">
                <svg aria-hidden="true" class="w-6 h-6 ml-4 text-gray-200 animate-spin fill-blue-600"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </x-blue-button>
    </div>

</div>
