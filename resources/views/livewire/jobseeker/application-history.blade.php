<div wire:poll>


    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Application History') }}
        </h2>
    </x-slot>


    <div class="grid grid-cols-4 gap-5 p-0 mx-8 mt-4 lg:grid-cols-12 lg:p-6">
        <div class="col-span-4 lg:col-span-5">

            <div
                class="flex flex-col gap-2 p-1 pb-4 space-y-4 overflow-visible lg:flex-row lg:justify-between lg:space-y-0">

                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>

                    {{-- SEARCH --}}
                    <input wire:model.live.prevent='search' type="text" id="table-search-users"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search for applications">
                </div>
                <div class="flex flex-wrap gap-2 mr-3">

                    <x-dropdown align="left" width="36">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
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

                            <x-dropdown-link wire:click.prevent="updateFilter('All')" class="cursor-pointer">
                                All
                            </x-dropdown-link>
                            <x-dropdown-link wire:click.prevent="updateFilter('Pending')" class="cursor-pointer">
                                Pending
                            </x-dropdown-link>
                            <x-dropdown-link wire:click.prevent="updateFilter('Interview')" class="cursor-pointer">
                                Interview
                            </x-dropdown-link>
                            <x-dropdown-link wire:click.prevent="updateFilter('Others')" class="cursor-pointer">
                                Others
                            </x-dropdown-link>


                        </x-slot>
                    </x-dropdown>


                    <x-dropdown align="left" width="36">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                <div>
                                    {{ $sort }}
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

                            <x-dropdown-link wire:click.prevent="updateSort('Newest')" class="cursor-pointer">
                                Newest
                            </x-dropdown-link>
                            <x-dropdown-link wire:click.prevent="updateSort('Oldest')" class="cursor-pointer">
                                Oldest
                            </x-dropdown-link>


                        </x-slot>
                    </x-dropdown>
                </div>

            </div>
            <div class="flex overflow-x-auto lg:overflow-visible no-scrollbar">
                @if ($applications->isEmpty())
                    <div class="flex w-full">
                        <div class="w-full p-10 rounded-lg">
                            <div class="flex flex-col items-center justify-center w-full">
                                <div class="p-6 bg-gray-100 rounded-full">
                                    <svg class="w-24 h-24 text-black" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                    </svg>

                                </div>
                                <p class="mt-2 text-xl font-bold text-center text-black">
                                    No Application Found!
                                </p>
                            </div>
                        </div>

                    </div>
                @else
                    <div class="flex flex-row w-full gap-4 lg:flex-col" x-data="{
                        selectedJob: @entangle('selectedJob'),
                    }">
                        @foreach ($applications as $data)
                            <div class="relative flex-shrink-0 w-[90%] lg:w-full">
                                <a class="cursor-pointer" wire:key='application-{{ $data->applicant_id }}'
                                    wire:click.prevent="updateSelection({{ $data->applicant_id }})">
                                    <div
                                        class="@if ($data->applicant_id == $selectedJob) bg-blue-300 @else bg-white @endif shadow rounded-lg p-6 flex flex-col  lg:hover:scale-105 lg:transition-transform">

                                        <div class="flex flex-row w-full gap-4">

                                            <div class="flex-col hidden lg:flex">
                                                <img src="{{ asset('storage/' . $data->job_posting->company->company_img) }}"
                                                    class="select-none flex w-[140px] h-[100px] bg-gray-300 object-cover rounded-lg shrink-0 grow-0">
                                                </img>
                                            </div>
                                            <div class="flex flex-col w-full gap-1">
                                                <h1 class="text-xl underline lg:text-2xl lg:font-bold">
                                                    {{ $data->job_posting->job_Title }}
                                                </h1>
                                                <h1 class="text-gray-600 text-md lg:text-lg">
                                                    {{ $data->job_posting->company->business_Name }}</h1>
                                                <div class="lg:hidden mt-[-5px] select-none">
                                                    @if ($data->applicant_Status == 'PENDING')
                                                        <span
                                                            class="items-center px-1 py-1 text-xs font-medium text-yellow-800 bg-yellow-200 rounded-md inlineflex ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                                                    @elseif ($data->applicant_Status == 'INTERESTED')
                                                        <span
                                                            class="items-center px-1 py-1 text-xs font-medium text-yellow-800 bg-yellow-200 rounded-md inlineflex ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                                                    @elseif ($data->applicant_Status == 'INTERVIEW')
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-200 rounded-md ring-1 ring-inset ring-blue-600/20">INTERVIEW</span>
                                                    @elseif ($data->applicant_Status == 'HIRED')
                                                        <span
                                                            class="inline-flex items-center px-1 py-1 text-xs font-medium text-green-800 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">HIRED</span>
                                                    @elseif ($data->applicant_Status == 'ACCEPTED')
                                                        <span
                                                            class="inline-flex items-center px-1 py-1 text-xs font-medium rounded-md bg-emerald-200 text-emerald-800 ring-1 ring-inset ring-emerald-600/20">ACCEPTED</span>
                                                    @elseif ($data->applicant_Status == 'REJECTED' || $data->applicant_Status == 'CANCELLED')
                                                        <span
                                                            class="inline-flex items-center px-1 py-1 text-xs font-medium text-red-800 uppercase bg-red-200 rounded-md ring-1 ring-inset ring-red-600/20">{{ $data->applicant_Status }}</span>
                                                    @endif
                                                </div>
                                                <div class="flex flex-row">
                                                    <span
                                                        class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded me-2 border border-gray-500 ">
                                                        <svg class="w-1.5 h-1.5 me-1 lg:w-2.5 lg:h-2.5 lg:me-1.5"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z" />
                                                        </svg>
                                                        {{ $data->created_at->diffForHumans() }}
                                                    </span>
                                                </div>


                                            </div>
                                            <div class="flex-row hidden mt-0 mb-auto ml-auto mr-0 lg:flex select-none">

                                                @if ($data->applicant_Status == 'PENDING')
                                                    <span
                                                        class="items-center px-2 py-1 text-sm font-medium text-yellow-800 bg-yellow-200 rounded-md inlineflex ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                                                @elseif ($data->applicant_Status == 'INTERESTED')
                                                    <span
                                                        class="items-center px-2 py-1 text-sm font-medium text-yellow-800 bg-yellow-200 rounded-md inlineflex ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                                                @elseif ($data->applicant_Status == 'INTERVIEW')
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-sm font-medium text-blue-800 bg-blue-200 rounded-md ring-1 ring-inset ring-blue-600/20">INTERVIEW</span>
                                                @elseif ($data->applicant_Status == 'HIRED')
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-sm font-medium text-green-800 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">HIRED</span>
                                                @elseif ($data->applicant_Status == 'ACCEPTED')
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-sm font-medium rounded-md bg-emerald-200 text-emerald-800 ring-1 ring-inset ring-emerald-600/20">ACCEPTED</span>
                                                @elseif ($data->applicant_Status == 'REJECTED' || $data->applicant_Status == 'CANCELLED')
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-sm font-medium text-red-800 uppercase bg-red-200 rounded-md ring-1 ring-inset ring-red-600/20">{{ $data->applicant_Status }}</span>
                                                @endif

                                            </div>

                                            @if ($data->applicant_Notif == 1)
                                                <span
                                                    class="absolute p-0.5 leading-none w-3.5 h-3.5 bg-red-500 border-2 border-white rounded-full -translate-y-1/2 translate-x-1/2 left-auto top-[5px] right-1 lg:top-0 lg:right-0"></span>
                                            @endif
                                        </div>

                                        <div class="flex flex-col w-full mt-2 lg:mt-4">
                                            <div class="flex flex-col w-full md:flex-row">
                                                <div class="text-left md:w-1/4 md:text-center">
                                                    <h3 class="text-xs uppercase lg:text-sm"> <i
                                                            class="fa-solid fa-location-dot"></i> SM
                                                        {{ $data->job_posting->company->barangay->municipality->municipality_Name }},
                                                        {{ $data->job_posting->company->barangay->municipality->province->province_Name }}
                                                    </h3>

                                                </div>
                                                <div class="text-left md:w-1/4 md:text-center">
                                                    <h3 class="text-xs uppercase lg:text-sm"> <i
                                                            class="fa-solid fa-graduation-cap"></i>
                                                        {{ $eduLevels[$data->job_posting->job_Edu] }}</h3>
                                                </div>
                                                <div class="text-left md:w-1/4 md:text-center">
                                                    <h3 class="text-xs uppercase lg:text-sm"> <i
                                                            class="fa-solid fa-briefcase"></i>
                                                        {{ $jobTypes[$data->job_posting->job_Type] }}</h3>
                                                    </h3>
                                                </div>
                                                <div class="text-left md:w-1/4 md:text-center">
                                                    <h3 class="text-xs uppercase lg:text-sm"> <i
                                                            class="fa-solid fa-calendar"></i>
                                                        {{ $data->job_posting->created_at->format('F j, Y') }}
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach



                    </div>
                @endif
            </div>
            <div class="mt-2">
                {{ $applications->links('vendor.livewire.tailwind') }}
            </div>
        </div>

        <div class="col-span-4 lg:col-span-7">
            @if ($applicationInfo)
                <div class="flex flex-col p-6 bg-white rounded-lg shadow">
                    <div class="flex flex-row">
                        <div class="flex-col hidden w-full lg:flex lg:w-auto">
                            <img src="{{ asset('storage/' . $applicationInfo->job_posting->company->company_img) }}"
                                class="select-none flex w-[140px] h-[100px] bg-gray-300 object-cover rounded-lg shrink-0 grow-0">
                            </img>
                        </div>
                        <div class="flex flex-col w-full lg:ml-4">
                            <h1 class="text-2xl font-bold underline lg:text-6xl">
                                {{ $applicationInfo->job_posting->job_Title }}
                            </h1>
                            <h1 class="text-xl text-gray-600 lg:text-3xl">
                                {{ $applicationInfo->job_posting->company->business_Name }}</h1>

                        </div>

                        <div class="flex flex-col ">
                            <div class="flex flex-row mt-0 mb-auto ml-auto mr-0 select-none">
                                @if ($applicationInfo->applicant_Status == 'PENDING')
                                    <span
                                        class="items-center px-2 py-1 text-sm font-medium text-yellow-800 bg-yellow-200 rounded-md inlineflex ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                                @elseif ($applicationInfo->applicant_Status == 'INTERESTED')
                                    <span
                                        class="items-center px-2 py-1 text-sm font-medium text-yellow-800 bg-yellow-200 rounded-md inlineflex ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                                @elseif ($applicationInfo->applicant_Status == 'INTERVIEW')
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-sm font-medium text-blue-800 bg-blue-200 rounded-md ring-1 ring-inset ring-blue-600/20">INTERVIEW</span>
                                @elseif ($applicationInfo->applicant_Status == 'HIRED')
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-sm font-medium text-green-800 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">HIRED</span>
                                @elseif ($applicationInfo->applicant_Status == 'COMPLETED')
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-sm font-medium rounded-md bg-emerald-200 text-emerald-800 ring-1 ring-inset ring-emerald-600/20">HIRED</span>
                                @elseif ($applicationInfo->applicant_Status == 'REJECTED' || $applicationInfo->applicant_Status == 'CANCELLED')
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-sm font-medium text-red-800 uppercase bg-red-200 rounded-md ring-1 ring-inset ring-red-600/20">{{ $applicationInfo->applicant_Status }}</span>
                                @endif
                            </div>
                            @if ($applicationInfo->applicant_Status == 'HIRED')
                                <div class="flex-row justify-end hidden w-full lg:flex">
                                    <x-danger-button type="button" class="w-[100px] justify-center me-2 mb-2"
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'reject-modal')">Cancel</x-danger-button>
                                    <x-green-button type="button" class="w-[100px] justify-center me-2 mb-2"
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'accept-modal')">Accept</x-green-button>
                                </div>
                            @endif
                        </div>

                    </div>
                    @if ($applicationInfo->applicant_Status == 'HIRED')
                        <div class="flex flex-row justify-center w-full mt-5 lg:hidden">
                            <x-danger-button class="justify-center mb-2 me-2" type="button" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'reject-modal')">Cancel</x-danger-button>
                            <x-green-button type="button" class="justify-center mb-2 me-2" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'accept-modal')">Accept</x-green-button>
                        </div>
                    @endif

                    <hr class="mt-2 lg:mt-4">
                    <div class="flex flex-col mt-4">

                        <span class="mb-2 font-bold tracking-wider text-gray-700 uppercase">APPLICATION DETAIL</span>

                        <ul>


                            <div class="flex flex-row">
                                <li class="mb-2 font-bold">Resume:</li>
                                @if ($applicationInfo->applicant_Resume === 1)
                                    <p class="ms-4">Auto-Generated Resume</p>
                                @elseif($applicationInfo->applicant_Resume === 2)
                                    <p class="ms-4">Uploaded Resume</p>
                                @endif
                            </div>

                            <div class="flex flex-row">
                                <li class="mb-2 font-bold">Date Applied:</li>
                                <p class="ms-4">{{ $applicationInfo->created_at->format('F j, Y') }}</p>
                            </div>


                            <div class="flex flex-row">
                                <li class="mb-2 font-bold">Address:</li>
                                <p class="uppercase ms-4">
                                    {{ $applicationInfo->job_posting->job_Address }},
                                    {{ $applicationInfo->job_posting->barangay->barangay_Name }},
                                    {{ $applicationInfo->job_posting->barangay->municipality->municipality_Name }},
                                    {{ $applicationInfo->job_posting->barangay->municipality->province->province_Name }}
                                </p>
                            </div>

                            <div class="flex flex-row ">
                                <li class="mb-2 font-bold">PESO Status:</li>
                                <p class="ms-4 select-none">



                                    @if ($applicationInfo->peso_Status == 'PENDING')
                                        <span
                                            class="items-center px-1 py-1 text-sm font-medium text-yellow-800 bg-yellow-200 rounded-md inlineflex ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                                    @elseif ($applicationInfo->peso_Status == 'RECOMMENDED')
                                        <span
                                            class="inline-flex items-center px-1 py-1 text-sm font-medium text-green-800 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">RECOMMENDED</span>
                                    @elseif ($applicationInfo->peso_Status == 'REJECT')
                                        <span
                                            class="inline-flex items-center px-1 py-1 text-sm font-medium text-red-800 uppercase bg-red-200 rounded-md ring-1 ring-inset ring-red-600/20">NOT
                                            RECOMMENDED</span>
                                    @elseif ($applicationInfo->peso_Status == 'CANCELLED')
                                        <span
                                            class="inline-flex items-center px-1 py-1 text-sm font-medium text-red-800 uppercase bg-red-200 rounded-md ring-1 ring-inset ring-red-600/20">CANCELLED</span>
                                    @endif

                                </p>
                            </div>


                        </ul>

                        @if ($applicationInfo->applicant_Status != 'INTERESTED' && $applicationInfo->company_Remarks)
                            <div class="flex flex-col mt-2">
                                <h1 class="mb-2 font-bold">Company Remarks</h1>
                                <textarea id="message" rows="6"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                                    placeholder="Company remarks..." maxlength="600" readonly>{{ $applicationInfo->company_Remarks }}</textarea>
                            </div>
                        @endif

                        {{-- BUTTON --}}
                        <div class="flex flex-wrap justify-center gap-4 mt-6">
                            <div x-data="{ tooltip: 'View Job Posting' }">
                                <a wire:navigate
                                    href="{{ route('jobpost.show', ['id' => $applicationInfo->job_id]) }}"
                                    x-tooltip="tooltip" type="button"
                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                    </svg>


                                </a>
                            </div>
                            <div x-data="{ tooltip: 'View Resume' }">
                                <button {{-- x-on:click="openNewTab('{{ asset('storage/images/requirements/tXllyVuLtDR7W0X5cF6EdkZ9H1BWD2t4odWIFBpT.pdf') }}')" --}} {{-- wire:click.prevent='printResume({{ $applicationInfo->employee_id }}, {{ $applicationInfo->applicant_Resume }})' --}}
                                    wire:click.prevent="viewFile({{ $applicationInfo->employee_id }},{{ $applicationInfo->applicant_Resume }} )"
                                    x-tooltip="tooltip" type="button"
                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                                    </svg>
                                </button>
                            </div>
                            @if ($applicationInfo->peso_Status == 'RECOMMENDED')
                                <div x-data="{ tooltip: 'View Recommendation Letter' }">
                                    <button wire:click.prevent="viewFile({{ $applicationInfo->applicant_id }}, 3 )"
                                        {{-- wire:click.prevent='printRecom({{ $applicationInfo->applicant_id }})' --}} x-tooltip="tooltip" type="button"
                                        class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                        </svg>

                                    </button>
                                </div>
                            @endif
                        </div>

                    </div>



                </div>
                <x-modal name="accept-modal" focusable>
                    <div class="items-center w-full max-w-4xl px-6 py-6 border-b" x-data="{ acceptBox: @entangle('acceptBox') }">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Job Confirmation') }}
                        </h2>
                        <hr>
                        <div class="flex flex-col my-4">
                            <div class="flex flex-col items-center justify-center w-full px-4 mt-4">
                                <p class="text-sm text-justify lg:text-md">
                                    By accepting this job offer, you confirm that all the information provided in your
                                    application is
                                    accurate and truthful. Upon accepting, both the Employer and the Public Employment
                                    Service Office
                                    (PESO) will be notified of your acceptance. You will also be automatically marked as
                                    employed within
                                    the system, and your employment status will be updated accordingly. Your application
                                    and acceptance
                                    details will be officially recorded and shared with PESO for documentation and
                                    monitoring purposes.
                                    Please note that once accepted, the offer cannot be withdrawn, and you will be bound
                                    by the terms and
                                    conditions of employment as outlined by the Employer and PESO.
                                </p>
                                <div class="inline-flex items-center mt-4">
                                    <label class="relative flex items-center p-3 rounded-full cursor-pointer"
                                        for="acceptBox">
                                        <input wire:model="acceptBox" type="checkbox" id="acceptBox"
                                            class="w-5 h-5 transition-all border rounded-md appearance-none cursor-pointer border-blue-gray-200 checked:border-blue-900 checked:bg-blue-600" />
                                        <span
                                            class="absolute text-white transform opacity-0 top-2/4 left-2/4 -translate-x-2/4 -translate-y-2/4 peer-checked:opacity-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                viewBox="0 0 20 20" fill="currentColor" stroke="currentColor"
                                                stroke-width="1">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </span>
                                    </label>
                                    <label class="mt-px font-light text-gray-700 cursor-pointer select-none"
                                        for="acceptBox">
                                        I agree with the terms
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="flex justify-between mt-6">
                            <x-secondary-button x-data=""
                                x-on:click.prevent="$dispatch('close-modal', 'accept-modal')" type="button">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-green-button x-show="acceptBox" wire:loading.attr="disabled"
                                wire:click.prevent="handleResponse('ACCEPTED', {{ $applicationInfo->applicant_id }})"
                                class="ms-3" type="button">


                                {{ __('Accept Job') }}

                                <div wire:loading.delay.long wire:target="handleResponse('ACCEPTED')" role="status">
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
                            </x-green-button>

                        </div>
                    </div>
                </x-modal>
                <x-modal name="reject-modal" focusable>
                    <div class="items-center w-full max-w-4xl px-6 py-6" x-data="{ rejectBox: @entangle('rejectBox') }">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Job Confirmation') }}
                        </h2>
                        <hr>
                        <div class="flex flex-col my-4">
                            <div class="flex flex-col items-center justify-center w-full px-4 mt-4">
                                <p class="text-sm text-justify lg:text-md">
                                    By declining this job offer, you acknowledge that your application status will be
                                    marked as "Declined" in the system. Your decision will be communicated to both the
                                    employer and the Public Employment Services Office (PESO). While you may still be
                                    eligible for other opportunities, please note that declining this offer will
                                    finalize your decision for this specific job, and further applications to this
                                    position may not be possible.
                                </p>
                                <div class="inline-flex items-center mt-4">
                                    <label class="relative flex items-center p-3 rounded-full cursor-pointer"
                                        for="rejectBox">
                                        <input wire:model="rejectBox" type="checkbox" id="rejectBox"
                                            class="w-5 h-5 transition-all border rounded-md appearance-none cursor-pointer border-blue-gray-200 checked:border-blue-900 checked:bg-blue-600" />
                                        <span
                                            class="absolute text-white transform opacity-0 top-2/4 left-2/4 -translate-x-2/4 -translate-y-2/4 peer-checked:opacity-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                viewBox="0 0 20 20" fill="currentColor" stroke="currentColor"
                                                stroke-width="1">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </span>
                                    </label>
                                    <label class="mt-px font-light text-gray-700 cursor-pointer select-none"
                                        for="rejectBox">
                                        I agree with the terms
                                    </label>
                                </div>
                            </div>
                        </div>



                        <div class="flex justify-between mt-6">
                            <x-secondary-button x-data=""
                                x-on:click.prevent="$dispatch('close-modal', 'reject-modal')" type="button">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-danger-button x-show="rejectBox" wire:loading.attr="disabled"
                                wire:click.prevent="handleResponse('CANCELLED', {{ $applicationInfo->applicant_id }})"
                                class="ms-3" type="button">


                                {{ __('Reject Job') }}

                                <div wire:loading.delay.long wire:target="handleResponse('CANCELLED')" role="status">
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
                            </x-danger-button>

                        </div>
                    </div>
                </x-modal>

            @endif
        </div>
    </div>


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

                    // Ensure URL is present
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
                        Object.entries(data).forEach(([key, value]) => {
                            if (key !== 'url') {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = key;
                                input.value = value;
                                form.appendChild(input);
                            }
                        });

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
