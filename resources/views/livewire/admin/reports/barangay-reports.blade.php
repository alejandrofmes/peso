<div class="container py-8 mx-auto">
    <div class="grid grid-cols-4 gap-4 p-3 md:grid-cols-12 md:p-0">


        <div class="col-span-4 md:col-span-12">

            <h1 class="text-2xl font-bold">Reports / Barangay</h1>

        </div>



        <div class="col-span-2 md:col-span-3">
            <div class="flex flex-col h-full p-6 bg-blue-100 rounded-lg shadow">
                <div class="flex flex-row justify-start">
                    <h1 class="font-mono text-sm font-thin">Selected Barangay:</h1>
                </div>

                <div class="flex flex-row justify-between w-full gap-5 mt-auto mb-5">
                    <div class="flex flex-col w-full">
                        <x-dropdown align="left" width="full">
                            <x-slot name="trigger">
                                <button
                                    class="mt-1 inline-flex h-full items-center text-gray-800 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-md px-1.5 py-2 w-full">
                                    <div class="w-full ml-2 font-mono text-xl font-extrabold text-left ">
                                        {{ $barTitle }}
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
                                    <input wire:model.live='searchBar' type="search" placeholder="Search..."
                                        class="block w-full px-3 py-1.5 mb-2 border border-gray-300 rounded-md focus:outline-none"
                                        @click.stop>
                                </div>

                                <!-- Dropdown content with scrollbar -->
                                <div class="max-h-[300px] bg-white overflow-y-auto">
                                    <!-- Dropdown links -->
                                    @foreach ($barangay as $data)
                                        <x-dropdown-link wire:click.prevent='barSelect({{ $data->barangay_id }})'
                                            class="block px-4 py-2 uppercase cursor-pointer hover:bg-gray-100">{{ $data->barangay_Name }}</x-dropdown-link>
                                    @endforeach
                                </div>
                            </x-slot>

                        </x-dropdown>
                    </div>

                    <svg class="hidden w-10 h-10 text-blue-500 sm:flex" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>




                </div>




            </div>

        </div>

        <div class="col-span-2 md:col-span-3">
            <div class="flex flex-col h-full p-6 bg-white rounded-lg shadow">
                <div class="flex flex-row justify-start">
                    <h1 class="font-mono text-sm font-thin">Jobseekers</h1>
                </div>
                <div class="flex flex-row justify-between mb-5">
                    <h1 class="font-mono text-4xl font-extrabold">{{ $totalJobSeekers }}</h1>

                    <svg class="hidden w-10 h-10 text-blue-500 sm:flex" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>

                </div>
                <div class="flex flex-row justify-content">

                    <h1 class="font-mono text-sm font-thin"><span
                            class="bg-green-100 text-green-800 text-md font-medium me-2 px-2.5 py-0.5 rounded">{{ $recentJobSeekers }}</span>New
                        Job
                        Seekers
                    </h1>
                </div>


            </div>

        </div>

        <div class="col-span-2 md:col-span-3">
            <div class="flex flex-col h-full p-6 bg-white rounded-lg shadow">
                <div class="flex flex-row justify-start">
                    <h1 class="font-mono text-sm font-thin">Employed Users</h1>
                </div>
                <div class="flex flex-row justify-between mb-5">
                    <h1 class="font-mono text-4xl font-extrabold">{{ $totalEmployed }}</h1>

                    <svg class="hidden w-10 h-10 text-blue-500 sm:flex" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>


                </div>
                <div class="flex flex-row justify-content">

                    <h1 class="font-mono text-sm font-thin"><span
                            class="bg-green-100 text-green-800 text-md font-medium me-2 px-2.5 py-0.5 rounded">
                            {{ $totalUnemployed }}</span>Unemployed
                    </h1>
                </div>


            </div>

        </div>

        <div class="col-span-2 md:col-span-3">
            <div class="flex flex-col h-full p-6 bg-white rounded-lg shadow">
                <div class="flex flex-row justify-start">
                    <h1 class="font-mono text-sm font-thin">Active Applications</h1>
                </div>
                <div class="flex flex-row justify-between mb-5">
                    <h1 class="font-mono text-4xl font-extrabold">{{ $totalActiveApplicants }}</h1>

                    <svg class="hidden w-10 h-10 text-blue-500 sm:flex" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>


                </div>
                <div class="flex flex-row justify-content">

                    <h1 class="font-mono text-sm font-thin"><span
                            class="bg-green-100 text-green-800 text-md font-medium me-2 px-2.5 py-0.5 rounded">
                            {{ $recentActiveApplicants }}</span>New Applications
                    </h1>
                </div>


            </div>

        </div>



        <div class="col-span-4">
            <livewire:admin.reports.barangay-partials.job-tags-column barangayID="{{ $selectedBar }}" />

        </div>
        <div class="col-span-4">
            <livewire:admin.reports.barangay-partials.industry-column barangayID="{{ $selectedBar }}" />

        </div>
        <div class="col-span-4">
            <livewire:admin.reports.barangay-partials.employment-trends barangayID="{{ $selectedBar }}" />
        </div>




        <div class="col-span-4 md:col-span-6">
            <div class="w-full h-full p-6 overflow-auto bg-white rounded-lg shadow">
                <div class="mb-5">
                    <h1 class="text-2xl font-bold">{{ $barTitle }} JOBSEEKERS</h1>
                    <hr class="h-px my-2 bg-gray-200 border-0">
                </div>
                <livewire:admin.reports.barangay-partials.jobseeker-list barangayID="{{ $selectedBar }}" />


            </div>

        </div>
        <div class="col-span-4 md:col-span-6">
            <livewire:admin.reports.barangay-partials.popular-trainings barangayID="{{ $selectedBar }}" />

        </div>







    </div>
</div>
