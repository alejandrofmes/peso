<div class="container py-8 mx-auto">




    <div class="grid grid-cols-4 gap-4 p-3 lg:grid-cols-12 lg:p-0" x-data="{ selectedAnalytics: @entangle('selectedAnalytics') }">
        <div class="col-span-4 md:col-span-12">

            <h1 class="text-2xl font-bold">Reports / Municipality</h1>

        </div>



        <div class="col-span-2 md:col-span-3">
            <div class="flex flex-col h-full p-6 bg-blue-100 rounded-lg shadow">
                <div class="flex flex-row justify-start">
                    <h1 class="font-mono text-sm font-thin">Analytics:</h1>
                </div>

                <div class="flex flex-row justify-between w-full gap-5 mt-auto mb-5">
                    <div class="flex flex-col w-full">
                        <x-dropdown align="left" width="full">
                            <x-slot name="trigger">
                                <button
                                    class="mt-1 inline-flex h-full items-center text-gray-800 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-md px-1.5 py-2 w-full">
                                    <div class="w-full ml-2 font-mono text-sm font-extrabold text-left md:text-xl ">
                                        {{ $analyticsValue ?? 'Analytics' }}
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

                                <!-- Dropdown content with scrollbar -->
                                <div class="max-h-[300px] bg-white overflow-y-auto">
                                    <!-- Dropdown links -->

                                    <x-dropdown-link wire:click.prevent='updateAnalytics(1)'
                                        class="flex items-center px-4 py-2 space-x-2 uppercase cursor-pointer hover:bg-gray-100">
                                        <span>Jobseekers</span>
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                        </svg>
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent='updateAnalytics(2)'
                                        class="flex items-center px-4 py-2 space-x-2 uppercase cursor-pointer hover:bg-gray-100">
                                        <span>Trends</span>
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                                        </svg>

                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent='updateAnalytics(3)'
                                        class="flex items-center px-4 py-2 space-x-2 uppercase cursor-pointer hover:bg-gray-100">
                                        <span>Top</span>
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                                        </svg>

                                    </x-dropdown-link>


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

        <div class="col-span-2 lg:col-span-3">
            <div class="flex flex-col w-full h-full p-6 bg-white rounded-lg shadow">
                <div class="flex flex-row justify-start">
                    <h1 class="font-mono text-sm font-thin">Active Job Postings</h1>
                </div>
                <div class="flex flex-row justify-between mb-5">
                    <h1 class="font-mono text-4xl font-extrabold">{{ $activeJobPosting }}</h1>

                    <svg class="hidden w-10 h-10 text-blue-500 lg:flex" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>


                </div>
                <div class="flex flex-row justify-content">

                    <h1 class="font-mono text-sm font-thin"><span
                            class="bg-green-100 text-green-800 text-md font-medium me-2 px-2.5 py-0.5 rounded">
                            </i>{{ $recentJobPosting }}</span>New Job
                        Postings
                    </h1>
                </div>


            </div>

        </div>

        <div class="col-span-2 lg:col-span-3">
            <div class="flex flex-col w-full h-full p-6 bg-white rounded-lg shadow">
                <div class="flex flex-row justify-start">
                    <h1 class="font-mono text-sm font-thin">Active Job Slots</h1>
                </div>
                <div class="flex flex-row justify-between mb-5">
                    <h1 class="font-mono text-4xl font-extrabold">{{ $remainingSlots }}</h1>

                    <svg class="hidden w-10 h-10 text-blue-500 lg:flex" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>

                </div>
                <div class="flex flex-row justify-content">

                    <h1 class="font-mono text-sm font-thin"><span
                            class="bg-green-100 text-green-800 text-md font-medium me-2 px-2.5 py-0.5 rounded">
                            </i> {{ $totalJobSlots }}</span>Total
                        Active
                        Job Slots
                    </h1>
                </div>


            </div>

        </div>



        <div class="col-span-2 lg:col-span-3">
            <div class="flex flex-col w-full h-full p-6 bg-white rounded-lg shadow">
                <div class="flex flex-row justify-start">
                    <h1 class="font-mono text-sm font-thin">Active Job Applicants</h1>
                </div>
                <div class="flex flex-row justify-between mb-5">
                    <h1 class="font-mono text-4xl font-extrabold">{{ $activeApplicants }}</h1>

                    <svg class="hidden w-10 h-10 text-blue-500 lg:flex" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>



                </div>
                <div class="flex flex-row justify-content">

                    <h1 class="font-mono text-sm font-thin"><span
                            class="bg-green-100 text-green-800 text-md font-medium me-2 px-2.5 py-0.5 rounded">

                            {{ $recentApplicants }}</span>Recent Job Applications
                    </h1>
                </div>


            </div>

        </div>

        <div class="w-full h-full col-span-4 md:col-span-12" x-show="selectedAnalytics == 1"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100" x-cloak>
            @if ($selectedAnalytics === 1)
                <div class="flex flex-col w-full gap-4 md:flex-row">
                    <div class="flex w-full">
                        <livewire:admin.reports.municipality-partials.barangay-jobseekers
                            municipalityID="{{ $pesoMunicipalityId }}" />
                    </div>

                    <div class="flex w-full">
                        <livewire:admin.reports.municipality-partials.employment-age-group
                            municipalityID="{{ $pesoMunicipalityId }}" />
                    </div>

                    <div class="flex w-full">
                        <livewire:admin.reports.municipality-partials.program-registrants-trends
                            municipalityID="{{ $pesoMunicipalityId }}" />
                    </div>
                </div>
            @endif
        </div>

        <div class="w-full h-full col-span-4 md:col-span-12" x-show="selectedAnalytics == 2"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100" x-cloak>
            @if ($selectedAnalytics === 2)
                <div class="flex flex-col w-full gap-4 md:flex-row">
                    <div class="flex w-full">
                        <livewire:admin.reports.municipality-partials.recommendation-trends
                            municipalityID="{{ $pesoMunicipalityId }}" />
                    </div>
                    <div class="flex w-full">
                        <livewire:admin.reports.municipality-partials.employment-trends
                            municipalityID="{{ $pesoMunicipalityId }}" />
                    </div>
                    <div class="flex w-full">

                        <livewire:admin.reports.municipality-partials.job-posting-trends
                            municipalityID="{{ $pesoMunicipalityId }}" />

                    </div>
                </div>
            @endif
        </div>

        <div class="w-full h-full col-span-4 md:col-span-12" x-show="selectedAnalytics == 3"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100" x-cloak>
            @if ($selectedAnalytics === 3)
                <div class="flex flex-col w-full gap-4 md:flex-row">
                    <div class="flex w-full">
                        <livewire:admin.reports.municipality-partials.top-job-tags
                            municipalityID="{{ $pesoMunicipalityId }}" />

                    </div>
                    <div class="flex w-full">
                        <livewire:admin.reports.municipality-partials.top-job-industry
                            municipalityID="{{ $pesoMunicipalityId }}" />
                    </div>
                    <div class="flex w-full">

                        <livewire:admin.reports.municipality-partials.top-job-preference
                            municipalityID="{{ $pesoMunicipalityId }}" />
                    </div>
                </div>
            @endif

        </div>

        {{-- TABLES --}}
        <div class="col-span-4 md:col-span-6">
            <div class="w-full h-full p-6 overflow-auto bg-white rounded-lg shadow">
                <livewire:admin.reports.municipality-partials.jobseekers-list
                    municipalityID="{{ $pesoMunicipalityId }}" />
            </div>
        </div>

        <div class="col-span-4 md:col-span-6">

            <livewire:admin.reports.municipality-partials.popular-trainings
                municipalityID="{{ $pesoMunicipalityId }}" />


            <livewire:admin.reports.municipality-partials.top-tags-programs
                municipalityID="{{ $pesoMunicipalityId }}" />

        </div>








    </div>
</div>
