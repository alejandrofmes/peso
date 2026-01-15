<div class="flex flex-col w-full h-full gap-4">
    <h1 class="text-2xl font-bold">Company Information</h1>
    <span class="text-sm text-gray-600">Fields with * are required.</span>
    <div class="flex flex-col mt-5 lg:flex-row-reverse">
        <div class="flex flex-col items-center w-full">
            <div class="flex flex-col items-center">
                <x-input-label for="image" :value="__('Upload Company Logo')" />
                <div
                    class="flex items-center justify-center mt-2 overflow-hidden bg-gray-200 border border-gray-300 rounded-lg shrink-0 grow-0">
                    <!-- Display uploaded image here -->
                    @if ($cimg)
                        <img id="uploadedImage"
                            class="flex uploaded-image object-fill w-[200px] h-[200px] shrink-0 grow-0"
                            src="{{ $cimg->temporaryUrl() }}" alt="Uploaded Image" />
                    @else
                        <img id="uploadedImage"
                            class="flex uploaded-image object-fill  w-[200px] h-[200px] shrink-0 grow-0"
                            src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png "
                            alt="Uploaded Image" />
                    @endif
                </div>
            </div>
            <x-input-error :messages="$errors->get('cimg')" class="mt-2" />
            <div class="flex justify-center mt-4 w-160">
                <label for="imageUpload" wire:loading.attr="cimg" wire:target="cimg"
                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md cursor-pointer hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Upload Image
                    <div wire:loading.delay.long wire:target="cimg" role="status">
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
                <input wire:model='cimg' id="imageUpload" type="file"class="hidden" accept="image/*">
            </div>
        </div>
        <div class="flex flex-col w-full">


            <div class="flex flex-col w-full mt-4">
                <x-input-label for="businessname" :value="__('Business Name*')" />
                <x-text-input wire:model='business' class="block mt-1" type="text" />
                <x-input-error :messages="$errors->get('business')" class="mt-2" />

            </div>
            <div class="flex flex-col w-full mt-4">
                <x-input-label for="tradename" :value="__('Trade Name*')" />
                <x-text-input wire:model='trade' class="block mt-1" type="text" />
                <x-input-error :messages="$errors->get('trade')" class="mt-2" />
            </div>
            <div class="flex flex-col w-full gap-4 mt-4 lg:flex-row">
                <div class="flex flex-col w-full">
                    <x-input-label for="loctype" :value="__('Location Type*')" />
                    <select wire:model='locType' class="block w-full mt-1 rounded">
                        <option value="" disabled selected>Select Location Type</option>
                        <option value="1">Main</option>
                        <option value="2">Branch</option>
                    </select>
                    <x-input-error :messages="$errors->get('locType')" class="mt-2" />

                </div>
                <div class="flex flex-col w-full">
                    <x-input-label for="workforce" :value="__('Total Work Force*')" />
                    <select wire:model='workForce' class="block w-full mt-1 rounded">
                        <option value="" disabled selected>Select Total Work Force</option>
                        <option value="1">1 - 9 (Micro)</option>
                        <option value="2">10 - 99 (Small)</option>
                        <option value="3">100 - 199 (Medium)</option>
                        <option value="4">200 and Over (Large)</option>
                    </select>
                    <x-input-error :messages="$errors->get('workForce')" class="mt-2" />

                </div>
            </div>

            <div x-data="employmentHandler()">
                <div class="flex flex-col w-full gap-4 mt-4 lg:flex-row" @change-status.window="updateEmpDesc">
                    <div class="flex flex-col w-full lg:w-3/4">
                        <x-input-label for="empStatus" :value="__('Employer Type*')" />
                        <select wire:model='empType' class="block w-full mt-1 rounded" x-model="empType"
                            x-on:change="updateEmpDesc">
                            <option value="" disabled selected>Select Employer Type</option>
                            <option value="1">Public</option>
                            <option value="2">Private</option>
                        </select>
                        <x-input-error :messages="$errors->get('empType')" class="mt-2" />
                    </div>

                    <div class="flex flex-col w-full">
                        <x-input-label for="empDesc" :value="__('Description*')" />
                        <select wire:model='empDesc' class="block w-full mt-1 rounded" x-model="empDesc">
                            <option value="" disabled selected>Select Description</option>
                            <template x-for="desc in empDescriptions" :key="desc.value">
                                <option :value="desc.value" x-text="desc.text"></option>
                            </template>
                        </select>
                        <x-input-error :messages="$errors->get('empDesc')" class="mt-2" />
                    </div>
                </div>

                <!-- TIN Field - Hidden unless Private (empType == 2) -->
                <div class="flex flex-col w-full mt-4 " x-show="empType == 2">
                    <x-input-label for="TIN" :value="__('TIN*')" />
                    <x-text-input wire:model='tin' class="block mt-1" type="text" />
                    <x-input-error :messages="$errors->get('tin')" class="mt-2" />
                </div>
            </div>


            <x-input-label for="lineofIndustry" :value="__('Line of Industry*')" class="mt-4" />
            <div class="flex flex-row w-full">
                <div class="mt-2 flex-inline">


                    @foreach ($industryData as $industryData)
                        <span wire:key='jobPref-{{ $industryData['industry_id'] }}'
                            class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $industryData['industry_Title'] }}
                            <button wire:click.prevent='removeIndustry( {{ $industryData['industry_id'] }})'
                                type="button"
                                class="inline-flex items-center justify-center flex-shrink-0 rounded-full size-4 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 focus:text-blue-500">
                                <span class="sr-only">Remove badge</span>
                                <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 6 6 18" />
                                    <path d="m6 6 12 12" />
                                </svg>
                            </button>
                        </span>
                    @endforeach
                </div>
            </div>
            <x-input-error :messages="$errors->get('industryData')" class="mt-2" />
            <div class="flex flex-row mt-2">
                <div class="flex flex-row">
                    <button type="button" x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'industry-modal')"
                        class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">
                        ADD INDUSTRY
                    </button>
                </div>
            </div>


            <div class="flex flex-col w-full mt-4">
                <x-input-label for="presentAddress" :value="__('Address*')" />
                <x-text-input wire:model='address' class="block w-full mt-1" type="text"
                    placeholder="HOUSE/BUILDING NO,. STREET, VILLAGE" />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>
            <div class="flex flex-col w-full gap-4 mt-4">
                <div class="flex flex-col">
                    <x-input-label for="province" :value="__('Barangay*')" />
                    <x-text-input wire:model='bar' class="block mt-1 lg:w-2/3" type="text" readonly
                        x-data="" x-on:click.prevent="$dispatch('open-modal', 'barangay-modal')"
                        x-on:focus="$dispatch('open-modal', 'barangay-modal')" />
                    <x-input-error :messages="$errors->get('barangayID')" class="mt-2" />
                </div>

                <div class="flex flex-col">
                    <x-input-label for="province" :value="__('Municipality*')" />
                    <x-text-input wire:model='mun' class="block mt-1 lg:w-2/3" type="text" readonly />
                </div>

                <div class="flex flex-col">
                    <x-input-label for="province" :value="__('Province*')" />
                    <x-text-input wire:model='prov' class="block mt-1 lg:w-2/3" type="text" readonly />
                </div>
            </div>


        </div>




    </div>





    <div class="flex flex-row justify-end mt-4 space-x-4 lg:mt-auto lg:mb-4">

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
    <livewire:modals.barangay-modal />
    <livewire:modals.industry-modal />

    <script>
        function employmentHandler() {
            return {
                empType: '',
                empDesc: '',
                empDescriptions: [],

                updateEmpDesc() {
                    this.empDesc = ''; // Reset the empDesc value
                    this.empDescriptions = [];
                    if (this.empType === '1') { // '1' corresponds to 'employed'
                        this.empDescriptions = [{
                                text: 'National Government Agency',
                                value: 1
                            },
                            {
                                text: 'Local Government Unit',
                                value: 2
                            },
                            {
                                text: 'Government-owned and Controlled Corporation',
                                value: 3
                            },
                            {
                                text: 'State/Local University or College',
                                value: 4
                            }
                        ];
                    } else if (this.empType === '2') { // '2' corresponds to 'unemployed'
                        this.empDescriptions = [{
                                text: 'Direct Hire',
                                value: 5
                            },
                            {
                                text: 'Private Employment Agency',
                                value: 6
                            },
                            // {
                            //     text: 'Overseas Recruitment Agency',
                            //     value: 7
                            // },
                            {
                                text: 'D.O. 174, s. 2017',
                                value: 8
                            }
                        ];
                    }
                }
            }
        }
    </script>




</div>
