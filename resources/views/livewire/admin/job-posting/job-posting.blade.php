<div wire:poll class="container py-8 mx-auto">
    <div class="grid grid-cols-4 gap-4 p-3 lg:grid-cols-12 lg:p-0">

        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Job Posting</h1>
        </div>

        <div class="col-span-4 lg:col-span-12">
            <div class="p-6 bg-white rounded-lg shadow" x-data="{
                filter: @entangle('filter').defer || 'ALL', // Set default value to 'ALL'
                activeFilter: 'text-gray-900 bg-gray-400 active',
                inactiveFilter: 'bg-gray-100 hover:text-gray-700 hover:bg-gray-50',
                changeFilter(value) {
                    this.filter = value;
                    this.$wire.call('updateFilter', value); // Update Livewire filter property
                },
                init() {
                    // Ensure Livewire and Alpine.js sync on initialization
                    this.$watch('filter', value => {
                        this.changeFilter(value); // Ensure Livewire is updated when filter changes
                    });
                }
            }" x-init="init()">

                <div class="relative p-1 overflow-x-auto">
                    <!-- Mobile Dropdown -->
                    <div class="lg:hidden">
                        <label for="tabs" class="sr-only">Select Filter</label>
                        <select id="tabs"
                            class="mb-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            x-model="filter" @change="changeFilter($event.target.value)">
                            <option value="ALL">All ({{ $allCount }})</option>
                            <option value="PENDING">Pending ({{ $pendingCount }})</option>
                            <option value="ACTIVE">Active ({{ $activeCount }})</option>
                            <option value="CLOSED">Closed ({{ $closedCount }})</option>
                            <option value="COMPLETED">Completed ({{ $completedCount }})</option>
                            <option value="OTHERS">Others ({{ $othersCount }})</option>
                        </select>
                    </div>

                    <!-- Desktop Tabs -->
                    <ul class="hidden mb-3 text-sm font-medium text-center text-gray-500 rounded-lg shadow lg:flex">
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('ALL')"
                                :class="filter === 'ALL' ? activeFilter : inactiveFilter"
                                class="inline-block w-full p-4 border border-gray-200 rounded-l-lg"
                                aria-current="page">All ({{ $allCount }})</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('PENDING')"
                                :class="filter === 'PENDING' ? activeFilter : inactiveFilter"
                                class="inline-block w-full p-4 border border-gray-200">Pending
                                ({{ $pendingCount }})</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('ACTIVE')"
                                :class="filter === 'ACTIVE' ? activeFilter : inactiveFilter"
                                class="inline-block w-full p-4 border border-gray-200">Active
                                ({{ $activeCount }})</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('CLOSED')"
                                :class="filter === 'CLOSED' ? activeFilter : inactiveFilter"
                                class="inline-block w-full p-4 border border-gray-200">Closed
                                ({{ $closedCount }})</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('COMPLETED')"
                                :class="filter === 'COMPLETED' ? activeFilter : inactiveFilter"
                                class="inline-block w-full p-4 border border-gray-200">Completed
                                ({{ $completedCount }})</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('OTHERS')"
                                :class="filter === 'OTHERS' ? activeFilter : inactiveFilter"
                                class="inline-block w-full p-4 border border-gray-200 rounded-r-lg">Others
                                ({{ $othersCount }})</button>
                        </li>
                    </ul>
                    <div id="tooltip-top" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Tooltip on top
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    <div class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">


                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>

                            {{-- SEARCH --}}
                            <input wire:model.live='search' type="search" id="table-search-users"
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search">
                        </div>
                        <div class="flex flex-wrap gap-2 mr-3">
                            <x-dropdown align="left" width="40">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                        <div>
                                            Export
                                        </div>

                                        <div class="ms-1">
                                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div wire:loading.delay.long wire:target="exportPdf" role="status">
                                                <svg aria-hidden="true"
                                                    class="w-3 h-3 ml-1 text-gray-200 animate-spin fill-blue-600"
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
                                    </button>
                                </x-slot>


                                <x-slot name="content">
                                    <x-slot name="contentClasses">
                                        max-h-[300px] bg-white
                                    </x-slot>

                                    <x-dropdown-link wire:click.prevent='exportExcel' x-data="{ tooltip: 'Export to Excel' }"
                                        x-tooltip='tooltip'
                                        class="cursor-pointer flex flex-row gap-2 text-sm font-medium text-gray-500 bg-white rounded-lg shadow-sm hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                        <svg width="24px" height="24px" viewBox="-4.08 -4.08 32.16 32.16"
                                            xmlns="http://www.w3.org/2000/svg" fill="#6B7280" stroke="#6B7280"
                                            stroke-width="0.00024000000000000003">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round" stroke="#CCCCCC"
                                                stroke-width="0.4800000000000001"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                                    <path
                                                        d="M2.859 2.877l12.57-1.795a.5.5 0 0 1 .571.495v20.846a.5.5 0 0 1-.57.495L2.858 21.123a1 1 0 0 1-.859-.99V3.867a1 1 0 0 1 .859-.99zM17 3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4V3zm-6.8 9L13 8h-2.4L9 10.286 7.4 8H5l2.8 4L5 16h2.4L9 13.714 10.6 16H13l-2.8-4z">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                        <span class="flex">Export to Excel</span>
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="exportPdf" x-data="{ tooltip: 'Export to PDF' }"
                                        x-tooltip='tooltip'
                                        class="cursor-pointer flex flex-row gap-1 text-sm font-medium text-gray-500 bg-white rounded-lg shadow-sm hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                        <svg fill="#6B7280" version="1.1" id="Layer_1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            stroke="#6B7280" viewBox="-10 0 100.00 120.00"
                                            enable-background="new 0 0 100 100" xml:space="preserve">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <path
                                                        d="M94.284,65.553L75.825,52.411c-0.389-0.276-0.887-0.312-1.312-0.093c-0.424,0.218-0.684,0.694-0.685,1.173l0.009,6.221 H57.231c-0.706,0-1.391,0.497-1.391,1.204v11.442c0,0.707,0.685,1.194,1.391,1.194h16.774v6.27c0,0.478,0.184,0.917,0.609,1.136 s0.853,0.182,1.242-0.097l18.432-13.228c0.335-0.239,0.477-0.626,0.477-1.038c0-0.002,0-0.002,0-0.002 C94.765,66.179,94.621,65.793,94.284,65.553z">
                                                    </path>
                                                    <path
                                                        d="M64.06,78.553h-6.49h0c-0.956,0-1.73,0.774-1.73,1.73h-0.007v3.01H15.191V36.16h17.723c0.956,0,1.73-0.774,1.73-1.73 V16.707h21.188l0,36.356h0.011c0.021,0.937,0.784,1.691,1.726,1.691h6.49c0.943,0,1.705-0.754,1.726-1.691h0.004v-0.038 c0,0,0-0.001,0-0.001c0-0.001,0-0.001,0-0.002l0-40.522h-0.005V8.48c0-0.956-0.774-1.73-1.73-1.73h-2.45v0H32.914v0h-1.73 L5.235,32.7v2.447v1.013v52.912v2.447c0,0.956,0.774,1.73,1.73,1.73h1.582h53.925h1.582c0.956,0,1.73-0.774,1.73-1.73v-2.448h0.005 l0-8.789l0-0.001C65.79,79.328,65.015,78.553,64.06,78.553z">
                                                    </path>
                                                    <path
                                                        d="M21.525,61.862v9.231h2.795v-2.906h2.131c2.159,0,3.321-1.439,3.321-3.156c0-1.73-1.162-3.169-3.321-3.169H21.525z M26.936,65.031c0,0.484-0.374,0.72-0.844,0.72H24.32v-1.453h1.771C26.562,64.298,26.936,64.533,26.936,65.031z">
                                                    </path>
                                                    <path
                                                        d="M31.228,61.862v9.231h4.138c2.893,0,5.052-1.675,5.052-4.623s-2.159-4.608-5.065-4.608H31.228z M37.58,66.471 c0,1.163-0.83,2.187-2.228,2.187h-1.329v-4.36h1.342C36.86,64.298,37.58,65.225,37.58,66.471z">
                                                    </path>
                                                    <polygon
                                                        points="49.116,64.298 49.116,61.862 42.113,61.862 42.113,71.093 44.908,71.093 44.908,67.647 49.018,67.647 49.018,65.211 44.908,65.211 44.908,64.298 ">
                                                    </polygon>
                                                </g>
                                            </g>
                                        </svg>
                                        <span class="ps-1">
                                            Export to PDF
                                        </span>
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>

                            <x-dropdown align="left" width="36">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                        <div>
                                            {{ $jobTypeFilter ? $jobTypes[$jobTypeFilter] : 'Employment Type' }}
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

                                    <x-dropdown-link wire:click.prevent="updateJobType('')" class="cursor-pointer">
                                        All
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="updateJobType(1)" class="cursor-pointer">
                                        Full Time
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="updateJobType(2)" class="cursor-pointer">
                                        Contractual
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="updateJobType(3)" class="cursor-pointer">
                                        Part Time
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="updateJobType(4)" class="cursor-pointer">
                                        Project-Based
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="updateJobType(5)" class="cursor-pointer">
                                        Internship/OJT
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="updateJobType(6)" class="cursor-pointer">
                                        Work From Home
                                    </x-dropdown-link>


                                </x-slot>
                            </x-dropdown>

                            <button type="button" x-data="{ filterIndustry: @entangle('filterIndustry') }"
                                x-on:click.prevent="$dispatch('open-modal', 'industry-filter-modal')"
                                :class="filterIndustry.length > 0 ?
                                    'bg-blue-500 text-white hover:bg-blue-600' :
                                    'bg-white text-gray-500 hover:bg-gray-100'"
                                class="inline-flex max-h-fit items-center border border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                Industry Filter
                            </button>
                            <button type="button" x-data="{ filterJobTags: @entangle('filterJobTags') }"
                                x-on:click.prevent="$dispatch('open-modal', 'job-tag-filter-modal')"
                                :class="filterJobTags.length > 0 ?
                                    'bg-blue-500 text-white hover:bg-blue-600' :
                                    'bg-white text-gray-500 hover:bg-gray-100'"
                                class="inline-flex max-h-fit items-center border border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                Job Tags Filter
                            </button>




                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        {{-- TABLE --}}
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                <tr>
                                    <th scope="col" class="w-1/4 px-6 py-3">
                                        Company
                                    </th>
                                    <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                        Job Offering
                                    </th>
                                    <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                        Employment Type
                                    </th>
                                    <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                        Slots Available
                                    </th>
                                    <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                        @if ($filter == 'ACTIVE')
                                            Total Applicants
                                        @else
                                            Status
                                        @endif
                                    </th>
                                    <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                        Date Posted
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($jobpost->isEmpty())
                                    <tr>
                                        <td colspan="7">
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
                                    @foreach ($jobpost as $data)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row"
                                                class="flex flex-col px-6 py-4 text-gray-900 lg:flex-row lg:items-center whitespace-nowrap">
                                                <img class="select-none object-cover w-10 h-10 mb-2 rounded-full shadow-xl lg:mb-0"
                                                    src="{{ asset('storage/' . $data->company->company_img) }}"
                                                    alt="Company image">
                                                <div class="lg:ps-3 text-wrap">
                                                    <div class="text-base font-semibold">
                                                        {{ $data->company->business_Name }}
                                                    </div>
                                                    <div class="text-sm font-normal text-gray-500 uppercase">
                                                        {{ $data->company->company_Address }},
                                                        {{ $data->company->barangay->barangay_Name }},
                                                        {{ $data->company->barangay->municipality->municipality_Name }},
                                                        {{ $data->company->barangay->municipality->province->province_Name }}
                                                    </div>
                                                </div>
                                                <div class="block mt-2 text-sm text-gray-500 lg:hidden">
                                                    {{ $data->job_Title }}

                                                </div>
                                                <div class="block text-sm text-gray-500 lg:hidden">
                                                    {{ $data->slotsLeft }} slots

                                                </div>
                                                <div class="block text-sm text-gray-500 lg:hidden">
                                                    @if ($filter == 'ACTIVE')
                                                        {{ $data->job_applicants_count }} Applicants
                                                    @else
                                                        @if ($data->job_Status == 'ACTIVE')
                                                            <div class="flex items-center">
                                                                <div
                                                                    class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2">
                                                                </div>
                                                                ACTIVE
                                                            </div>
                                                        @elseif ($data->job_Status == 'PENDING')
                                                            <div class="flex items-center">
                                                                <div
                                                                    class="h-2.5 w-2.5 rounded-full bg-yellow-500 mr-2">
                                                                </div>
                                                                {{ $data->job_Status }}
                                                            </div>
                                                        @elseif ($data->job_Status == 'CLOSED')
                                                            <div class="flex items-center">
                                                                <div class="h-2.5 w-2.5 rounded-full bg-cyan-500 mr-2">
                                                                </div>
                                                                {{ $data->job_Status }}
                                                            </div>
                                                        @elseif ($data->job_Status == 'COMPLETED')
                                                            <div class="flex items-center">
                                                                <div class="h-2.5 w-2.5 rounded-full bg-blue-500 mr-2">
                                                                </div>
                                                                {{ $data->job_Status }}
                                                            </div>
                                                        @else
                                                            <div class="flex items-center">
                                                                <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2">
                                                                </div>
                                                                {{ $data->job_Status }}
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>

                                            </th>
                                            <td class="hidden px-6 py-4 lg:table-cell">
                                                {{ $data->job_Title }}
                                            </td>
                                            <td class="hidden px-6 py-4 lg:table-cell">
                                                {{ $jobTypes[$data->job_Type] }}
                                            </td>
                                            <td class="hidden px-6 py-4 lg:table-cell">
                                                {{ $data->slotsLeft }}
                                            </td>
                                            <td class="hidden px-6 py-4 lg:table-cell">
                                                <div class="flex items-center">
                                                    @if ($filter == 'ACTIVE')
                                                        {{ $data->job_applicants_count }}
                                                    @else
                                                        @if ($data->job_Status == 'ACTIVE')
                                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2">
                                                            </div>
                                                            ACTIVE
                                                        @elseif ($data->job_Status == 'PENDING')
                                                            <div class="h-2.5 w-2.5 rounded-full bg-yellow-500 me-2">
                                                            </div>
                                                            {{ $data->job_Status }}
                                                        @elseif ($data->job_Status == 'CLOSED')
                                                            <div class="h-2.5 w-2.5 rounded-full bg-cyan-500 me-2">
                                                            </div>
                                                            {{ $data->job_Status }}
                                                        @elseif ($data->job_Status == 'COMPLETED')
                                                            <div class="h-2.5 w-2.5 rounded-full bg-blue-500 me-2">
                                                            </div>
                                                            {{ $data->job_Status }}
                                                        @else
                                                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2">
                                                            </div>
                                                            {{ $data->job_Status }}
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="hidden px-6 py-4 lg:table-cell">
                                                <div class="text-base font-semibold">
                                                    {{ $data->created_at->format('g:i A') }}
                                                </div>
                                                <div class="text-base font-semibold">
                                                    {{ $data->created_at->format('F j, Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-row gap-5">
                                                    <div x-data="{ tooltip: 'View Job Post Information' }">
                                                        <a wire:navigate
                                                            href="{{ route('admin.jobpost', ['id' => $data->job_id]) }}"
                                                            x-tooltip="tooltip" type="button"
                                                            class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24" fill="currentColor">
                                                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                                <path fill-rule="evenodd"
                                                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </a>
                                                    </div>

                                                    @if ($filter == 'ACTIVE' || $filter == 'CLOSED' || $filter == 'COMPLETED')
                                                        <div x-data="{ tooltip: 'View Applicants' }">
                                                            <a wire:navigate
                                                                href="{{ route('admin.jobpost.applicants', ['id' => $data->job_id]) }}"
                                                                x-tooltip="tooltip" type="button"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center border rounded-lg text-cyan-700 border-cyan-700 hover:bg-cyan-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-cyan-300">
                                                                <svg class="w-5 h-5 " aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                                </svg>
                                                            </a>
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

                {{-- PAGINATION --}}
                <div class="mt-4">
                    {{ $jobpost->links('vendor.livewire.tailwind', data: ['scrollTo' => false]) }}
                </div>

            </div>



        </div>

    </div>



    <x-modal name="industry-filter-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Filter Industry') }}
            </h2>
            <hr>

            <div class="relative mt-4">
                <div class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">

                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>


                        <input wire:model.live='searchIndustry' type="search"
                            class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search industry">
                    </div>


                </div>


                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-center text-gray-500 rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                            <tr>
                                <th scope="col" class="w-1/4 px-6 py-3"> <!-- Hidden on small screens -->
                                </th>
                                <th scope="col" class="px-4 py-2 uppercase">Job Industry</th>
                                <th scope="col" class="hidden px-6 py-3 uppercase sm:table-cell">Code</th>
                                <!-- Hidden on small screens -->
                            </tr>
                        </thead>
                        <tbody>
                            @if ($industry->isEmpty())
                                <tr>
                                    <td colspan="3">
                                        <div class="flex flex-col items-center justify-center mt-24 mb-24">
                                            <div class="p-6 bg-gray-100 rounded-full">
                                                <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-width="2"
                                                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                </svg>
                                            </div>
                                            <p class="mt-2 text-xl font-bold text-center text-black">No Record Found!
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($industry as $data)
                                    <tr wire:key='industry-{{ $data->industry_id }}'
                                        class="bg-white border-b cursor-pointer hover:bg-gray-50"
                                        onclick="document.getElementById('industry-{{ $data->industry_id }}').click();">
                                        <td class="px-6 py-4 text-center">
                                            <!-- Hidden on small screens -->
                                            <input wire:model="mountIndustryFilter" type="checkbox"
                                                id="industry-{{ $data->industry_id }}"
                                                value="{{ $data->industry_id }}"
                                                onclick="document.getElementById('industry-{{ $data->industry_id }}').click();"
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
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-base font-semibold uppercase">{{ $data->industry_Title }}
                                            </div>
                                            <!-- Additional information for mobile view -->
                                            <div class="text-sm text-gray-500 sm:hidden">Code:
                                                {{ $data->industry_Code }}</div>
                                        </td>
                                        <td class="hidden px-4 py-2 sm:table-cell"> <!-- Hidden on small screens -->
                                            <div class="text-base font-semibold uppercase">{{ $data->industry_Code }}
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
            <div class="mt-4">
                {{ $industry->links('vendor.livewire.tailwind', data: ['scrollTo' => false]) }}
            </div>


            <div class="flex justify-between mt-6">
                <x-secondary-button type="button" x-data=""
                    x-on:click="$dispatch('close-modal', 'industry-filter-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <div>
                    <x-danger-button wire:click.prevent="resetIndustry">
                        {{ __('Reset') }}
                    </x-danger-button>
                    <x-primary-button wire:loading.attr="disabled" wire:click.prevent="mountIndustry" class="ms-3"
                        type="button">
                        {{ __('Confirm') }}
                        <div wire:loading.delay.long wire:target="mountIndustry" role="status">
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
        </div>

    </x-modal>

    <x-modal name="job-tag-filter-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Filter Job Tags') }}
            </h2>
            <hr>

            <div class="relative mt-4">
                <div class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>

                        <input type="search" wire:model.live='searchTags'
                            class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search Job Position">
                    </div>


                </div>
                <div class="overflow-x-auto ">

                    <table class="w-full text-sm text-center text-gray-500 rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                            <tr>
                                <th scope="col" class="w-1/4 px-6 py-3"></th> <!-- Hidden on small screens -->
                                <th scope="col" class="px-6 py-3 uppercase">Job Position</th>
                                <th scope="col" class="hidden px-6 py-3 uppercase md:table-cell">Code</th>
                                <!-- Hidden on smaller than md screens -->
                            </tr>
                        </thead>
                        <tbody>
                            @if ($jobposition->isEmpty())
                                <tr>
                                    <td colspan="3">
                                        <div class="flex flex-col items-center justify-center mt-24 mb-24">
                                            <div class="p-6 bg-gray-100 rounded-full">
                                                <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-width="2"
                                                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                </svg>
                                            </div>
                                            <p class="mt-2 text-xl font-bold text-center text-black">No Record Found!
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($jobposition as $data)
                                    <tr wire:key='jobTags-{{ $data->position_id }}'
                                        class="bg-white border-b cursor-pointer hover:bg-gray-50"
                                        onclick="document.getElementById('jobTags-{{ $data->position_id }}').click();">
                                        <td class="px-6 py-4 text-center">
                                            <input wire:model="mountJobTagsFilter" type="checkbox"
                                                id="jobTags-{{ $data->position_id }}"
                                                value="{{ $data->position_id }}"
                                                onclick="document.getElementById('jobTags-{{ $data->position_id }}').click();"
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
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-base font-semibold uppercase">
                                                {{ $data->position_Title }}
                                            </div>
                                            <div class="text-sm text-gray-600 sm:hidden">
                                                Code: {{ $data->position_Code }}
                                                <!-- Extra information for mobile screens -->
                                            </div>
                                        </td>
                                        <td class="hidden px-6 py-4 md:table-cell">
                                            <div class="text-base font-semibold uppercase">{{ $data->position_Code }}
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
            <div class="mt-4">
                {{ $jobposition->links('vendor.livewire.tailwind', data: ['scrollTo' => false]) }}
            </div>

            <div class="flex justify-between mt-6">
                <x-secondary-button type="button" x-data=""
                    x-on:click="$dispatch('close-modal', 'job-tag-filter-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <div>
                    <x-danger-button wire:click.prevent="resetJobTags">
                        {{ __('Reset') }}
                    </x-danger-button>
                    <x-primary-button wire:loading.attr="disabled" wire:click.prevent="mountJobTags" class="ms-3"
                        type="button">
                        {{ __('Confirm') }}
                        <div wire:loading.delay.long wire:target="mountJobTags" role="status">
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


        </div>


    </x-modal>

</div>
