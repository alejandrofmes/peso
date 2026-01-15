<div wire:poll class="container py-8 mx-auto">
    <div class="grid grid-cols-4 gap-4 p-3 lg:grid-cols-12 lg:p-0">

        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Partnerships</h1>
        </div>

        <div class="col-span-4 lg:col-span-12">
            <div class="p-6 bg-white rounded-lg shadow" x-data="{
                filter: @entangle('filter').defer || '', // Default value is ''
                activeClasses: 'text-gray-900 bg-gray-400 active',
                inactiveClasses: 'bg-gray-100 hover:text-gray-700 hover:bg-gray-50',
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
                            <option value="">All</option>
                            <option value="PENDING">PENDING</option>
                            <option value="APPROVED">ACTIVE</option>
                            <option value="OTHERS">OTHERS</option>
                        </select>
                    </div>

                    <!-- Desktop Tabs -->
                    <ul class="hidden mb-3 text-sm font-medium text-center text-gray-500 rounded-lg shadow lg:flex">
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('')"
                                :class="filter === '' ? activeClasses : inactiveClasses"
                                class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none rounded-s-lg"
                                aria-current="page">All</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('PENDING')"
                                :class="filter === 'PENDING' ? activeClasses : inactiveClasses"
                                class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none">PENDING</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('APPROVED')"
                                :class="filter === 'APPROVED' ? activeClasses : inactiveClasses"
                                class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none">ACTIVE</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('OTHERS')"
                                :class="filter === 'OTHERS' ? activeClasses : inactiveClasses"
                                class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none rounded-e-lg">OTHERS</button>
                        </li>
                    </ul>


                    <div class="relative p-1 lg:mt-2">
                        <div class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">


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
                                <input wire:model.live='search' type="search"
                                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Search">
                            </div>

                        </div>

                        {{-- TABLE --}}
                        <div class="overflow-x-auto ">
                            <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                                <thead class="hidden text-xs text-gray-700 uppercase bg-gray-300 lg:table-header-group">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Business Name
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                            Company Type
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                            Employer Type
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                            Partnership Status
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                            Joined Date
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($partnersData->isEmpty())
                                        <tr>
                                            <td colspan="5">
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
                                                        No Pending Partnerships Found!
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($partnersData as $data)
                                            <tr wire:key='company-{{ $data->company->company_id }}'
                                                class="bg-white border-b hover:bg-gray-50">
                                                <!-- Business Name and Address for Mobile -->
                                                <th scope="row"
                                                    class="flex flex-col px-6 py-4 text-gray-900 lg:flex-row lg:items-center whitespace-nowrap">
                                                    <img class="select-none w-10 h-10 mb-2 rounded-full shadow-xl cover-full lg:mb-0"
                                                        src="{{ asset('storage/' . $data->company->company_img) }}"
                                                        alt="company-{{ $data->company->company_id }}">
                                                    <div class="ps-3 text-wrap">
                                                        <div class="text-base font-bold uppercase">
                                                            {{ $data->company->business_Name }}</div>
                                                        <div class="text-sm font-normal text-gray-500 uppercase">
                                                            {{ $data->company->company_Address }},
                                                            {{ $data->company->barangay->barangay_Name }},
                                                            {{ $data->company->barangay->municipality->municipality_Name }}
                                                        </div>
                                                        <div class="block mt-2 text-sm text-gray-500 lg:hidden">
                                                            <div class="font-semibold text-gray-700">Company Type:</div>
                                                            <div>
                                                                {{ $data->company->company_Type == 1 ? 'MAIN' : 'BRANCH' }}
                                                            </div>
                                                        </div>
                                                        <div class="block mt-2 text-sm text-gray-500 lg:hidden">
                                                            <div class="font-semibold text-gray-700">Employer Type:
                                                            </div>
                                                            <div>
                                                                {{ $data->company->employer_Type == 1 ? 'PUBLIC' : 'PRIVATE' }}
                                                            </div>
                                                        </div>
                                                        <div class="block mt-2 text-sm text-gray-500 lg:hidden">
                                                            <div class="font-semibold text-gray-700">Joined Date:</div>
                                                            <div>{{ $data->company->created_at->format('F j, Y') }}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </th>

                                                <!-- Company Type for larger screens -->
                                                <td class="hidden px-6 py-4 lg:table-cell">
                                                    <div class="text-sm font-semibold text-gray-500 ">
                                                        {{ $data->company->company_Type == 1 ? 'MAIN' : 'BRANCH' }}
                                                    </div>
                                                </td>

                                                <!-- Employer Type for larger screens -->
                                                <td class="hidden px-6 py-4 lg:table-cell">
                                                    <div class="text-sm font-semibold text-gray-500">
                                                        {{ $data->company->employer_Type == 1 ? 'PUBLIC' : 'PRIVATE' }}
                                                    </div>
                                                </td>

                                                <!-- Partnership Status -->
                                                <td class="hidden px-6 py-4 lg:table-cell">
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
                                                </td>

                                                <!-- Joined Date for larger screens -->
                                                <td class="hidden px-6 py-4 lg:table-cell">
                                                    {{ $data->company->created_at->format('F j, Y') }}
                                                </td>

                                                <!-- Action buttons -->
                                                <td class="px-6 py-4">
                                                    <div class="flex flex-row gap-5">
                                                        <div x-data="{ tooltip: 'View Details' }">
                                                            <a wire:navigate
                                                                href="{{ route('admin-partnership-details', ['id' => $data->partnership_id]) }}"
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
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Mobile-specific row (for company details) -->
                                            <tr class="block lg:hidden">
                                                <td colspan="6" class="px-6 py-3">

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
                        {{ $partnersData->links('vendor.livewire.tailwind') }}
                    </div>
                </div>



            </div>

        </div>
    </div>
