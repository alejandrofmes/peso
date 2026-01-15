<div class="container py-8 mx-auto">
    <style>
        #QrScanner {
            position: relative;
            /* Adjust as needed */
            width: 100%;
            /* Make sure it fits within the modal */
            height: 400px;
            /* Set a specific height if necessary */
            z-index: 10;
            /* Ensure it's above the modal background but below other modal content */
        }
    </style>
    <div class="grid grid-cols-4 gap-4 p-3 lg:grid-cols-12 lg:p-0">

        <div class="col-span-4 lg:col-span-12">

            {{-- TITLE --}}
            <h1 class="text-2xl font-bold">Training \ Training List \ Registrants</h1>
        </div>


        <div class="col-span-4 px-2 lg:px-0">
            <div class="p-6 bg-white rounded-lg shadow">

                <div class="flex flex-col items-center justify-center">
                    {{-- COMPANY IMAGE --}}
                    {{-- <img src="{{ asset('storage/' . $programInfo->program_pubmat) }}"
                        class="object-cover w-32 h-32 mb-4 bg-gray-300 rounded-md shadow-xl shrink-0">


                    </img> --}}

                    <h1 class="text-3xl font-bold text-center text-blue-500">{{ $programInfo->program_Title }}
                    </h1>

                    <div class="flex flex-row justify-between w-full mt-6">
                        <p class="text-gray-800 text-md">{{ $programInfo->program_Type }}</p>
                        <p class="text-sm text-gray-800">{{ $programInfo->created_at->format('F j, Y') }}</p>
                    </div>

                </div>

                {{-- DIVIDER --}}
                <hr class="my-6 border-t border-gray-300">

                <div class="flex flex-col">
                    {{-- JOB POSTING INFORMATION --}}
                    <span class="mb-2 font-bold tracking-wider text-gray-700 uppercase">Event
                        Details</span>



                    <ul>
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Program Host:</li>
                            <p class="break-all ms-4">{{ $programInfo->program_Host }}</p>
                        </div>

                        @if ($programInfo->program_Slots != null)
                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">Program Slots:</li>
                                <p class="break-all ms-4">
                                    {{ $attendeeOrCompletedCount = $programInfo->program_reg->whereIn('program_reg_Status', ['ATTENDEE', 'COMPLETED'])->count() }}/{{ $programInfo->program_Slots }}
                                </p>
                            </div>
                        @endif
                        {{-- @if ($programInfo->program_Status == 'CLOSED' || $programInfo->program_Status == 'COMPLETED')
                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">Program Slots:</li>
                                <p class="break-all ms-4">
                                    Full
                                </p>
                            </div>
                        @endif && $programInfo->program_Status == "ACTIVE" --}}
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Registration Deadline:</li>
                            <p class="break-all ms-4">{{ $programInfo->program_Deadline->format('F j, Y') }}</p>
                        </div>

                        @if ($programInfo->program_Datetime)
                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">Program Date:</li>
                                <span class="break-all">
                                    <p class="ms-4 ">{{ $programInfo->program_Datetime->format('F j, Y') }}</p>
                                    <p class="ms-4">{{ $programInfo->program_Datetime->format('g:i A') }}</p>
                                </span>

                            </div>
                        @endif
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Industry Tag</li>
                            <p class="break-all ms-4">{{ $programInfo->job_industry->industry_Title }}</p>
                        </div>

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Program Status:</li>
                            <p class="break-all ms-4">{{ $programInfo->program_Status }}</p>
                        </div>

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Location:</li>
                            <p class="break-all ms-4">{{ $programInfo->program_Location }}</p>
                        </div>

                    </ul>

                    {{-- JOB POST LINK --}}
                    <div class="flex flex-wrap justify-center gap-4 mt-6">
                        <x-blue-button wire:navigate
                            href="{{ route('admin-view-training', ['id' => $programInfo->program_id]) }}">View Training
                            Details</x-blue-button>
                        @if ($programInfo->program_Status === 'CLOSED')
                            <x-green-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'complete-modal')">Complete
                                Training</x-green-button>
                        @endif
                    </div>

                </div>

            </div>


            <div class="p-6 mt-4 bg-white rounded-lg shadow">

                <div class="flex flex-row w-full gap-4">

                    <div class="flex flex-col w-full">
                        <x-input-label for="fname"> </i> Job Position
                            Tags
                        </x-input-label>
                        <hr class="h-px my-1 bg-gray-200 border-0 dark:bg-gray-700">

                        {{-- JOB TAG CONTAINER --}}
                        <div id= "otherSkillRow" class="p-1 flex-inline">

                            @foreach ($programInfo->program_tags as $jobtags)
                                <span
                                    class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500 ">
                                    {{ $jobtags->job_positions->position_Title }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>


        </div>



        {{-- CONTAINER FOR TABS --}}
        <div class="col-span-4 px-2 lg:col-span-8 lg:px-0" x-data="{
            selectedJobseeker: @entangle('selectedJobseeker')
        }">
            {{-- APPLICATION LIST CONTAINER --}}
            <div x-show="!selectedJobseeker" class="p-6 bg-white rounded-lg shadow"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100">
                <div class="flex flex-row justify-between">
                    <h1 class="text-lg font-bold lg:text-2xl mb">Registrant List:
                        {{ $programInfo->program_reg_count }}</h1>
                    {{-- <h1 class="text-lg font-bold lg:text-2xl mb">Registered: {{ $programInfo->program_reg_count }}</h1> --}}
                    <x-primary-button wire:click.prevent='scanQr'>QR Code</x-primary-button>

                </div>
                <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">

                <div class="relative ">
                    <div class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">

                        <div>

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
                                <input wire:model.live='search' type="search" id="table-search-users"
                                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Search for Applicants">
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 mr-3">

                            <div x-data="{ tooltip: 'Export to Excel' }">
                                <button x-tooltip='tooltip' type="button" wire:click.prevent='exportData'
                                    class="flex items-center py-1.5 px-4 text-xs lg:text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    <span class="mr-2">Export</span>
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </button>

                            </div>


                            <x-dropdown align="left" width="[150px]">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-xs lg:text-sm px-3 py-1.5">
                                        <div>
                                            {{ $filter }}
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
                                    <x-slot name="contentClasses">
                                        max-h-[300px] bg-white
                                    </x-slot>

                                    <x-dropdown-link class="cursor-pointer" wire:click.prevent="changeFilter('All')">
                                        All
                                    </x-dropdown-link>
                                    <x-dropdown-link class="cursor-pointer"
                                        wire:click.prevent="changeFilter('Registered')">
                                        Registered
                                    </x-dropdown-link>
                                    <x-dropdown-link class="cursor-pointer"
                                        wire:click.prevent="changeFilter('Completed')">
                                        Completed
                                    </x-dropdown-link>
                                    <x-dropdown-link class="cursor-pointer"
                                        wire:click.prevent="changeFilter('Others')">
                                        Others
                                    </x-dropdown-link>




                                </x-slot>
                            </x-dropdown>
                            <x-dropdown align="left" width="[150px]">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-xs lg:text-sm px-3 py-1.5">
                                        <div>
                                            {{ $sortDate === 'ASC' ? 'Oldest' : ($sortDate == 'DESC' ? 'Newest' : 'Sort by Date') }}

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
                                    <x-slot name="contentClasses">
                                        max-h-[300px] bg-white
                                    </x-slot>

                                    <x-dropdown-link class="cursor-pointer" wire:click.prevent="updateSort('DESC')">
                                        Newest
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <x-dropdown-link class="cursor-pointer" wire:click.prevent="updateSort('ASC')">
                                        Oldest
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                    </div>

                    {{-- APPLICANT LIST TABLE --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                        Registered Date
                                    </th>
                                    <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($programRegistrants->isEmpty())
                                    <tr>
                                        <td colspan="4">
                                            <div class="flex flex-col items-center justify-center mt-20 mb-20">
                                                <div class="flex p-1 bg-gray-100 rounded-full">
                                                    <svg class="w-16 h-16 text-black" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M21 21l-3.5-3.5m0 0a7 7 0 1 1-9-10.5 7 7 0 0 1 9 10.5z" />
                                                    </svg>
                                                </div>
                                                <div class="mt-2 text-xl font-semibold text-center text-black">
                                                    No Registrants Found
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($programRegistrants as $data)
                                        <tr wire:key='reg-{{ $data->program_reg_id }}'
                                            class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row"
                                                class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                                <img class="object-cover w-10 h-10 rounded-full shadow-xl"
                                                    src="{{ asset('storage/' . $data->employee->pimg) }}"
                                                    alt="user-{{ $data->employee->employee_id }}">
                                                <div class="ps-3 text-wrap">
                                                    <div class="text-base font-semibold">{{ $data->employee->fname }}
                                                        {{ $data->employee->lname }}</div>
                                                    <div class="flex-col hidden text-sm text-gray-500 lg:flex ">
                                                        {{ $data->employee->barangay->barangay_Name }},
                                                        {{ $data->employee->barangay->municipality->municipality_Name }}</span>
                                                    </div>

                                                    <div class="text-sm font-normal text-gray-500 uppercase lg:hidden">
                                                        {{ $data->employee->barangay->barangay_Name }},
                                                        {{ $data->employee->barangay->municipality->municipality_Name }}
                                                    </div>
                                                    <div class="text-sm font-normal text-gray-500 uppercase lg:hidden">
                                                        <span>{{ $data->created_at->format('g:i A') }}</span>
                                                        <span>{{ $data->created_at->format('F j, Y') }}</span>
                                                    </div>
                                                    <div class="text-sm font-normal text-gray-500 uppercase lg:hidden">
                                                        @if ($data->program_reg_Status == 'REGISTERED')
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-200 rounded-md ring-1 ring-inset ring-yellow-600/20">REGISTERED</span>
                                                        @elseif ($data->program_reg_Status == 'COMPLETED')
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">COMPLETED</span>
                                                        @elseif ($data->program_reg_Status == 'ATTENDEE')
                                                            @if ($programInfo->program_Status == 'COMPLETED')
                                                                <span
                                                                    class="inline-flex items-center px-2 py-1 text-sm font-medium text-yellow-800 bg-yellow-200 rounded-md ring-1 ring-inset ring-yellow-600/20">
                                                                    ATTENDEE
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="inline-flex items-center px-2 py-1 text-sm font-medium text-green-800 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">
                                                                    ATTENDEE
                                                                </span>
                                                            @endif
                                                        @elseif ($data->program_reg_Status == 'CANCELLED')
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-800 bg-red-200 rounded-md ring-1 ring-inset ring-red-600/20">CANCELLED</span>
                                                        @endif
                                                    </div>

                                            </th>
                                            <td class="hidden px-6 py-4 lg:table-cell">
                                                <div class="flex flex-col text-base uppercase">
                                                    <span>{{ $data->created_at->format('g:i A') }}</span>
                                                    <span>{{ $data->created_at->format('F j, Y') }}</span>
                                                </div>
                                            </td>
                                            <td class="hidden px-6 py-4 lg:table-cell">
                                                <div class="text-sm">
                                                    @if ($data->program_reg_Status == 'REGISTERED')
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 text-sm font-medium text-yellow-800 bg-yellow-200 rounded-md ring-1 ring-inset ring-yellow-600/20">
                                                            REGISTERED
                                                        </span>
                                                    @elseif ($data->program_reg_Status == 'COMPLETED')
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 text-sm font-medium text-green-800 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">
                                                            COMPLETED
                                                        </span>
                                                    @elseif ($data->program_reg_Status == 'ATTENDEE')
                                                        @if ($programInfo->program_Status == 'COMPLETED')
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-sm font-medium text-yellow-800 bg-yellow-200 rounded-md ring-1 ring-inset ring-yellow-600/20">
                                                                ATTENDEE
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-sm font-medium text-green-800 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">
                                                                ATTENDEE
                                                            </span>
                                                        @endif
                                                    @elseif ($data->program_reg_Status == 'CANCELLED')
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 text-sm font-medium text-red-800 bg-red-200 rounded-md ring-1 ring-inset ring-red-600/20">
                                                            CANCELLED
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div x-data="{ tooltip: 'View Information' }">
                                                    <button
                                                        wire:click.prevent="getJobseeker({{ $data->program_reg_id }})"
                                                        x-tooltip="tooltip" type="button"
                                                        class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24" fill="currentColor">
                                                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                            <path fill-rule="evenodd"
                                                                d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>

                {{-- PAGINATION --}}

                <div>
                    {{ $programRegistrants->links('vendor.livewire.tailwind') }}
                </div>
            </div>



            <div x-show="selectedJobseeker" class="flex flex-col p-6 bg-white rounded-lg shadow"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-cloak>
                @if ($selectedJobseeker)
                    <div class="flex flex-row items-center gap-4">
                        <button @click="selectedJobseeker = null">
                            <div class="flex items-center p-1 transition-transform rounded-full hover:bg-gray-300">
                                <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                            </div>
                        </button>
                        <h2 class="text-lg font-bold lg:text-2xl">Job Seeker Information</h2>

                    </div>
                    <div class="px-2">
                        <div class="flex flex-row mt-2">
                            <div class="flex flex-col items-center">
                                <img src="{{ asset('storage/' . $jobseekerInfo->employee->pimg) }}"
                                    class="flex w-[190px] h-[150px] bg-gray-300 object-cover rounded-lg shrink-0 grow-0">
                                </img>
                            </div>
                            <div class="flex flex-col justify-center ml-4">
                                <div x-data="{ tooltip: 'View Profile' }">
                                    <a x-tooltip="tooltip"
                                        href="{{ route('jobseeker.profile', ['id' => $jobseekerInfo->employee->employee_id]) }}">
                                        <h1 class="text-2xl font-bold lg:text-4xl hover:text-blue-500">
                                            {{ $jobseekerInfo->employee->fname }}
                                            {{ $jobseekerInfo->employee->mname }}
                                            {{ $jobseekerInfo->employee->lname }}
                                        </h1>
                                    </a>
                                </div>
                                <h1 class="text-lg text-gray-600">
                                    {{ $jobseekerInfo->employee->barangay->municipality->municipality_Name }},
                                    {{ $jobseekerInfo->employee->barangay->municipality->province->province_Name }}
                                </h1>

                            </div>
                            <div class="flex-row hidden mt-0 mb-auto ml-auto mr-0 lg:flex">
                                @if ($isMatch === true)
                                    <span
                                        class="items-center px-2 py-1 text-sm font-medium text-green-800 bg-green-200 rounded-md inlineflex ring-1 ring-inset ring-green-600/20">MATCHES</span>
                                @else
                                    <span
                                        class="items-center px-2 py-1 text-sm font-medium text-yellow-800 bg-yellow-200 rounded-md inlineflex ring-1 ring-inset ring-yellow-600/20">NOT
                                        MATCH</span>
                                @endif
                            </div>
                        </div>
                        <hr class="mt-4">
                        <div class="flex flex-col mt-4">

                            <span class="mb-2 font-bold tracking-wider text-gray-700 uppercase">Jobseeker
                                Details</span>

                            <ul>

                                <div class="flex flex-row">
                                    <li class="mb-2 font-bold">Date Registered:</li>
                                    <p class="break-all ms-4">
                                        {{ $jobseekerInfo->created_at->format('F j, Y') }}
                                    </p>
                                </div>
                                <div class="flex flex-row ">
                                    <li class="mb-2 font-bold">Employment Status:</li>
                                    <p class="ms-4">
                                        @if ($jobseekerInfo->employee->empstatus == 1)
                                            Employed
                                        @else
                                            Unemployed
                                        @endif



                                    </p>
                                </div>
                                @if ($jobseekerInfo->responded_at)
                                    <div class="flex flex-row ">
                                        <li class="mb-2 font-bold">Confirmed Date:</li>
                                        <p class="ms-4">
                                            <span> {{ $jobseekerInfo->responded_at->format('g:i A') }}</span>
                                            <span> {{ $jobseekerInfo->responded_at->format('F j, Y') }}</span>
                                        </p>
                                    </div>
                                @endif


                                <div class="flex flex-row ">
                                    <p class="ms-4">

                                        {{-- @if ($applicantInfo->peso_Status === 'PENDING')
                                        Pending
                                    @elseif($applicantInfo->peso_Status === 'RECOMMENDED')
                                        Recommended
                                    @elseif($applicantInfo->peso_Status === 'REJECT')
                                        Not Recommended
                                    @endif --}}

                                    </p>
                                </div>
                                <div class="flex flex-col w-full mt-1">
                                    <li class="mb-1 font-bold">Industry Preference:</li>
                                    {{-- BADGE CONTAINER --}}
                                    <div id= "otherSkillRow" class="p-1 flex-inline">
                                        {{-- BADGE --}}

                                        @foreach ($jobseekerInfo->employee->industry_preference as $industryPref)
                                            <span wire:key='skills-{{ $industryPref->industry_preference_id }}'
                                                class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-2 ps-3 pe-3 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $industryPref->job_industry->industry_Title }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex flex-col w-full mt-1">
                                    <li class="mb-1 font-bold">Job Preference:</li>
                                    {{-- BADGE CONTAINER --}}
                                    <div id= "otherSkillRow" class="p-1 flex-inline">
                                        {{-- BADGE --}}

                                        @foreach ($jobseekerInfo->employee->job_preference as $jobPref)
                                            <span wire:key='skills-{{ $jobPref->job_preference_id }}'
                                                class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-2 ps-3 pe-3 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $jobPref->job_positions->position_Title }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex flex-col w-full mt-1">
                                    <li class="mb-1 font-bold">Skills:</li>
                                    {{-- BADGE CONTAINER --}}
                                    <div id= "otherSkillRow" class="p-1 flex-inline">
                                        {{-- BADGE --}}

                                        @foreach ($jobseekerInfo->employee->skills as $empSkills)
                                            <span wire:key='skills-{{ $empSkills->skills_id }}'
                                                class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-2 ps-3 pe-3 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $empSkills->skill_Type }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>


                            </ul>
                            <div class="flex flex-wrap justify-center gap-4 mt-2">
                                <div x-data="{ tooltip: 'View Profile' }">
                                    <a wire:navigate
                                        href="{{ route('jobseeker.profile', ['id' => $jobseekerInfo->employee->employee_id]) }}"
                                        x-tooltip="tooltip" type="button"
                                        class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">

                                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>

                                    </a>
                                </div>


                            </div>

                            @if ($jobseekerInfo->program_reg_Status == 'REGISTERED' && in_array($programInfo->program_Status, ['ACTIVE', 'CLOSED']))
                                <div class="flex flex-wrap justify-center gap-4 mt-6">

                                    <x-danger-button
                                        wire:click.prevent="confirmReg('CANCELLED', {{ $jobseekerInfo->program_reg_id }})"
                                        type="button">Decline</x-danger-button>

                                    <x-green-button
                                        wire:click.prevent="confirmReg('ATTENDEE', {{ $jobseekerInfo->program_reg_id }})"
                                        type="button">Confirm</x-green-button>


                                </div>
                            @endif
                            @if ($jobseekerInfo->program_reg_Status == 'ATTENDEE' && in_array($programInfo->program_Status, ['ACTIVE', 'CLOSED']))
                                <div class="flex flex-wrap justify-center gap-4 mt-6">
                                    <x-green-button
                                        wire:click.prevent="confirmReg('COMPLETED', {{ $jobseekerInfo->program_reg_id }})"
                                        type="button">Confirm Attendance</x-green-button>


                                </div>
                            @endif




                        </div>
                    </div>
                @endif
            </div>
        </div>






    </div>


    <x-modal name="qr-scanner-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Scan a QR Code') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center w-full h-full my-4">
                <div id="QrScanner" class="flex h-full"></div>
            </div>
            <div class="flex justify-between mt-6">
                <x-secondary-button wire:click.prevent='qrStop'>
                    {{ __('Cancel') }}
                </x-secondary-button>


            </div>
        </div>
    </x-modal>

    <x-modal name="complete-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center" x-data="{ agreeBox: @entangle('agreeBox') }">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col my-4">
                <div class="flex flex-col mt-4 mb-4 w-full justify-center items-center px-4">
                    <span class="text-xl font-semibold text-gray-800">
                        Are you sure you want to mark this program as completed?
                    </span>
                    <p class="mt-2 text-gray-600">
                        All registered users will be informed through their email.
                    </p>

                </div>


                <div class="inline-flex justify-center items-center mt-4 w-full">
                    <label class="relative flex items-center p-3 rounded-full cursor-pointer" for="agreeBox">
                        <input wire:model="agreeBox" type="checkbox" id="agreeBox"
                            class="h-5 w-5 cursor-pointer appearance-none rounded-md border border-blue-gray-200 transition-all checked:border-blue-900 checked:bg-blue-600" />
                        <span
                            class="absolute text-white top-2/4 left-2/4 transform -translate-x-2/4 -translate-y-2/4 opacity-0 peer-checked:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                fill="currentColor" stroke="currentColor" stroke-width="1">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </label>
                    <label class="mt-px font-light text-gray-700 cursor-pointer select-none" for="agreeBox">
                        Confirm the transaction
                    </label>
                </div>
            </div>
            <div class="mt-6 flex justify-between">
                <x-secondary-button x-on:click="agreeBox = false; $dispatch('close-modal', 'complete-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>



                <x-danger-button x-show="agreeBox" wire:loading.attr="disabled" wire:target='completeProgram'
                    wire:click.prevent="completeProgram" class="ms-3" type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="completeProgram" role="status">
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


<script>
    let qrCodeScanner = null;

    Livewire.on('startScanner', () => {
        // Initialize the Html5Qrcode instance if not already initialized
        if (!qrCodeScanner) {
            qrCodeScanner = new Html5Qrcode("QrScanner");

            qrCodeScanner.start({
                    facingMode: "environment"
                }, // Camera facing mode
                {
                    fps: 10, // Frames per second to scan the QR code
                    qrbox: {
                        width: 250,
                        height: 250
                    } // Size of the scanning box
                },
                (decodedText, decodedResult) => {
                    console.log("QR Code detected: ", decodedText);
                    Livewire.dispatch('qrCodeScanned', {
                        decodedText: decodedText
                    });

                    // Stop the scanner after a successful scan
                    qrCodeScanner.stop().then(() => {
                        console.log("QR Code scanner stopped.");
                        qrCodeScanner = null; // Clear the reference to the instance

                        // Trigger closing the modal
                        window.dispatchEvent(new CustomEvent('close-modal'));
                    }).catch((err) => {
                        console.error("Error stopping the QR code scanner:", err);
                    });
                },
                (errorMessage) => {
                    console.warn("QR Code scanning error:", errorMessage);
                }
            ).catch((err) => {
                console.error("Error starting the QR code scanner:", err);
            });
        }
    });

    Livewire.on('endScanner', () => {
        console.log('Stopping QR scanner');

        // Stop the QR scanner if it's running
        if (qrCodeScanner) {
            qrCodeScanner.stop().then(() => {
                console.log("QR Code scanner stopped.");
                qrCodeScanner = null; // Clear the reference to the instance

                // Trigger closing the modal
                window.dispatchEvent(new CustomEvent('close-modal', {
                    detail: 'qr-scanner-modal' // Assuming $name holds the modal name
                }));
            }).catch((err) => {
                console.error("Error stopping the QR code scanner:", err);
            });
        }
    });

    // Listen for the close-modal event and handle it
    window.addEventListener('close-modal', () => {
        document.querySelector('[x-data]').__x.$data.open = false;
    });
</script>
