<div wire:poll>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Job Applicants') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-4 gap-5 p-0 mx-8 mt-4 lg:grid-cols-12 lg:p-6">
        <div class="col-span-4 lg:col-span-5">

            <div
                class="flex flex-col flex-wrap gap-2 p-1 pb-4 space-y-4 lg:items-center lg:jstify-between flex-column lg:flex-row lg:space-y-0">
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
                    <input wire:model.live='postSearch' type="search" id="table-search-users"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search for job posting">
                </div>
                <div class="flex flex-wrap gap-2 mr-3">

                    <x-dropdown align="right" width="36">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                <div>
                                    {{ $jobFilter }}
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

                            <x-dropdown-link class="cursor-pointer" wire:click.prevent="updateJobFilter('ALL')">
                                All
                            </x-dropdown-link>
                            <x-dropdown-link class="cursor-pointer" wire:click.prevent="updateJobFilter('ACTIVE')">
                                Active
                            </x-dropdown-link>
                            <x-dropdown-link class="cursor-pointer" wire:click.prevent="updateJobFilter('CLOSED')">
                                Closed
                            </x-dropdown-link>


                        </x-slot>
                    </x-dropdown>

                </div>
            </div>
            <div class="flex">
                @if ($jobs->isEmpty())
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
                                    No Job Posting Found!
                                </p>
                            </div>
                        </div>

                    </div>
                @else
                    <div class="flex flex-row w-full gap-4 overflow-y-auto lg:flex-col lg:overflow-visible"
                        x-data="{
                            selectedJob: @entangle('selectedJob'),
                        }">
                        @foreach ($jobs as $data)
                            <div class="relative flex-shrink-0 w-[90%] lg:w-full">
                                <a wire:key='jobPost-{{ $data->job_id }}'
                                    wire:click.prevent='getJob({{ $data->job_id }})' class="cursor-pointer">

                                    <div
                                        class="@if ($data->job_id == $selectedJob) bg-blue-300 @else bg-white @endif shadow rounded-lg p-6 flex flex-col h-full lg:hover:scale-105 lg:transition-transform overflow-hidden">

                                        <div class="flex flex-row justify-end gap-4 lg:gap-0">

                                            <div class="flex flex-col w-full">
                                                <h1 class="text-xl font-bold underline lg:text-2xl">
                                                    {{ $data->job_Title }}</h1>
                                                <h1 class="text-gray-600 text-md lg:text-lg">
                                                    {{ $data->company->business_Name }}
                                                </h1>
                                                <div class="flex flex-row">

                                                </div>

                                            </div>
                                            <div class="justify-end hidden w-full mt-0 mb-auto lg:flex">
                                                <span
                                                    class=" bg-gray-100 text-gray-800 text-md font-medium   items-center px-2.5 py-0.5 rounded me-2 border border-gray-500 ">
                                                    PESO {{ $data->peso->municipality->municipality_Name }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex w-full lg:hidden">
                                            <span
                                                class=" bg-gray-100 text-gray-800 text-md font-medium   items-center px-2.5 py-0.5 rounded me-2 border border-gray-500 ">
                                                PESO {{ $data->peso->municipality->municipality_Name }}
                                            </span>
                                        </div>

                                        <div class="flex flex-row mt-2 text-sm lg:text-md">
                                            <p class="mb-2 font-bold">Applicants:</p>
                                            <p class="ms-2">{{ $data->job_applicants_count }}</p>
                                        </div>


                                        <div class="flex flex-col w-full mt-4">
                                            <div class="flex flex-col md:flex-row">
                                                <div class="text-left md:w-1/4">

                                                    <h3 class="text-xs uppercase lg:text-sm"> <i
                                                            class="fa-solid fa-location-dot"></i>
                                                        {{ $data->barangay->municipality->municipality_Name }},
                                                        {{ $data->barangay->municipality->province->province_Name }}
                                                </div>
                                                <div class="text-left uppercase md:w-1/4 md:text-center">
                                                    <h3 class="text-xs lg:text-sm"> <i
                                                            class="fa-solid fa-graduation-cap"></i>
                                                        {{ $eduLevels[$data->job_Edu] }}</h3>
                                                </div>
                                                <div class="text-left md:w-1/4 md:text-center">
                                                    <h3 class="text-xs uppercase lg:text-sm"> <i
                                                            class="fa-solid fa-briefcase"></i>
                                                        {{ $data->job_Type == 1 ? 'Full Time' : 'Part Time' }}
                                                    </h3>
                                                </div>
                                                <div class="text-left md:w-1/4 md:text-center">
                                                    <h3 class="text-xs uppercase lg:text-sm"> <i
                                                            class="fa-solid fa-calendar"></i>
                                                        {{ $data->created_at->format('F j, Y') }}
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                </tr>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-2">
                {{ $jobs->links('vendor.livewire.tailwind') }}
            </div>
        </div>

        <div class="col-span-4 lg:col-span-7" x-data="{
            selectedApplicant: @entangle('selectedApplicant')
        }">
            @if ($applicants)
                <div x-show="!selectedApplicant" class="flex flex-col p-6 bg-white rounded-lg shadow"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100">


                    <div class="relative">
                        <div x-data="{
                            filter: @entangle('filter'),
                            activeFilter: 'text-gray-900 bg-gray-400 active',
                            inactiveFilter: 'bg-white hover:text-gray-700 hover:bg-gray-50',
                        }" x-init="$wire.set('filter', filter)">
                            <div class="lg:hidden">
                                <label for="tabs" class="sr-only">Select Filter</label>
                                <select id="tabs"
                                    class="mb-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    @change="$wire.changeFilter($event.target.value)">
                                    <option value="ALL">All ({{ $applicants['total'] }})</option>
                                    <option value="PENDING">Pending ({{ $applicants['pending'] }})</option>
                                    <option value="INTERESTED">Interested ({{ $applicants['interested'] }})</option>
                                    <option value="INTERVIEW">Interview ({{ $applicants['interview'] }})</option>
                                    <option value="HIRED">Hired ({{ $applicants['hired'] }})</option>
                                    <option value="ACCEPTED">Accepted ({{ $applicants['accepted'] }})</option>
                                    <option value="REJECTED">Rejected ({{ $applicants['rejected'] }})</option>
                                </select>
                            </div>
                            <ul
                                class="hidden mb-3 text-sm font-medium text-center text-gray-500 rounded-lg shadow lg:flex">
                                <li class="w-full focus-within:z-10">
                                    <button wire:click.prevent='changeFilter("ALL")'
                                        :class="filter === 'ALL' ? activeFilter : inactiveFilter"
                                        class="inline-block w-full p-4 border border-gray-200 rounded-l-lg"
                                        aria-current="page">All ({{ $applicants['total'] }})</button>
                                </li>
                                <li class="w-full focus-within:z-10">
                                    <button wire:click.prevent='changeFilter("PENDING")'
                                        :class="filter === 'PENDING' ? activeFilter : inactiveFilter"
                                        class="inline-block w-full p-4 border border-gray-200">Pending
                                        ({{ $applicants['pending'] }})</button>
                                </li>
                                <li class="w-full focus-within:z-10">
                                    <button wire:click.prevent='changeFilter("INTERESTED")'
                                        :class="filter === 'INTERESTED' ? activeFilter : inactiveFilter"
                                        class="inline-block w-full p-4 border border-gray-200">Interested
                                        ({{ $applicants['interested'] }})</button>
                                </li>
                                <li class="w-full focus-within:z-10">
                                    <button wire:click.prevent='changeFilter("INTERVIEW")'
                                        :class="filter === 'INTERVIEW' ? activeFilter : inactiveFilter"
                                        class="inline-block w-full p-4 border border-gray-200">Interview
                                        ({{ $applicants['interview'] }})</button>
                                </li>
                                <li class="w-full focus-within:z-10">
                                    <button wire:click.prevent='changeFilter("HIRED")'
                                        :class="filter === 'HIRED' ? activeFilter : inactiveFilter"
                                        class="inline-block w-full p-4 border border-gray-200">Hired
                                        ({{ $applicants['hired'] }})</button>
                                </li>
                                <li class="w-full focus-within:z-10">
                                    <button wire:click.prevent='changeFilter("ACCEPTED")'
                                        :class="filter === 'ACCEPTED' ? activeFilter : inactiveFilter"
                                        class="inline-block w-full p-4 border border-gray-200">Accepted
                                        ({{ $applicants['accepted'] }})</button>
                                </li>
                                <li class="w-full focus-within:z-10">
                                    <button wire:click.prevent='changeFilter("REJECTED")'
                                        :class="filter === 'REJECTED' ? activeFilter : inactiveFilter"
                                        class="inline-block w-full p-4 border border-gray-200 rounded-r-lg">Rejected
                                        ({{ $applicants['rejected'] }})</button>
                                </li>
                            </ul>
                        </div>


                        <div
                            class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">

                            <div>

                                <label for="table-search" class="sr-only">Search</label>
                                <div class="relative ">
                                    <div
                                        class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>

                                    {{-- SEARCH --}}
                                    <input wire:model.live.prevent='applicantSearch' type="text"
                                        id="table-search-users"
                                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Search applicants">
                                </div>
                            </div>

                            {{-- DROP DOWN BUTTON --}}
                            <div class="flex flex-wrap gap-2 mr-2">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button
                                            class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
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

                                        <x-dropdown-link class="cursor-pointer"
                                            wire:click.prevent="updateSort('DESC')">
                                            Newest
                                        </x-dropdown-link>

                                        <!-- Authentication -->
                                        <x-dropdown-link class="cursor-pointer"
                                            wire:click.prevent="updateSort('ASC')">
                                            Oldest
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            </div>


                        </div>

                        {{-- TABLE --}}
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 ">
                                            Name
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                            PESO Status
                                        </th>
                                        @if ($filter === 'ALL')
                                            <th scope="col"class="hidden px-6 py-3 lg:table-cell">
                                                Status
                                            </th>
                                        @endif
                                        <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                            Documents
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($applicants['list']) && count($applicants['list']) === 0)
                                        <tr>
                                            <td colspan="5">
                                                <div class="flex flex-col items-center justify-center mt-10">
                                                    <div class="p-6 bg-gray-100 rounded-full">
                                                        <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-width="2"
                                                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                        </svg>

                                                    </div>
                                                    <p class="mt-2 mb-20 text-xl font-bold text-center text-black">
                                                        No Applicants Found
                                                    </p>
                                                </div>

                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($applicants['list'] as $data)
                                            <tr wire:key='jobApplicant-{{ $data->applicant_id }}'
                                                class="bg-white border-b hover:bg-gray-50">
                                                <th scope="row"
                                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                                    <img class="select-none object-cover w-10 h-10 rounded-full"
                                                        src="{{ asset('storage/' . $data->employee->pimg) }}"
                                                        alt="Profile Image">
                                                    <div class="ps-3 text-wrap">
                                                        <div class="text-base font-semibold">
                                                            <a wire:navigate
                                                                href="{{ route('jobseeker.profile', ['id' => $data->employee->employee_id]) }}"
                                                                class="hover:text-blue-500">
                                                                {{ $data->employee->fname }}
                                                                {{ $data->employee->mname }}
                                                                {{ $data->employee->lname }}
                                                            </a>
                                                        </div>
                                                        <div class="text-xs font-medium text-gray-500">Applied date:
                                                            {{ $data->created_at->format('F j, Y') }}</div>
                                                        <div class="text-xs text-gray-500 lg:hidden select-none">
                                                            Status:
                                                            @if ($data->peso_Status === 'PENDING')
                                                                <span
                                                                    class="text-yellow-500">{{ $data->peso_Status }}</span>
                                                            @elseif($data->peso_Status === 'RECOMMENDED')
                                                                <span
                                                                    class="text-green-500">{{ $data->peso_Status }}</span>
                                                            @elseif($data->peso_Status === 'REJECT')
                                                                <span
                                                                    class="text-red-500">{{ $data->peso_Status }}</span>
                                                            @endif
                                                            (@if ($data->applicant_Status === 'PENDING')
                                                                <span
                                                                    class="text-yellow-500">{{ $data->applicant_Status }}</span>
                                                            @elseif($data->applicant_Status === 'INTERESTED')
                                                                <span
                                                                    class="text-purple-500">{{ $data->applicant_Status }}</span>
                                                            @elseif($data->applicant_Status === 'INTERVIEW')
                                                                <span
                                                                    class="text-blue-500">{{ $data->applicant_Status }}</span>
                                                            @elseif($data->applicant_Status === 'HIRED')
                                                                <span
                                                                    class="text-green-500">{{ $data->applicant_Status }}</span>
                                                            @elseif($data->applicant_Status === 'ACCEPTED')
                                                                <span
                                                                    class="text-emerald-500">{{ $data->applicant_Status }}</span>
                                                            @elseif($data->applicant_Status === 'REJECTED' || $data->applicant_Status === 'CANCELLED')
                                                                <span
                                                                    class="text-red-500">{{ $data->applicant_Status }}</span>
                                                            @endif)
                                                        </div>
                                                    </div>
                                                </th>

                                                <td class="hidden px-6 py-4 font-semibold lg:table-cell">
                                                    <div class="flex items-center select-none">
                                                        @if ($data->peso_Status === 'PENDING')
                                                            <div class="h-2.5 w-2.5 rounded-full bg-yellow-500 me-2">
                                                            </div>
                                                            Pending
                                                        @elseif($data->peso_Status === 'RECOMMENDED')
                                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2">
                                                            </div>
                                                            Recommended
                                                        @elseif($data->peso_Status === 'REJECT')
                                                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2">
                                                            </div>
                                                            Not Recommended
                                                        @endif
                                                    </div>
                                                </td>

                                                @if ($filter === 'ALL')
                                                    <td class="hidden px-6 py-4 lg:table-cell">
                                                        <div class="flex items-center select-none">
                                                            @if ($data->applicant_Status === 'PENDING')
                                                                <div
                                                                    class="h-2.5 w-2.5 rounded-full bg-yellow-500 me-2">
                                                                </div>
                                                                Pending
                                                            @elseif($data->applicant_Status === 'INTERESTED')
                                                                <div
                                                                    class="h-2.5 w-2.5 rounded-full bg-purple-500 me-2">
                                                                </div>
                                                                Interested
                                                            @elseif($data->applicant_Status === 'INTERVIEW')
                                                                <div class="h-2.5 w-2.5 rounded-full bg-blue-500 me-2">
                                                                </div>
                                                                Interview
                                                            @elseif($data->applicant_Status === 'HIRED')
                                                                <div
                                                                    class="h-2.5 w-2.5 rounded-full bg-green-500 me-2">
                                                                </div>
                                                                Hired
                                                            @elseif($data->applicant_Status === 'ACCEPTED')
                                                                <div
                                                                    class="h-2.5 w-2.5 rounded-full bg-emerald-500 me-2">
                                                                </div>
                                                                Accepted
                                                            @elseif($data->applicant_Status === 'REJECTED' || $data->applicant_Status === 'CANCELLED')
                                                                <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2">
                                                                </div>
                                                                <p class="uppercase">{{ $data->applicant_Status }}</p>
                                                            @endif
                                                        </div>
                                                    </td>
                                                @endif

                                                <td class="hidden px-6 py-4 lg:table-cell">
                                                    <div class="flex flex-row items-center gap-4">
                                                        <div x-data="{ tooltip: 'View Resume' }">
                                                            <button
                                                                wire:click.prevent="viewFile({{ $data->employee_id }}, {{ $data->applicant_Resume }})"
                                                                x-tooltip="tooltip" type="button"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        @if ($data->peso_Status === 'RECOMMENDED')
                                                            <div x-data="{ tooltip: 'View Recommendation Letter' }">
                                                                <button
                                                                    wire:click.prevent="viewFile({{ $data->applicant_id }}, 3)"
                                                                    x-tooltip="tooltip" type="button"
                                                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                                                                    <svg class="w-5 h-5"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4">
                                                    <div class="flex flex-row items-center gap-4">
                                                        @if (
                                                            $filter != 'ACCEPTED' &&
                                                                $filter != 'HIRED' &&
                                                                $data->applicant_Status != 'INTERESTED' &&
                                                                $data->applicant_Status != 'INTERVIEW' &&
                                                                $data->applicant_Status != 'CANCELLED' &&
                                                                $data->applicant_Status != 'HIRED' &&
                                                                $data->applicant_Status != 'ACCEPTED' &&
                                                                $data->applicant_Status != 'REJECTED')
                                                            <div x-data="{ tooltip: 'Interested' }">
                                                                <button
                                                                    wire:click.prevent="openModal('interested', {{ $data->applicant_id }})"
                                                                    x-tooltip="tooltip" type="button"
                                                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-purple-700 border border-purple-700 rounded-lg hover:bg-purple-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-purple-300">
                                                                    <svg class="w-5 h-5"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        @endif
                                                        @if (
                                                            $filter != 'ACCEPTED' &&
                                                                $filter != 'HIRED' &&
                                                                $data->applicant_Status != 'INTERVIEW' &&
                                                                $data->applicant_Status != 'CANCELLED' &&
                                                                $data->applicant_Status != 'ACCEPTED' &&
                                                                $data->applicant_Status != 'HIRED' &&
                                                                $data->applicant_Status != 'REJECTED')
                                                            <div x-data="{ tooltip: 'For Interview' }">
                                                                <button
                                                                    wire:click.prevent="openModal('interview', {{ $data->applicant_id }})"
                                                                    x-tooltip="tooltip" type="button"
                                                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                                                                    <svg class="w-5 h-5"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        @endif
                                                        @if (
                                                            $filter == 'INTERVIEW' &&
                                                                $data->applicant_Status != 'HIRED' &&
                                                                $data->applicant_Status != 'ACCEPTED' &&
                                                                $data->applicant_Status != 'REJECTED' &&
                                                                $data->applicant_Status != 'CANCELLED')
                                                            <div x-data="{ tooltip: 'Hire' }">
                                                                <button
                                                                    wire:click.prevent="openModal('hire', {{ $data->applicant_id }})"
                                                                    x-tooltip="tooltip" type="button"
                                                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-green-700 border border-green-700 rounded-lg hover:bg-green-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-300">
                                                                    <svg class="w-5 h-5"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>

                                                                </button>
                                                            </div>
                                                        @endif
                                                        @if (
                                                            $filter != 'ACCEPTED' &&
                                                                $filter != 'HIRED' &&
                                                                $data->applicant_Status != 'CANCELLED' &&
                                                                $data->applicant_Status != 'ACCEPTED' &&
                                                                $data->applicant_Status != 'HIRED' &&
                                                                $data->applicant_Status != 'REJECTED')
                                                            <div x-data="{ tooltip: 'Reject' }">
                                                                <button
                                                                    wire:click.prevent="openModal('reject', {{ $data->applicant_id }})"
                                                                    x-tooltip="tooltip" type="button"
                                                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-red-700 border border-red-700 rounded-lg hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300">
                                                                    <svg class="w-5 h-5"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>

                                                                </button>
                                                            </div>
                                                        @endif
                                                        @if ($filter != 'ALL' && $data->applicant_Status != 'PENDING')
                                                            <div x-data="{ tooltip: 'Applicant Info' }">
                                                                <button
                                                                    wire:click.prevent="getApplicant({{ $data->applicant_id }})"
                                                                    x-tooltip="tooltip" type="button"
                                                                    class="inline-flex items-center p-1 text-sm font-medium text-center border rounded-lg text-cyan-700 border-cyan-700 hover:bg-cyan-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-cyan-300">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="w-5 h-5" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
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
                        </div>
                    </div>

                    {{-- pagination --}}
                    <div>
                        {{ $applicants['list']->links('vendor.livewire.tailwind') }}
                    </div>


                </div>



                <div x-show="selectedApplicant" class="flex flex-col p-6 bg-white rounded-lg shadow"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>
                    @if ($selectedApplicant)
                        <div class="flex flex-row items-center gap-4">
                            <button @click="selectedApplicant = null">
                                <div class="flex items-center p-1 transition-transform rounded-full hover:bg-gray-300">
                                    <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                    </svg>
                                </div>
                            </button>
                            <h2 class="text-lg font-bold lg:text-2xl">Applicant Information</h2>

                        </div>

                        <div class="flex flex-row mt-2">
                            <div class="flex flex-col">
                                <img src="{{ asset('storage/' . $applicantInfo->employee->pimg) }}"
                                    class="select-none flex w-[140px] h-[100px] bg-gray-300 object-cover rounded-lg shrink-0 grow-0">
                                </img>
                            </div>
                            <div class="flex flex-col justify-center w-full ml-4">
                                <h1 class="text-3xl font-bold">
                                    {{ $applicantInfo->employee->fname }} {{ $applicantInfo->employee->mname }}
                                    {{ $applicantInfo->employee->lname }}
                                </h1>
                                <h1 class="text-lg text-gray-600">
                                    {{ $applicantInfo->employee->barangay->municipality->municipality_Name }},
                                    {{ $applicantInfo->employee->barangay->municipality->province->province_Name }}
                                </h1>

                            </div>
                            <div class="flex flex-row mt-0 mb-auto ml-auto mr-0">
                                {{-- @if ($applicationInfo->applicant_Status == 'PENDING')
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
                            @elseif ($applicationInfo->applicant_Status == 'REJECTED')
                                <span
                                    class="inline-flex items-center px-2 py-1 text-sm font-medium text-red-800 bg-red-200 rounded-md ring-1 ring-inset ring-red-600/20">REJECTED</span>
                            @endif --}}
                            </div>
                        </div>
                        <hr class="mt-4">
                        <div class="flex flex-col mt-4">

                            <span class="mb-2 font-bold tracking-wider text-gray-700 uppercase">APPLICATION
                                DETAIL</span>

                            <ul>

                                <div class="flex flex-row">
                                    <li class="mb-2 font-bold">Date Applied:</li>
                                    <p class="ms-4">
                                        {{ $applicantInfo->created_at->format('F j, Y') }}
                                    </p>
                                </div>
                                <div class="flex flex-row select-none">
                                    <li class="mb-2 font-bold">Applicant Status:</li>
                                    <p class="ms-4">

                                        @if ($applicantInfo->applicant_Status === 'PENDING')
                                            Pending
                                        @elseif($applicantInfo->applicant_Status === 'INTERESTED')
                                            Interested
                                        @elseif($applicantInfo->applicant_Status === 'INTERVIEW')
                                            Interview
                                        @elseif($applicantInfo->applicant_Status === 'HIRED')
                                            Hired
                                        @elseif($applicantInfo->applicant_Status === 'ACCEPTED')
                                            Accepted
                                        @elseif($applicantInfo->applicant_Status === 'REJECTED')
                                            Rejected
                                        @elseif($applicantInfo->applicant_Status === 'CANCELLED')
                                            Cancelled
                                        @endif

                                    </p>
                                </div>


                                <div class="flex flex-row select-none">
                                    <li class="mb-2 font-bold">PESO Status:</li>
                                    <p class="ms-4">

                                        @if ($applicantInfo->peso_Status === 'PENDING')
                                            Pending
                                        @elseif($applicantInfo->peso_Status === 'RECOMMENDED')
                                            Recommended
                                        @elseif($applicantInfo->peso_Status === 'REJECT')
                                            Not Recommended
                                        @elseif($applicantInfo->peso_Status === 'CANCELLED')
                                            Cancelled
                                        @endif

                                    </p>
                                </div>


                            </ul>

                            <div class="flex flex-col mt-2">
                                <h1 class="mb-2 font-bold">Remarks</h1>
                                <textarea id="message" rows="6"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                                    placeholder="My remarks..." maxlength="600" readonly>{{ $applicantInfo->company_Remarks }}</textarea>
                            </div>

                            <div class="flex flex-wrap justify-center gap-4 mt-6">
                                <div x-data="{ tooltip: 'View Resume' }">
                                    <button
                                        wire:click.prevent="viewFile({{ $applicantInfo->employee_id }},{{ $applicantInfo->applicant_Resume }} )"
                                        x-tooltip="tooltip" type="button"
                                        class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                                        </svg>
                                    </button>
                                </div>
                                @if ($applicantInfo->peso_Status == 'RECOMMENDED')
                                    <div x-data="{ tooltip: 'View Recommendation Letter' }">

                                        <button wire:click.prevent="viewFile({{ $applicantInfo->applicant_id }}, 3 )"
                                            x-tooltip="tooltip" type="button"
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
                    @endif
                </div>
            @endif
        </div>
    </div>


    {{-- MODALS --}}
    <x-modal name="interested-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6 border-b">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Mark applicant as interested?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">
                <div class="flex flex-col w-full mt-2">
                    <x-input-label :value="__('Remarks')" />
                    <textarea wire:model='remarks' id="message" rows="6"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                        placeholder="Write your remarks here..." maxlength="600"></textarea>
                    <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                </div>

            </div>



            <div class="flex justify-end gap-4 mt-6">
                <x-secondary-button wire:click.prevent="closeModal('interested')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <button
                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-purple-800 border border-transparent rounded-md hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                    wire:loading.attr="disabled" wire:click.prevent="updateApplicant('INTERESTED', 'interested')"
                    class="ms-3" class="ms-3" type="button">


                    {{ __('Mark as Interested') }}

                    <div wire:loading.delay.long wire:target="updateApplicant('INTERESTED', 'interested')"
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
                </button>

            </div>
        </div>
    </x-modal>


    <x-modal name="interview-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6 border-b">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to interivew?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">
                <div class="flex flex-col w-full mt-2">
                    <x-input-label :value="__('Remarks')" />
                    <textarea wire:model='remarks' id="message" rows="6"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                        placeholder="Write your remarks here..." maxlength="600"></textarea>
                    <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                </div>

            </div>



            <div class="flex justify-end gap-4 mt-6">
                <x-secondary-button wire:click.prevent="closeModal('interview')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-blue-button wire:loading.attr="disabled"
                    wire:click.prevent="updateApplicant('INTERVIEW', 'interview')" class="ms-3" class="ms-3"
                    type="button">


                    {{ __('Approve Interview') }}

                    <div wire:loading.delay.long wire:target="updateApplicant('INTERVIEW', 'interview')"
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
                </x-blue-button>

            </div>
        </div>
    </x-modal>

    <x-modal name="hire-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6 border-b">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to hire the applicant?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">
                <div class="flex flex-col w-full mt-2">
                    <x-input-label :value="__('Remarks')" />
                    <textarea wire:model='remarks' id="message" rows="6"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                        placeholder="Write your remarks here..." maxlength="600"></textarea>
                    <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                </div>

            </div>



            <div class="flex justify-end gap-4 mt-6">
                <x-secondary-button wire:click.prevent="closeModal('hire')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-green-button wire:loading.attr="disabled" wire:click.prevent="updateApplicant('HIRED', 'hire')"
                    class="ms-3" class="ms-3" type="button">


                    {{ __('Hire Applicant') }}

                    <div wire:loading.delay.long wire:target="updateApplicant('HIRED', 'hire')" role="status">
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
                </x-green-button>

            </div>
        </div>
    </x-modal>

    <x-modal name="reject-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6 border-b">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to reject the applicant?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">
                <div class="flex flex-col w-full mt-2">
                    <x-input-label :value="__('Remarks')" />
                    <textarea wire:model='remarks' id="message" rows="6"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                        placeholder="Write your remarks here..." maxlength="600"></textarea>
                    <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                </div>

            </div>



            <div class="flex justify-end gap-4 mt-6">
                <x-secondary-button wire:click.prevent="closeModal('reject')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled"
                    wire:click.prevent="updateApplicant('REJECTED', 'reject')" class="ms-3" type="button">


                    {{ __('Reject Applicant') }}

                    <div wire:loading.delay.long wire:target="updateApplicant('REJECTED', 'reject')" role="status">
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
