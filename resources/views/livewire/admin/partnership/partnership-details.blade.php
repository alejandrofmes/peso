<div wire:poll class="container mx-auto py-8">
    <div class="grid grid-cols-4 lg:grid-cols-12 gap-4 p-3 lg:p-0">

        {{-- TITLE --}}
        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Patnerships \ Employer Details</h1>
        </div>
        {{-- PROFILE CONTAINER --}}
        <div class="col-span-4 lg:col-span-4 ">
            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex flex-col items-center">
                    {{-- IMAGE --}}
                    <img src="{{ asset('storage/' . $partnersData->company->company_img) }}"
                        class="w-32 h-32 bg-gray-300 rounded-lg mb-4 shrink-0 grow-0 object-cover shadow-xl shadow-rounded-lg">

                    </img>

                    <h1 class="text-xl font-bold uppercase"> {{ $partnersData->company->business_Name }}
                    </h1>
                    <p class="text-gray-700">#{{ $partnersData->company->company_id }}</p>
                </div>

                <hr class="my-6 border-t border-gray-300">

                <div class="flex flex-col">

                    <span class="text-gray-700 uppercase font-black tracking-wider mb-2 text-xl">Contact Details</span>

                    <ul>
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Contact Person:</li>
                            <p class="ms-4 text-right">{{ $partnersData->company->contact_Person }}</p>
                        </div>
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Position:</li>
                            <p class="ms-4 text-right">{{ $partnersData->company->contact_Person_position }}</p>
                        </div>

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Phone Number:</li>
                            <p class="ms-4 text-right">{{ $partnersData->company->company_Pnum }}</p>
                        </div>

                        @if ($partnersData->company->company_Tnum)
                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">Telephone Number:</li>
                                <p class="ms-4 text-right">{{ $partnersData->company->company_Tnum }}</p>
                            </div>
                        @endif

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Email:</li>
                            <p class="ms-4 text-right">{{ $partnersData->company->company_Email }}</p>
                        </div>

                        @if ($partnersData->company->company_Fnum)
                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">Fax:</li>
                                <p class="ms-4" text-right>{{ $partnersData->company->company_Fnum }}</p>
                            </div>
                        @endif

                        {{-- <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Address:</li>
                            <p class="ms-4 uppercase text-right"> {{ $partnersData->company->company_Address }},
                                {{ $partnersData->company->barangay->barangay_Name }},
                                {{ $partnersData->company->barangay->municipality->municipality_Name }},
                                {{ $partnersData->company->barangay->municipality->province->province_Name }}</p>
                        </div> --}}

                    </ul>

                </div>

            </div>

            <div class="bg-white shadow rounded-lg p-6 flex flex-col mt-4">
                {{-- TITLE --}}
                <h1 class="text-2xl font-bold ">Industry Line</h1>
                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                <div class="flex flex-col w-full">

                    {{-- BADGE CONTAINER --}}
                    <div id= "otherSkillRow" class="flex-inline border border-gray-300 rounded-lg p-1 ">

                        {{-- BADGE --}}
                        @foreach ($partnersData->company->company_industry_line as $data)
                            <span
                                class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $data->job_industry->industry_Title }}
                            </span>
                        @endforeach

                    </div>
                </div>



            </div>

            <div class="bg-white shadow rounded-lg p-6 flex flex-col mt-4">

                <h1 class="text-2xl font-bold ">Requirements</h1>
                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                <div class="flex flex-row flex-wrap mt-4 w-full gap-2">
                    @foreach ($requirements as $requirement)
                        @if ($requirement->requirementPassed)
                            <div class="flex flex-col w-full ">
                                <button
                                    wire:click.prevent='viewFile({{ $requirement->requirementPassed->req_passed_id }})'
                                    type="button"
                                    class="text-blue-900 bg-blue-400 hover:bg-blue-100 border border-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2">
                                    <i class="fa-solid fa-file-contract me-2"></i>
                                    View {{ $requirement->requirement_Title }}
                                    <svg class="ml-auto mr-0 w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
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
                                    No uploaded {{ $requirement->requirement_Title }}.

                                    <svg class="ml-auto mr-0 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>

                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>


        </div>

        {{-- CONTAINER FOR TABS --}}
        <div class="col-span-4 lg:col-span-8 row">



            {{-- 1ST TAB --}}



            <div class="bg-white shadow rounded-lg p-6">
                <h1 class="text-2xl font-bold ">Company Details</h1>
                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                <div class="flex flex-col lg:flex-row gap-2 lg:gap-4 mt-4 w-full">
                    <div class="flex flex-col w-full">
                        <x-input-label for="bname" :value="__('Business Name')" />
                        <x-text-input wire:model="businessName" class="block mt-1 w-full" type="text" disabled />
                        <x-input-error :messages="$errors->get('businessName')" class="mt-2" />

                    </div>
                    <div class="flex flex-col w-full">
                        <x-input-label for="tname" :value="__('Trade Name')" />
                        <x-text-input wire:model="tradeName" class="block mt-1 w-full" type="text" disabled />
                        <x-input-error :messages="$errors->get('tradeName')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row gap-2 lg:gap-4 mt-4 w-full">
                    <div class="flex flex-col w-full">
                        <x-input-label for="tin" :value="__('TIN')" />
                        <x-text-input wire:model="tin" class="block mt-1 w-full" type="text" disabled />
                        <x-input-error :messages="$errors->get('tin')" class="mt-2" />
                    </div>

                    <div class="flex flex-col w-full">
                        <x-input-label for="loctype" :value="__('Location Type')" />
                        <select wire:model="locType" class="block mt-1 w-full rounded-md" disabled>
                            <option value="" disabled selected>Select Location Type</option>
                            <option value="1">Main</option>
                            <option value="2">Branch</option>
                        </select>
                        <x-input-error :messages="$errors->get('loctype')" class="mt-2" />
                    </div>

                    <div class="flex flex-col w-full">
                        <x-input-label for="workforce" :value="__('Total Work Force')" />
                        <select wire:model="workforce" class="block mt-1 w-full rounded-md" disabled>
                            <option value="" disabled selected>Select Total Work Force</option>
                            <option value="1">1 - 9 (Micro)</option>
                            <option value="2">10 - 99 (Small)</option>
                            <option value="3">100 - 199 (Medium)</option>
                            <option value="4">200 and Over (Large)</option>

                        </select>
                        <x-input-error :messages="$errors->get('workforce')" class="mt-2" />

                    </div>
                </div>

                <div class="flex flex-col lg:flex-row gap-2 lg:gap-4 mt-4 w-full">
                    <div class="flex flex-col w-full">
                        <x-input-label for="empType" :value="__('Employer Type')" />
                        <select wire:model='empType' class="block mt-1 w-full rounded" disabled>
                            <option value="" disabled selected>Select Employer Type</option>
                            <option value="1">Public</option>
                            <option value="2">Private</option>
                        </select>
                        <x-input-error :messages="$errors->get('empType')" class="mt-2" />


                    </div>
                    <div class="flex flex-col w-full">
                        <x-input-label for="empDesc" :value="__('Description')" />
                        <select wire:model='empDesc' class="block mt-1 w-full rounded" disabled>
                            <option value="" disabled selected>Select Description</option>
                            <option value="1">National Government Agency</option>
                            <option value="2">Local Government Unit</option>
                            <option value="3">Government-owned and Controlled Corporation</option>
                            <option value="4">State/Local University or College</option>
                            <option value="5">Direct Hire</option>
                            <option value="6">Private Employment Agency</option>
                            {{-- <option value="7">Overseas Recruitment Agency</option> --}}
                            <option value="8">'D.O. 174, s. 2017</option>
                        </select>
                        <x-input-error :messages="$errors->get('empDesc')" class="mt-2" />

                    </div>
                </div>


                <div class="flex flex-col lg:flex-row gap-2 lg:gap-4 mt-4 w-full">
                    <div class="flex flex-col w-full">
                        <x-input-label for="companyAddress" :value="__('Company Address')" />
                        <x-text-input wire:model="companyAddress" class="block mt-1 w-full" type="text"
                            disabled />
                        <x-input-error :messages="$errors->get('companyAddress')" class="mt-2" />

                    </div>
                    <div class="flex flex-col w-full">
                        <x-input-label for="city" :value="__('Barangay')" />
                        <x-text-input wire:model='bar' class="block mt-1 w-full" type="text" disabled />
                        <x-input-error :messages="$errors->get('bar')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row gap-2 lg:gap-4 mt-4 w-full">
                    <div class="flex flex-col w-full">
                        <x-input-label for="mun" :value="__('Municipality')" />
                        <x-text-input wire:model='mun' class="block mt-1 w-full" type="text" disabled />
                        <x-input-error :messages="$errors->get('mun')" class="mt-2" />
                    </div>
                    <div class="flex flex-col w-full">
                        <x-input-label for="province" :value="__('Province')" />
                        <x-text-input wire:model='prov' class="block mt-1 w-full" type="text" disabled />
                        <x-input-error :messages="$errors->get('prov')" class="mt-2" />
                    </div>
                </div>

                @if ($partnersData->partnership_Status == 'PENDING')
                    <div class="flex flex-row mt-10">
                        <div class="flex flex-row w-full justify-end">
                            <x-danger-button class="w-[100px] justify-center me-2 mb-2" type="button"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'reject-modal')">Reject</x-danger-button>
                            <x-green-button type="button" class="w-[100px] justify-center me-2 mb-2"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'approve-modal')">Approve</x-green-button>
                        </div>
                    </div>
                @endif




            </div>

            @if ($partnersData->partnership_Status != 'PENDING')
                <div class="bg-white shadow rounded-lg p-6 mt-4">
                    <div class="flex lg:flex-row gap-4 lg:justify-between">
                        <h1 class="text-2xl font-bold ">Partnership Details</h1>

                        @if ($partnersData->partnership_Status == 'PENDING')
                            <span
                                class="inlineflex items-center rounded-md bg-yellow-200 px-2 py-1 text-sm font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                        @elseif ($partnersData->partnership_Status == 'APPROVED')
                            <span
                                class="inline-flex items-center rounded-md bg-green-200 px-2 py-1 text-sm font-medium text-green-800 ring-1 ring-inset ring-green-600/20">ACTIVE</span>
                        @elseif ($partnersData->partnership_Status == 'REJECTED' || $partnersData->partnership_Status == 'CANCELLED')
                            <span
                                class="inline-flex items-center rounded-md bg-red-200 px-2 py-1 text-sm font-medium text-red-800 ring-1 ring-inset ring-red-600/20 uppercase">{{ $partnersData->partnership_Status }}</span>
                        @endif
                    </div>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                    <div class="flex flex-col w-full">
                        <div class="flex lg:flex-row gap-4 lg:justify-between">
                            <h1 class="text-md font-semibold">Partnership Remarks</h1>
                            <h1 class="text-md ">{{ $partnersData->responded_at->format('F j, Y') }}</h1>

                        </div>
                        <div
                            class="mt-2 h-[200px] overflow-auto block p-2.5 w-full text-md text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none">

                            {{ $partnersData->partnership_Remarks }}

                        </div>
                    </div>




                </div>
            @endif


        </div>
    </div>



    {{-- APPROVE MODAL --}}
    <x-modal name="approve-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center border-b">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to approve this partnership?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">
                <div class="flex flex-col mt-2 w-full">
                    <x-input-label :value="__('Remarks')" />
                    <textarea wire:model='remarks' id="message" rows="4"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 "
                        placeholder="Write your remarks here..."></textarea>
                    <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click.prevent="close('approve-modal')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button
                    wire:click.prevent="updatePartnership({{ $partnersData->partnership_id }}, 'APPROVED', 'approve-modal')"
                    wire:loading.attr="disabled" class="ms-3" type="button">


                    {{ __('Approve Partnership') }}

                    <div wire:loading.delay.long wire:target='updatePartnership' role="status">
                        <svg aria-hidden="true" class="w-4 h-4 text-gray-200 animate-spin fill-blue-600 ml-4"
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




    {{-- REJECT MODAL --}}
    <x-modal name="reject-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to reject this partnership?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">
                <div class="flex flex-col mt-2 w-full">
                    <x-input-label :value="__('Remarks')" />
                    <textarea wire:model='remarks' id="message" rows="4"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 "
                        placeholder="Write your thoughts here..."></textarea>
                    <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                </div>

            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click.prevent="close('reject-modal')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled"
                    wire:click.prevent="updatePartnership({{ $partnersData->partnership_id }}, 'REJECTED', 'reject-modal')"
                    class="ms-3" type="button">
                    {{ __('Reject Application') }}
                    <div wire:loading.delay.long wire:target='updatePartnership' role="status">
                        <svg aria-hidden="true" class="w-4 h-4 text-gray-200 animate-spin fill-blue-600 ml-4"
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
                </x-danger-button>
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
