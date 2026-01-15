<div>
    <div class="grid items-center grid-cols-4 gap-5 p-0 mx-8 mt-4 lg:grid-cols-12 lg:p-6">
        <div class="col-span-4 lg:col-span-3">

        </div>

        <div class="col-span-4 lg:col-span-9">

            <div class="flex flex-row items-center gap-4">
                <a href="{{ route('employer.profile', ['id' => auth()->user()->company->company_id]) }}">
                    <div class="flex items-center p-1 transition-transform rounded-full hover:bg-gray-300">
                        <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </div>
                </a>
                <h2 class="text-2xl font-bold">Edit Details</h2>

            </div>


        </div>

        <div class="col-span-4 lg:col-span-3">

        </div>


        <div class="col-span-4 lg:col-span-6" x-data="{
            openTab: 1,
            activeTab: 'text-blue-600 bg-gray-100  rounded-t-lg active',
            inactiveTab: ' rounded-t-lg hover:text-gray-600 hover:bg-gray-50',
        }">
            <div class="p-6 bg-white rounded-lg shadow-lg">


                <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                    <li class="me-2">
                        <button x-on:click="$wire.mountData()" @click="openTab = 1"
                            :class="openTab === 1 ? activeTab : inactiveTab" aria-current="page"
                            class="inline-block p-4">Company Information</button>
                    </li>
                    <li class="me-2">
                        <button x-on:click="$wire.mountData()" @click="openTab = 2"
                            :class="openTab === 2 ? activeTab : inactiveTab" aria-current="page"
                            class="inline-block p-4">Contact Person</button>
                    </li>
                    <li class="me-2">
                        <button @click="openTab = 3" :class="openTab === 3 ? activeTab : inactiveTab"
                            class="inline-block p-4">Company
                            Industry</button>
                    </li>
                    <li class="me-2">
                        <button @click="openTab = 4" :class="openTab === 4 ? activeTab : inactiveTab"
                            class="inline-block p-4">Requirements</button>
                    </li>
                    <li class="me-2">
                        <button @click="openTab = 5" :class="openTab === 5 ? activeTab : inactiveTab"
                            class="inline-block p-4">Partnerships</button>
                    </li>
                </ul>

                {{-- BASIC INFORMATION --}}
                <div class="flex flex-col" x-show="openTab === 1" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>

                    <div class="flex flex-col items-center mt-4">
                        <div class="flex flex-col items-center">
                            <div
                                class="w-[160] h-[160] bg-gray-200 border border-gray-300 rounded-lg overflow-hidden flex items-center justify-center shrink-0">
                                <!-- Display uploaded image here -->
                                @if ($companyImage && !$errors->has('companyImage'))
                                    <img id="uploadedImage"
                                        class="flex uploaded-image object-contain w-[200px] h-[200px] shrink-0 grow-0"
                                        src="{{ $companyImage->temporaryUrl() }}" alt="Uploaded Image" />
                                @else
                                    <img id="uploadedImage"
                                        class="flex uploaded-image object-contain w-[200px] h-[200px] shrink-0 grow-0"
                                        src="{{ asset('storage/' . $employerDetails->company_img) }}"
                                        alt="Uploaded Image" />
                                @endif
                            </div>
                        </div>


                        <x-input-error :messages="$errors->get('companyImage')" class="mt-2" />
                        <div class="flex justify-center mt-4 w-160">
                            <label for="imageUpload" wire:loading.attr="disabled" wire:target="companyImage"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md cursor-pointer hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Upload Image
                                <div wire:loading.delay.long wire:target="companyImage" role="status">
                                    <svg aria-hidden="true"
                                        class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
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
                            <input wire:model="companyImage" type="file" id="imageUpload" class="hidden"
                                accept="image/*">
                        </div>
                    </div>

                    {{-- FIELDS START --}}
                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="bname" :value="__('Business Name')" />
                            <x-text-input wire:model="businessName" class="block w-full mt-1" type="text" disabled />
                            <x-input-error :messages="$errors->get('businessName')" class="mt-2" />

                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="tname" :value="__('Trade Name')" />
                            <x-text-input wire:model="tradeName" class="block w-full mt-1" type="text" disabled />
                            <x-input-error :messages="$errors->get('tradeName')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="tin" :value="__('TIN')" />
                            <x-text-input wire:model="tin" class="block w-full mt-1" type="text" disabled />
                            <x-input-error :messages="$errors->get('tin')" class="mt-2" />
                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="loctype" :value="__('Location Type')" />
                            <select wire:model="locType" class="block w-full mt-1 rounded-md" disabled>
                                <option value="" disabled selected>Select Location Type</option>
                                <option value="1">Main</option>
                                <option value="2">Branch</option>
                            </select>
                            <x-input-error :messages="$errors->get('loctype')" class="mt-2" />
                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="workforce" :value="__('Total Work Force')" />
                            <select wire:model="workforce" class="block w-full mt-1 rounded-md">
                                <option value="" disabled selected>Select Total Work Force</option>
                                <option value="1">1 - 9 (Micro)</option>
                                <option value="2">10 - 99 (Small)</option>
                                <option value="3">100 - 199 (Medium)</option>
                                <option value="4">200 and Over (Large)</option>

                            </select>
                            <x-input-error :messages="$errors->get('workforce')" class="mt-2" />

                        </div>
                    </div>
                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="empType" :value="__('Employment Status')" />
                            <select wire:model='empType' class="block w-full mt-1 rounded" disabled>
                                <option value="" disabled selected>Select Employment Type</option>
                                {{-- <option value="1">Public</option> --}}
                                <option value="2">Private</option>
                            </select>
                            <x-input-error :messages="$errors->get('empType')" class="mt-2" />


                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="empDesc" :value="__('Description')" />
                            <select wire:model='empDesc' class="block w-full mt-1 rounded" disabled>
                                <option value="" disabled selected>Select Description</option>
                                <option value="1">National Government Agency</option>
                                <option value="2">Local Government Unit</option>
                                <option value="3">Government-owned and Controlled Corporation</option>
                                <option value="4">State/Local University or College</option>
                                <option value="5">Direct Hire</option>
                                <option value="6">Private Employment Agency</option>
                                <option value="7">Overseas Recruitment Agency</option>
                                <option value="8">'D.O. 174, s. 2017</option>
                            </select>
                            <x-input-error :messages="$errors->get('empDesc')" class="mt-2" />

                        </div>
                    </div>

                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="emptype" :value="__('Employment Type')" />
                            <x-text-input wire:model="empType" class="block w-full mt-1" type="text" disabled />
                            <x-input-error :messages="$errors->get('empType')" class="mt-2" />
                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="empdesc" :value="__('Employment Description')" />
                            <x-text-input wire:model="empDesc" class="block w-full mt-1" type="text" disabled />
                            <x-input-error :messages="$errors->get('empDesc')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="companyAddress" :value="__('Company Address')" />
                            <x-text-input wire:model="companyAddress" class="block w-full mt-1" type="text" />
                            <x-input-error :messages="$errors->get('companyAddress')" class="mt-2" />

                        </div>
                        <div class="flex flex-col w-full">
                            <livewire:modals.barangay-modal />
                            <x-input-label for="city" :value="__('Barangay')" />
                            <x-text-input wire:model='bar' class="block w-full mt-1" type="text" readonly
                                x-data="" x-on:click.prevent="dispatch('open-modal', 'barangay-modal')"
                                x-on:focus="$dispatch('open-modal', 'barangay-modal')" />
                            <x-input-error :messages="$errors->get('bar')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="mun" :value="__('Municipality')" />
                            <x-text-input wire:model='mun' class="block w-full mt-1" type="text" readonly />
                            <x-input-error :messages="$errors->get('mun')" class="mt-2" />
                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="province" :value="__('Province')" />
                            <x-text-input wire:model='prov' class="block w-full mt-1" type="text" readonly />
                            <x-input-error :messages="$errors->get('prov')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-row mt-4">

                        <x-blue-button wire:target="companyImage, saveCompany" wire:loading.attr="disabled"
                            wire:click.prevent="saveCompany" class="ml-auto mr-3" type="button"
                            x-data="" {{-- x-on:click.prevent="$dispatch('open-modal', 'jobTag-modal')"> x-on:click.prevent="saveDetails(general)" --}}>
                            Save
                            <div wire:loading.delay.long wire:target="companyImage, saveCompany" role="status">
                                <svg aria-hidden="true" class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
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
                {{-- BASIC INFORMATION --}}

                {{-- CONTACT PERSON --}}
                <div class="flex flex-col" x-show="openTab === 2"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>

                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="contactPerson" :value="__('Contact Person')" />
                            <x-text-input wire:model="contactPerson" class="block w-full mt-1" type="text" />
                            <x-input-error :messages="$errors->get('contactPerson')" class="mt-2" />

                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="contactPosition" :value="__('Position')" />
                            <x-text-input wire:model="contactPosition" class="block w-full mt-1" type="text" />
                            <x-input-error :messages="$errors->get('contactPosition')" class="mt-2" />

                        </div>
                    </div>

                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="contactEmail" :value="__('E-mail Address')" />
                            <x-text-input wire:model="contactEmail" class="block w-full mt-1" type="email" />
                            <x-input-error :messages="$errors->get('contactEmail')" class="mt-2" />
                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="contactTel" :value="__('Telephone No.')" />
                            <x-text-input wire:model="contactTnum" class="block w-full mt-1" type="tel" />
                            <x-input-error :messages="$errors->get('contactTnum')" class="mt-2" />
                        </div>

                    </div>

                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="contactMobile" :value="__('Mobile No.')" />
                            <x-text-input wire:model="contactPnum" class="block w-full mt-1" type="tel" />
                            <x-input-error :messages="$errors->get('contactPnum')" class="mt-2" />
                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="contactFax" :value="__('Fax No.')" />
                            <x-text-input wire:model="contactFnum" class="block w-full mt-1" type="tel" />
                            <x-input-error :messages="$errors->get('contactFnum')" class="mt-2" />
                        </div>

                    </div>
                    <div class="flex flex-row mt-4">

                        <x-blue-button wire:target="saveContact" wire:loading.attr="disabled"
                            wire:click.prevent="saveContact" class="ml-auto mr-3" type="button"
                            x-data="" {{-- x-on:click.prevent="$dispatch('open-modal', 'jobTag-modal')"> x-on:click.prevent="saveDetails(general)" --}}>
                            Save
                            <div wire:loading.delay.long wire:target="saveContact" role="status">
                                <svg aria-hidden="true" class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
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
                {{-- CONTACT PERSON --}}

                {{-- INDUSTRY --}}
                <div class="flex flex-col" x-show="openTab === 3"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>

                    <div class="flex flex-row w-full gap-4 my-4 mt-4">
                        <div class="flex flex-col w-full">

                            <div class="flex flex-row items-center w-full">

                                <x-input-label for="fname"> </i>Industry Preference
                                </x-input-label>

                                <x-primary-button class="ml-auto mr-3" type="button" x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'industry-modal')">
                                    Add Industry Preference
                                </x-primary-button>

                            </div>

                            <div class="p-1 mt-2 border border-gray-300 rounded-lg flex-inline">


                                @foreach ($employerDetails->company_industry_line as $industryLine)
                                    <span
                                        class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $industryLine->job_industry->industry_Title }}
                                        <button
                                            wire:click.prevent="removeIndustry({{ $industryLine->company_industry_line_id }})"
                                            type="button"
                                            class="inline-flex items-center justify-center flex-shrink-0 rounded-full size-4 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 focus:text-blue-500">
                                            <span class="sr-only">Remove badge</span>
                                            <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M18 6 6 18" />
                                                <path d="m6 6 12 12" />
                                            </svg>
                                        </button>
                                    </span>
                                @endforeach

                            </div>
                            <x-input-error :messages="$errors->get('industrypreference')" class="mt-2" />

                        </div>
                    </div>


                </div>

                <div class="flex flex-col" x-show="openTab === 4"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>
                    <div class="flex flex-col w-full gap-4 my-4 mt-4">



                        @foreach ($requirements as $requirement)
                            <div class="flex flex-col w-full gap-2 lg:flex-row md:gap-4">

                                @if ($requirement->requirementPassed)
                                    <div class="flex flex-col w-full">
                                        <button
                                            wire:click.prevent='viewFile({{ $requirement->requirementPassed->req_passed_id }})'
                                            type="button"
                                            class="text-blue-900 bg-blue-400 hover:bg-blue-100 border border-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2">
                                            <i class="fa-solid fa-file-contract me-2"></i>
                                            View {{ $requirement->requirement_Title }}
                                            <svg class="w-6 h-6 ml-auto mr-0" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01" />
                                            </svg>
                                        </button>
                                        @php
                                            $oneYearAgo = now()->subYear()->format('Y-m-d');
                                        @endphp

                                        <div x-data="{
                                            updatedAt: '{{ $requirement->requirementPassed->updated_at->format('Y-m-d') }}',
                                            isOld: new Date('{{ $requirement->requirementPassed->updated_at->format('Y-m-d') }}') < new Date('{{ $oneYearAgo }}')
                                        }">
                                            <p x-bind:class="{ 'text-red-500': isOld, 'text-gray-800': !isOld }"
                                                class="text-sm">
                                                Last updated:
                                                {{ $requirement->requirementPassed->updated_at->format('F j, Y') }}
                                            </p>
                                        </div>


                                    </div>
                                @else
                                    <div class="flex flex-col w-full">
                                        <div
                                            class="text-red-900 bg-red-400 border border-red-500 focus:ring-4 focus:outline-none focus:ring-red-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2">
                                            <i class="fa-solid fa-file-contract me-2"></i>
                                            You have not uploaded {{ $requirement->requirement_Title }}.
                                            <svg class="w-6 h-6 ml-auto mr-0" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                                <div class="flex flex-col w-full h-full">
                                    <div class="flex flex-row items-center justify-center w-full h-full gap-2">
                                        <div class="flex flex-col w-full">
                                            <input wire:model='req.{{ $requirement->requirement_id }}'
                                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                                aria-describedby="file_input_help" id="file_input" type="file">

                                        </div>

                                        <div wire:loading.delay.long
                                            wire:target="req.{{ $requirement->requirement_id }}" role="status">
                                            <svg aria-hidden="true"
                                                class="w-6 h-6 ml-4 text-gray-200 animate-spin fill-blue-600"
                                                viewBox="0 0 100 101" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                    fill="currentFill" />
                                            </svg>
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>

                                    <p class="mt-1 text-sm text-gray-500" id="file_input_help">PDF ONLY
                                        (MAX
                                        5MB)
                                        .
                                    </p>
                                    <x-input-error :messages="$errors->get('req.' . $requirement->requirement_id)" class="mt-2" />
                                </div>
                            </div>
                        @endforeach


                        <x-blue-button wire:target="req, saveReq" wire:loading.attr="disabled"
                            wire:click.prevent="saveReq" class="ml-auto mr-3" type="button"
                            x-data="">
                            Save
                            <div wire:loading.delay.long wire:target="pimg, saveProfile" role="status">
                                <svg aria-hidden="true" class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
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

                <div class="flex flex-col" x-show="openTab === 5"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>


                    <div class="relative mt-4">

                        <div
                            class="flex flex-wrap items-center justify-between p-1 pb-4 space-y-4 flex-column md:flex-row md:space-y-0">

                            <label for="table-search" class="sr-only">Search</label>


                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                {{-- SEARCH --}}
                                <input type="search" wire:model.live='search'
                                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Search for partnerships">
                            </div>

                            {{-- ADD BUTTON --}}
                            <div class="inline-flex">
                                <x-primary-button type="button"
                                    class="bg-blue-400 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900"
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'partnership-apply-modal')">
                                    Apply For Partnership</x-primary-button>
                            </div>

                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-2 lg:px-6 lg:py-3">
                                            PESO Municipality
                                        </th>
                                        <th scope="col" class="hidden px-4 py-2 lg:table-cell lg:px-6 lg:py-3">
                                            Status
                                        </th>
                                        <th scope="col" class="hidden px-4 py-2 lg:table-cell lg:px-6 lg:py-3">
                                            Partnership Date
                                        </th>
                                        <th scope="col" class="px-4 py-2 lg:px-6 lg:py-3">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($partnerships->isEmpty())
                                        <tr>
                                            <td colspan="4">
                                                <div class="flex flex-col items-center justify-center mt-24 mb-24">
                                                    <div class="p-6 bg-gray-100 rounded-full">
                                                        <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-width="2"
                                                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                        </svg>
                                                    </div>
                                                    <p class="mt-2 text-xl font-bold text-center text-black">
                                                        No Records Found!
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($partnerships as $data)
                                            <tr class="bg-white border-b hover:bg-gray-50">
                                                <td class="px-4 py-2 lg:px-6 lg:py-4">
                                                    <div class="text-lg font-bold text-black uppercase">
                                                        {{ $data->peso->municipality->municipality_Name }}
                                                    </div>
                                                    <div class="text-gray-500 lg:hidden">
                                                        <span class="block text-sm">Status:
                                                            @if ($data->partnership_Status == 'PENDING')
                                                                <span
                                                                    class="font-semibold text-yellow-800">PENDING</span>
                                                            @elseif ($data->partnership_Status == 'APPROVED')
                                                                <span
                                                                    class="font-semibold text-green-800">ACTIVE</span>
                                                            @elseif ($data->partnership_Status == 'REJECTED' || $data->partnership_Status == 'CANCELLED')
                                                                <span
                                                                    class="font-semibold text-red-800">{{ $data->partnership_Status }}</span>
                                                            @endif
                                                        </span>
                                                        <span class="block text-sm">Partnership Date:
                                                            @if ($data->responded_at)
                                                                {{ $data->responded_at->format('F j, Y') }}
                                                            @else
                                                                <span class="font-semibold">PENDING</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </td>

                                                <td class="hidden px-4 py-2 lg:table-cell lg:px-6 lg:py-4">
                                                    <div class="font-bold text-black">
                                                        @if ($data->partnership_Status == 'PENDING')
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-sm font-medium text-yellow-800 bg-yellow-200 rounded-md ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                                                        @elseif ($data->partnership_Status == 'APPROVED')
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-sm font-medium text-green-800 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">ACTIVE</span>
                                                        @elseif ($data->partnership_Status == 'REJECTED' || $data->partnership_Status == 'CANCELLED')
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-sm font-medium text-red-800 uppercase bg-red-200 rounded-md ring-1 ring-inset ring-red-600/20">{{ $data->partnership_Status }}</span>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td class="hidden px-4 py-2 lg:table-cell lg:px-6 lg:py-4">
                                                    <div class="text-gray-500 text-md">
                                                        @if ($data->responded_at)
                                                            {{ $data->responded_at->format('F j, Y') }}
                                                        @else
                                                            <div class="flex items-center font-semibold">
                                                                <div
                                                                    class="h-2.5 w-2.5 rounded-full bg-yellow-500 me-2">
                                                                </div>
                                                                PENDING
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td class="px-4 py-2 lg:px-6 lg:py-4">
                                                    <div class="flex flex-row items-center justify-center gap-6">
                                                        @if ($data->partnership_Status != 'PENDING')
                                                            <div x-data="{ tooltip: 'View Partnership Information' }">
                                                                <button
                                                                    wire:click.prevent="viewPartnership({{ $data->partnership_id }})"
                                                                    x-tooltip="tooltip" type="button"
                                                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                                    <svg class="w-5 h-5"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" fill="currentColor">
                                                                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                                        <path fill-rule="evenodd"
                                                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>

                                                                </button>
                                                            </div>
                                                        @endif
                                                        @if (in_array($data->partnership_Status, ['CANCELLED', 'REJECTED']))
                                                            <div x-data="{ tooltip: 'Reapply Partnership' }">
                                                                <button x-tooltip="tooltip" type="button"
                                                                    wire:click.prevent='reapplyClick({{ $data->partnership_id }})'
                                                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-green-700 border border-green-700 rounded-lg hover:bg-green-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-green-300">

                                                                    <svg class="w-5 h-5"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" fill="currentColor">
                                                                        <path fill-rule="evenodd"
                                                                            d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>


                                                                </button>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <div class="mt-4">
                                {{ $partnerships->links('vendor.livewire.tailwind', data: ['scrollTo' => false]) }}
                            </div>

                        </div>
                    </div>


                </div>

            </div>








        </div>
    </div>


    <livewire:modals.industry-modal />

    <x-modal name="partnership-info-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Partnership Details') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">
                <div class="flex flex-col w-full mt-2">
                    <x-input-label :value="__('Remarks')" />
                    <textarea rows="4"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none"
                        readonly>{{ $partnershipRemarks ?? 'No remarks found.' }}</textarea>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'partnership-info-modal')" type="button">
                    {{ __('Close') }}
                </x-secondary-button>

            </div>
        </div>
    </x-modal>


    <x-modal name="partnership-apply-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6" x-data="{ agreeBox: @entangle('agreeBox') }">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Apply for Partnership') }}
            </h2>
            <hr class="my-4">

            <div class="flex flex-col w-full mt-4">
                <x-input-label for="municipality" :value="__('PESO Municipality')" />
                <x-dropdown align="left" width="full">
                    <x-slot name="trigger">
                        <button
                            class="mt-1 inline-flex h-full items-center text-gray-800 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-md px-1.5 py-2 w-full">
                            <div class="w-full ml-2 font-mono text-xl font-extrabold text-left">
                                {{ $selMun && $selProv ? $selMun . ', ' . $selProv : 'Select a Municipality' }}
                            </div>
                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <!-- Search input -->
                        <div class="p-2">
                            <input wire:model.live='searchMun' type="search" placeholder="Search..."
                                class="block w-full px-3 py-1.5 mb-2 border border-gray-300 rounded-md focus:outline-none"
                                @click.stop>
                        </div>

                        <!-- Dropdown content with scrollbar -->
                        <div class="max-h-[300px] bg-white overflow-y-auto">
                            <!-- Dropdown links -->
                            @foreach ($pesoNotInPartnerships as $data)
                                <x-dropdown-link wire:click.prevent='selectBranch({{ $data->peso_id }})'
                                    class="block px-4 py-2 uppercase cursor-pointer hover:bg-gray-100">
                                    {{ $data->municipality->municipality_Name }},
                                    {{ $data->municipality->province->province_Name }}
                                </x-dropdown-link>
                            @endforeach
                        </div>
                    </x-slot>
                </x-dropdown>
                <x-input-error :messages="$errors->get('selID')" class="mt-2" />

                <div class="flex items-center mt-8 space-x-3 lg:mx-24 ">
                    <input wire:model="agreeBox" type="checkbox" id="agreeBox"
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="agreeBox" class="text-sm font-light text-gray-700">
                        By confirming, you acknowledge that the PESO municipality selected will have access to the
                        company’s
                        information and agree to proceed with the partnership application.
                    </label>
                </div>

            </div>

            <div class="flex justify-end mt-8">
                <x-secondary-button wire:click.prevent="closeModal('partnership-apply')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button x-bind:disabled="!agreeBox" wire:click.prevent='applyPartnership' class="ms-3"
                    type="button">
                    {{ __('Apply Partnership') }}
                    <div wire:loading.delay.long wire:loading.attr="disabled" wire:target="applyPartnership"
                        role="status">
                        <svg aria-hidden="true" class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
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
                </x-primary-button>
            </div>
        </div>
    </x-modal>


    <x-modal name="partnership-reapply-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 mx-auto bg-white border border-gray-200 rounded-lg shadow-lg"
            x-data="{ agreeBox: @entangle('agreeBox') }">
            <h2 class="text-xl font-semibold text-gray-900">
                {{ __('Reapply for Partnership') }}
            </h2>
            <hr class="my-4 border-gray-300">

            <div class="flex flex-col w-full mt-4 space-y-4">
                <p class="items-center text-lg font-bold text-black">
                    Are you sure you want to reapply to this municipality?
                </p>

                <div class="flex items-center mt-8 space-x-3 lg:mx-24 ">
                    <input wire:model="agreeBox" type="checkbox" id="agreeBox"
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="agreeBox" class="text-sm font-light leading-tight text-gray-700">
                        By confirming, you acknowledge that the PESO municipality selected will have access to the
                        company’s information and agree to proceed with the partnership application.
                    </label>
                </div>
            </div>

            <div class="flex justify-end mt-8 space-x-4">
                <x-secondary-button wire:click.prevent="closeModal('partnership-reapply')"
                    class="text-gray-800 transition-colors duration-300 bg-gray-200 hover:bg-gray-300">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button x-bind:disabled="!agreeBox" wire:loading.attr="disabled"
                    wire:click.prevent='reapplyPartnership'
                    class="text-white transition-transform transform bg-blue-500 hover:bg-blue-600 hover:scale-105 ms-3"
                    type="button">
                    {{ __('Apply Partnership') }}
                    <div wire:loading.delay.long wire:target="reapplyPartnership" role="status">
                        <svg aria-hidden="true" class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
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
                </x-primary-button>
            </div>
        </div>
    </x-modal>


</div>


@push('scripts')
    @script
        <script>
            Livewire.on('viewFile', event => {
                // Check if the event is an array and has at least one element
                if (Array.isArray(event) && event.length > 0) {
                    // Access the first element and then its properties
                    const data = event[0]; // Assuming the data object is the first element

                    // Extract URL and handle dynamic keys
                    const url = data.url;
                    const formData = {
                        ...data
                    }; // Spread the data object to use for form inputs

                    // Check if URL is present
                    if (url) {
                        // Create and configure the form element
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;
                        form.target = '_blank';

                        // Add CSRF token as a hidden input
                        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;
                        form.appendChild(csrfInput);

                        // Add all data inputs dynamically
                        for (const [key, value] of Object.entries(formData)) {
                            // Skip the URL and CSRF token from being added as form inputs
                            if (key !== 'url') {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = key;
                                input.value = value;
                                form.appendChild(input);
                            }
                        }

                        // Append form to the body and submit
                        document.body.appendChild(form);
                        form.submit();

                        // Clean up by removing the form element
                        document.body.removeChild(form);
                    } else {
                        console.error('URL not found in event data');
                    }
                } else {
                    console.error('Event is not in the expected format');
                }
            });
        </script>
    @endscript
@endpush
