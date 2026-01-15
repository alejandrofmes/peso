<div wire:poll>

    <div class="py-12">
        <div class="mx-auto max-w-7xl ">
            @if (Auth::check() && !$activePartnership)
                <div class="p-6 bg-yellow-100 rounded-lg shadow">
                    <div class="flex flex-row items-center justify-between">
                        <p class="text-xl font-bold text-yellow-700">
                            Access to job post applications is restricted. Please ensure your company has an active
                            partnership to access job posting.
                        </p>
                        <div x-data="{ tooltip: 'View company settings to review current partnerships status.' }">
                            <svg x-tooltip="tooltip" class="w-9 h-9 lg:w-9 lg:h-9 text-yellow-700 me-2.5 hover:scale-110"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 0 1-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 0 1-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 0 1-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                    </div>
                </div>
            @else
                <div class="overflow-hidden bg-white shadow-sm lg:rounded-lg">
                    <div class="flex flex-col w-full">
                        <div class="flex flex-row w-full">
                            <div class="flex flex-row">
                                <div class="p-6 text-xl font-medium text-gray-900">
                                    Welcome, <span class="font-bold text-black">
                                        {{ auth()->user()->company->business_Name }}!</span>
                                </div>
                            </div>
                            <div class="flex flex-col justify-center ml-auto mr-2">
                                <a wire:navigate href="{{ route('jobpost.apply') }}">
                                    <x-primary-button type="button" class="w-[150px] mr-2 justify-center">

                                        Post Job

                                    </x-primary-button>
                                </a>
                            </div>
                        </div>


                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="overflow-visible table-container">
        <div class="mx-auto overflow-visible max-w-7xl">
            <div class="p-2 overflow-visible bg-white lg:rounded-lg">


                <div class="p-2" x-data="{
                    filter: @entangle('filter').defer || 'ALL', // Set default value to 'ALL'
                    activeFilter: 'text-gray-900 bg-gray-400 active',
                    inactiveFilter: 'bg-gray-100 hover:text-gray-700 hover:bg-gray-50',
                    changeFilter(value) {
                        this.filter = value;
                        this.$wire.call('changeFilter', value); // Update Livewire filter property
                    },
                    init() {
                        // Ensure Livewire and Alpine.js sync on initialization
                        this.$watch('filter', value => {
                            this.changeFilter(value); // Ensure Livewire is updated when filter changes
                        });
                    }
                }" x-init="init()">
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
                    <ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow lg:flex ">
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
                </div>



                <div class="relative">
                    <div
                        class="flex flex-col gap-2 p-1 space-y-4 lg:flex-row lg:justify-between lg:space-y-0 overflow-visbile">


                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input wire:model.live='search' type="search" id="table-search-users"
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search for job posting">
                        </div>
                        <div class="flex flex-wrap gap-2 mr-3">
                            {{-- SORT --}}
                            <x-dropdown align="left" width="36">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                        <div>
                                            {{ $sortDate === 'ASC' ? 'Newest' : ($sortDate == 'DESC' ? 'Oldest' : 'Sort by Date') }}
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
                                        max-w-[300px] bg-white
                                    </x-slot>

                                    <x-dropdown-link class="cursor-pointer" wire:click.prevent="updateSort('ASC')">
                                        Newest
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <x-dropdown-link class="cursor-pointer" wire:click.prevent="updateSort('DESC')">
                                        Oldest
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>

                    <div class="mt-2 overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right lg:table-fixed">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 md:w-96">
                                        Job Title
                                    </th>
                                    <th scope="col" class="px-6 py-3 md:w-64">
                                        Candidates
                                    </th>
                                    <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                        PESO Branch
                                    </th>
                                    <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                        Status
                                    </th>
                                    <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($applicants->isEmpty())
                                    <tr>
                                        <td colspan="6">
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
                                                    No Job Posting Found
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($applicants as $data)
                                        <tr wire:key='jobPost-{{ $data->job_id }}' class="bg-white border-b">
                                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900">
                                                <div class="ps-3">
                                                    <div class="text-base font-semibold">{{ $data->job_Title }}</div>
                                                    <div
                                                        class="text-xs font-normal text-gray-500 uppercase lg:text-sm">
                                                        {{ $data->job_Address }},
                                                        {{ $data->barangay->barangay_Name }},
                                                        {{ $data->barangay->municipality->municipality_Name }},
                                                        {{ $data->barangay->municipality->province->province_Name }}
                                                    </div>
                                                    <!-- Additional info for mobile view -->
                                                    <div class="mt-2 lg:hidden">
                                                        <span class="block text-xs text-gray-600">PESO Branch:
                                                            {{ $data->peso->municipality->municipality_Name }}</span>
                                                        <span class="block text-xs text-gray-600">Status:
                                                            {{ $data->job_Status }}</span>
                                                        <span class="block text-xs text-gray-600">Date:
                                                            {{ $data->created_at->format('F j, Y') }}</span>
                                                    </div>
                                                </div>
                                            </th>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-wrap gap-2">
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-200 rounded-md ring-1 ring-inset ring-yellow-600/20">{{ $data->pending_count }}
                                                        PENDING</span>
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-purple-800 bg-purple-200 rounded-md ring-1 ring-inset ring-purple-600/20">{{ $data->interested_count }}
                                                        INTERESTED</span>
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-200 rounded-md ring-1 ring-inset ring-blue-600/20">{{ $data->interview_count }}
                                                        INTERVIEW</span>
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">{{ $data->hired_count }}
                                                        HIRED</span>
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-emerald-200 text-emerald-800 ring-1 ring-inset ring-emerald-600/20">{{ $data->accepted_count }}
                                                        ACCEPTED</span>
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-800 bg-red-200 rounded-md ring-1 ring-inset ring-red-600/20">{{ $data->rejected_count }}
                                                        REJECTED</span>
                                                </div>
                                            </td>
                                            <td class="hidden px-6 py-4 lg:table-cell">
                                                <div class="text-sm font-normal text-gray-500">
                                                    {{ $data->peso->municipality->municipality_Name }}
                                                </div>
                                            </td>
                                            <td class="hidden px-6 py-4 lg:table-cell">
                                                <div class="flex items-center">
                                                    @if ($data->job_Status == 'ACTIVE')
                                                        <div
                                                            class="h-1.5 w-1.5 rounded-full bg-green-500 me-1 uppercase">
                                                        </div> ACTIVE
                                                    @elseif ($data->job_Status == 'PENDING')
                                                        <div
                                                            class="h-1.5 w-1.5 rounded-full bg-yellow-500 me-1 uppercase">
                                                        </div> PENDING
                                                    @elseif ($data->job_Status == 'CLOSED')
                                                        <div
                                                            class="h-1.5 w-1.5 rounded-full bg-cyan-500 me-1 uppercase">
                                                        </div> CLOSED
                                                    @elseif ($data->job_Status == 'COMPLETED')
                                                        <div
                                                            class="h-1.5 w-1.5 rounded-full bg-blue-500 me-1 uppercase">
                                                        </div> COMPLETED
                                                    @else
                                                        <div
                                                            class="h-1.5 w-1.5 rounded-full bg-red-500 me-1 uppercase">
                                                        </div> {{ $data->job_Status }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="hidden px-6 py-4 lg:table-cell">
                                                <div class="text-sm font-normal text-gray-500">
                                                    {{ $data->created_at->format('F j, Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-row gap-2">
                                                    @if ($filter == 'PENDING' && $data->job_Status == 'PENDING')
                                                        <div x-data="{ tooltip: 'Edit Job Post' }">
                                                            <button
                                                                wire:click.prevent='editJobPost({{ $data->job_id }})'
                                                                x-tooltip="tooltip" type="button"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center border rounded-lg text-cyan-700 border-cyan-700 hover:bg-cyan-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-cyan-300">

                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                </svg>

                                                            </button>
                                                        </div>
                                                    @endif

                                                    <div x-data="{ tooltip: 'View Job Post' }">
                                                        <a wire:navigate
                                                            href="{{ route('jobpost.show', ['id' => $data->job_id]) }}"
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


                                                    <div x-data="{ tooltip: 'View Details' }">
                                                        <a wire:navigate
                                                            href="{{ route('jobpost.details', ['id' => $data->job_id]) }}"
                                                            x-tooltip="tooltip" type="button"
                                                            class="inline-flex items-center p-1 text-sm font-medium text-center border rounded-lg text-cyan-700 border-cyan-700 hover:bg-cyan-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-cyan-300">
                                                            <svg class="w-5 h-5 " xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                                            </svg>

                                                        </a>
                                                    </div>


                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                    </div>

                </div>
                <div class="p-4">
                    {{ $applicants->links('vendor.livewire.tailwind') }}
                </div>






            </div>
        </div>
    </div>
</div>
