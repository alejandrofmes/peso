<div class="container py-8 mx-auto">
    <div class="grid grid-cols-4 gap-4 p-3 lg:grid-cols-12 lg:p-0">

        {{-- TITLE --}}
        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Employer Management \ Employer Overview</h1>
        </div>

        <div class="col-span-4 mt-5 lg:col-span-12">

            <div class="flex flex-col justify-between gap-2 lg:flex-row">

                <div class="flex flex-col">
                    <h1 class="text-xl font-medium">Employer ID: {{ $employer->company_id }}</h1>
                    <h1 class="font-light text-gray-500 text-md">{{ $employer->created_at->format('F j, Y, g:i A') }}
                    </h1>
                </div>

                {{-- DEACTIVATE BUTTON --}}
                @if (Auth::check() && Auth::user()->usertype == 10)
                    <div class="flex flex-row justify-center gap-4">
                        <button type="button" x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'partnership-modal')"
                            class="px-4 py-2 font-semibold text-white transition duration-300 ease-in-out transform bg-blue-500 rounded-lg text-md hover:bg-blue-600 hover:scale-105 focus:ring-4 focus:ring-blue-300 focus:outline-none">
                            Cancel Partnership
                        </button>
                        @if ($employer->user->userstatus == 1)
                            <button type="button" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'deactivate-modal')"
                                class="px-4 py-2 font-semibold text-white transition duration-300 ease-in-out transform bg-red-500 rounded-lg text-md hover:bg-red-600 hover:scale-105 focus:ring-4 focus:ring-red-300 focus:outline-none">
                                Deactivate Account
                            </button>
                        @elseif($employer->user->userstatus == 2)
                            <button type="button" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'reactivate-modal')"
                                class="px-4 py-2 font-semibold text-white transition duration-300 ease-in-out transform bg-green-500 rounded-lg text-md hover:bg-green-600 hover:scale-105 focus:ring-4 focus:ring-green-300 focus:outline-none">
                                Reactivate Account
                            </button>
                        @endif

                    </div>
                @endif

            </div>

        </div>

        {{-- PROFILE CONTAINER --}}
        <div class="col-span-4 lg:col-span-4">
            <div class="p-6 bg-white rounded-lg shadow">

                <div class="flex flex-col items-center">
                    {{-- IMAGE --}}
                    <img src="{{ asset('storage/' . $employer->company_img) }}"
                        class="select-none object-cover w-32 h-32 mb-4 bg-gray-300 rounded-md shrink-0 grow-0">

                    </img>

                    <h1 class="text-xl font-bold text-center uppercase"> {{ $employer->business_Name }}
                    </h1>
                    <p class="text-gray-700">#{{ $employer->user_id }}</p>
                </div>

                <hr class="my-6 border-t border-gray-300">

                <div class="flex flex-col">

                    <span class="mb-2 text-xl font-black tracking-wider text-gray-700 uppercase">Contact Details</span>

                    <ul>
                        @if ($partnership)
                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">Partnership Date:</li>
                                <p class="text-right uppercase break-all ms-4">
                                    {{ $partnership->responded_at->format('F j, Y') }}
                                </p>
                            </div>
                        @endif
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Contact Person:</li>
                            <p class="text-right break-all ms-4">{{ $employer->contact_Person }}</p>
                        </div>
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Position:</li>
                            <p class="text-right break-all ms-4">{{ $employer->contact_Person_position }}</p>
                        </div>

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Phone Number:</li>
                            <p class="text-right break-all ms-4">{{ $employer->company_Pnum }}</p>
                        </div>

                        @if ($employer->company_Tnum)
                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">Telephone Number:</li>
                                <p class="text-right break-all ms-4">{{ $employer->company_Tnum }}</p>
                            </div>
                        @endif

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Email:</li>
                            <p class="text-right break-all ms-4">{{ $employer->company_Email }}</p>
                        </div>

                        @if ($employer->company_Fnum)
                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">Fax:</li>
                                <p class="text-right break-all ms-4">{{ $employer->company_Fnum }}</p>
                            </div>
                        @endif

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold ">Address:</li>
                            <p class="text-right uppercase break-all ms-4"> {{ $employer->company_Address }},
                                {{ $employer->barangay->barangay_Name }},
                                {{ $employer->barangay->municipality->municipality_Name }},
                                {{ $employer->barangay->municipality->province->province_Name }}</p>
                        </div>


                    </ul>


                    {{-- BUTTON --}}
                    {{-- <div class="flex flex-wrap justify-center gap-4 mt-6">
                        <a href="#" class="px-4 py-2 text-white bg-blue-700 rounded hover:bg-blue-800">View
                            NSRP</a>
                    </div> --}}

                </div>

            </div>


            <div class="p-6 mt-4 bg-white rounded-lg shadow">
                <h1 class="text-2xl font-bold">Company Requirements</h1>
                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                <div class="flex flex-row flex-wrap w-full gap-2">
                    @foreach ($requirements as $requirement)
                        @if ($requirement->requirementPassed)
                            <div class="flex flex-col w-full ">
                                <button
                                    wire:click.prevent='viewFile({{ $requirement->requirementPassed->req_passed_id }})'
                                    type="button"
                                    class="text-blue-900 bg-blue-400 hover:bg-blue-100 border border-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2">
                                    <i class="fa-solid fa-file-contract me-2"></i>
                                    View {{ $requirement->requirement_Title }}
                                    <svg class="w-6 h-6 ml-auto mr-0" xmlns="http://www.w3.org/2000/svg" width="24"
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

                                    <svg class="w-6 h-6 ml-auto mr-0" xmlns="http://www.w3.org/2000/svg" fill="none"
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
        <div class="col-span-4 lg:col-span-8 row" x-data="{
            selectedTab: 1,
            activeTab: 'text-white  bg-blue-700 active',
            inactiveTab: 'hover:text-white-300 bg-gray-300 hover:bg-gray-400',
            activeIcon: 'text-white',
            inactiveIcon: 'text-gray-500'
        }">

            {{-- TAB BUTTON --}}
            <ul class="flex flex-wrap gap-4 mb-4 text-sm font-medium text-gray-500 md:me-4 md:mb-0">
                <li>
                    <button @click="selectedTab = 1" :class="selectedTab === 1 ? activeTab : inactiveTab"
                        class="inline-flex items-center w-full px-4 py-3 rounded-lg" aria-current="page">
                        <svg :class="selectedTab === 1 ? activeIcon : inactiveIcon" class="w-4 h-4 me-2"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                        </svg>
                        Overview
                    </button>
                </li>

                <li>
                    <button @click="selectedTab = 2" :class="selectedTab === 2 ? activeTab : inactiveTab"
                        class="inline-flex items-center w-full px-4 py-3 rounded-lg">
                        <svg :class="selectedTab === 2 ? activeIcon : inactiveIcon" class="w-4 h-4 me-2"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z"
                                clip-rule="evenodd" />
                        </svg>

                        Security
                    </button>
                </li>
                <li>
                    <button @click="selectedTab = 3" :class="selectedTab === 3 ? activeTab : inactiveTab"
                        class="inline-flex items-center w-full px-4 py-3 rounded-lg" aria-current="page">

                        <svg :class="selectedTab === 3 ? activeIcon : inactiveIcon" class="w-4 h-4 me-2"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M15.988 3.012A2.25 2.25 0 0 1 18 5.25v6.5A2.25 2.25 0 0 1 15.75 14H13.5V7A2.5 2.5 0 0 0 11 4.5H8.128a2.252 2.252 0 0 1 1.884-1.488A2.25 2.25 0 0 1 12.25 1h1.5a2.25 2.25 0 0 1 2.238 2.012ZM11.5 3.25a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 .75.75v.25h-3v-.25Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M2 7a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7Zm2 3.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Zm0 3.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z"
                                clip-rule="evenodd" />
                        </svg>

                        Audits
                    </button>
                </li>
            </ul>

            {{-- 1ST TAB --}}
            <div x-show="selectedTab === 1" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-cloak>


                <div class="p-6 mt-4 bg-white rounded-lg shadow">
                    <h1 class="text-2xl font-bold ">Overview</h1>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                    <div class="flex flex-col w-full gap-4">
                        <div class="flex flex-col ">

                            <span class="mb-1 font-bold">Company Industry:</span>

                            {{-- BADGE CONTAINER --}}
                            <div id= "otherSkillRow" class="p-1 flex-inline">
                                {{-- BADGE --}}

                                @foreach ($employer->company_industry_line as $industryLine)
                                    <span wire:key='skills-{{ $industryLine->company_industry_line_id }}'
                                        class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-2 ps-3 pe-3 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $industryLine->job_industry->industry_Title }}
                                    </span>
                                @endforeach
                            </div>

                        </div>
                        <div class="flex flex-col ">

                            <span class="mb-1 font-bold">Company Partnerships:</span>


                            {{-- BADGE CONTAINER --}}
                            <div id= "otherSkillRow" class="p-1 flex-inline">
                                {{-- BADGE --}}

                                @foreach ($employer->partnerships as $partnership)
                                    <span wire:key='skills-{{ $partnership->partnership_id }}'
                                        class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-2 ps-3 pe-3 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        PESO {{ $partnership->peso->municipality->municipality_Name }}
                                    </span>
                                @endforeach
                            </div>

                        </div>



                        <div class="flex flex-col w-full">
                            <span class="mb-1 font-bold">Company Charts:</span>
                            <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                            <div class="flex flex-row h-[400px] lg:h-full items-end">
                                <livewire:livewire-column-chart key="{{ $countsAndChart->reactiveKey() }}"
                                    :column-chart-model="$countsAndChart" />
                                <livewire:livewire-column-chart key="{{ $topTags->reactiveKey() }}"
                                    :column-chart-model="$topTags" />

                            </div>


                        </div>





                    </div>
                </div>

                {{-- APPLICATION HISTORY CONTAINER --}}
                <div class="col-span-4 lg:col-span-6" x-data="{
                    openTab: 1,
                    activeTab: 'text-blue-600 bg-gray-100  rounded-t-lg active',
                    inactiveTab: ' rounded-t-lg hover:text-gray-600 hover:bg-gray-50',
                }">
                    <div class="p-6 mt-4 bg-white rounded-lg shadow">

                        <ul
                            class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                            <li class="me-2">
                                <button @click="openTab = 1" :class="openTab === 1 ? activeTab : inactiveTab"
                                    aria-current="page" class="inline-block p-4">Job Posting</button>
                            </li>
                        </ul>
                        <div class="flex flex-col" x-show="openTab === 1"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100" x-cloak>
                            <div class="relative p-1 mt-4">
                                <div
                                    class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">
                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                            </svg>
                                        </div>

                                        {{-- SEARCH --}}
                                        <input wire:model.live='searchJobs' type="search" id="table-search-users"
                                            class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Search for Jobs">
                                    </div>
                                </div>

                                {{-- JOBPOST TABLE --}}
                                <div class="overflow-x-auto ">
                                    <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Job Position
                                                </th>
                                                <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                                    Number of Applicants
                                                </th>
                                                <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                                    Status
                                                </th>
                                                <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                                    Application Deadline
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($joblist->isEmpty())
                                                <tr>
                                                    <td colspan="5">
                                                        <div
                                                            class="flex flex-col items-center justify-center mt-24 mb-24">
                                                            <div class="p-6 bg-gray-100 rounded-full">
                                                                <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-width="2"
                                                                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                                </svg>
                                                            </div>
                                                            <p class="mt-2 text-xl font-bold text-center text-black">No
                                                                Records Found!</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($joblist as $data)
                                                    <tr class="bg-white border-b hover:bg-gray-50">
                                                        <th scope="row"
                                                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                                            <div class="ps-3 text-wrap">
                                                                <div class="text-base font-semibold">
                                                                    {{ $data->job_Title }}</div>
                                                                <div class="flex flex-col lg:hidden">

                                                                    <span class="text-gray-500 ">Applicants:
                                                                        <span class="font-semibold text-black">
                                                                            {{ $data->applicants_count }}</span></span>

                                                                    <span class="text-gray-500">Deadline:
                                                                        <span class="font-semibold text-black">
                                                                            {{ $data->job_Duration->format('F m, Y') }}</span></span>

                                                                    <div>
                                                                        @if ($data->job_Status == 'PENDING')
                                                                            <span
                                                                                class="items-center px-2 py-1 text-sm font-medium text-yellow-800 bg-yellow-200 rounded-md inlineflex ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                                                                        @elseif ($data->job_Status == 'ACTIVE')
                                                                            <span
                                                                                class="inline-flex items-center px-2 py-1 text-sm font-medium text-green-800 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">ACTIVE</span>
                                                                        @elseif ($data->job_Status == 'CLOSED')
                                                                            <span
                                                                                class="inline-flex items-center px-2 py-1 text-sm font-medium rounded-md bg-cyan-200 text-cyan-800 ring-1 ring-inset ring-cyan-600/20">CLOSED</span>
                                                                        @elseif ($data->job_Status == 'COMPLETED')
                                                                            <span
                                                                                class="inline-flex items-center px-2 py-1 text-sm font-medium text-blue-800 bg-blue-200 rounded-md ring-1 ring-inset ring-blue-600/20">COMPLETED</span>
                                                                        @elseif ($data->job_Status == 'REJECTED' || $data->job_Status == 'CANCELLED')
                                                                            <span
                                                                                class="inline-flex items-center px-2 py-1 text-sm font-medium text-red-800 uppercase bg-red-200 rounded-md ring-1 ring-inset ring-red-600/20">{{ $data->job_Status }}</span>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="hidden px-6 py-4 lg:table-cell">
                                                            <div class="text-base font-semibold">
                                                                {{ $data->applicants_count }}</div>
                                                        </td>
                                                        <td class="hidden px-6 py-4 lg:table-cell">
                                                            <span
                                                                class="inline-flex items-center rounded-md 
                                                                @if ($data->job_Status == 'PENDING') bg-yellow-200 text-yellow-800 ring-yellow-600/20
                                                                @elseif ($data->job_Status == 'ACTIVE') bg-green-200 text-green-800 ring-green-600/20
                                                                @elseif ($data->job_Status == 'CLOSED') bg-cyan-200 text-cyan-800 ring-cyan-600/20
                                                                @elseif ($data->job_Status == 'COMPLETED') bg-blue-200 text-blue-800 ring-blue-600/20
                                                                @else bg-red-200 text-red-800 ring-red-600/20 @endif 
                                                                px-2 py-1 text-sm font-medium ring-1 ring-inset">{{ $data->job_Status }}</span>
                                                        </td>
                                                        <td class="hidden px-6 py-4 lg:table-cell">
                                                            <div class="text-base">
                                                                {{ $data->job_Duration->format('F m, Y') }}</div>
                                                        </td>
                                                        <td class="px-6 py-4 text-center">
                                                            <div class="flex flex-row gap-5">
                                                                <div x-data="{ tooltip: 'Job Posting Overview' }">
                                                                    <a wire:navigate
                                                                        href="{{ route('admin.jobpost', ['id' => $data->job_id]) }}"
                                                                        x-tooltip="tooltip" type="button"
                                                                        class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                                        <svg class="w-5 h-5"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" fill="currentColor">
                                                                            <path
                                                                                d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                                            <path fill-rule="evenodd"
                                                                                d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                                                clip-rule="evenodd" />
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

                            <div class="mt-4">
                                {{ $joblist->links('vendor.livewire.tailwind') }}
                            </div>
                        </div>

                    </div>
                </div>



            </div>

            {{-- 2ND TAB --}}
            <div x-show="selectedTab === 2" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-cloak>

                <div class="p-6 mt-4 bg-white rounded-lg shadow">

                    <h1 class="text-2xl font-bold ">Details</h1>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="bname" :value="__('Business Name')" />
                            <x-text-input wire:model="businessName" class="block w-full mt-1" type="text" />
                            <x-input-error :messages="$errors->get('businessName')" class="mt-2" />

                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="tname" :value="__('Trade Name')" />
                            <x-text-input wire:model="tradeName" class="block w-full mt-1" type="text" />
                            <x-input-error :messages="$errors->get('tradeName')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="tin" :value="__('TIN')" />
                            <x-text-input wire:model="TIN" class="block w-full mt-1" type="text" />
                            <x-input-error :messages="$errors->get('TIN')" class="mt-2" />
                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="loctype" :value="__('Location Type')" />
                            <select wire:model="locType" class="block w-full mt-1 rounded-md">
                                <option value="" disabled selected>Select Location Type</option>
                                <option value="1">Main</option>
                                <option value="2">Branch</option>
                            </select>
                            <x-input-error :messages="$errors->get('locType')" class="mt-2" />
                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="workforce" :value="__('Total Work Force')" />
                            <select wire:model="workforce" class="block w-full mt-1 rounded-md">
                                <option value="" disabled selected>Select Total Work Force</option>
                                <option value="1">1 - 9 (Micro)</option>
                                <option value="2">10 - 99 (Small)</option>
                                <option value="3">100 - 199 (Medium)</option>
                                <option value="4">200 and Over (Large)</option>

                            </select>
                            <x-input-error :messages="$errors->get('workforce')" class="mt-2" />

                        </div>
                    </div>


                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <!-- Employment Status Dropdown -->
                        <div class="flex flex-col w-full">
                            <x-input-label for="empType" :value="__('Employer Type')" />
                            <select wire:model.live="empType" class="block w-full mt-1 rounded">
                                <option value="" disabled>Select Employer Status</option>
                                <option value="1">Public</option>
                                <option value="2">Private</option>
                            </select>
                            <x-input-error :messages="$errors->get('empType')" class="mt-2" />
                        </div>

                        <!-- Employment Description Dropdown -->
                        <div class="flex flex-col w-full">
                            <x-input-label for="empDesc" :value="__('Description')" />
                            <select wire:model="empDesc" class="block w-full mt-1 rounded">
                                <option value="" disabled>Select Description</option>

                                <!-- Dynamically populate the options based on empStatus -->
                                @foreach ($empDescriptions as $desc)
                                    <option value="{{ $desc['value'] }}">{{ $desc['text'] }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('empDesc')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex justify-end w-full mt-4">
                        <x-blue-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-modal')">Save Profile</x-blue-button>
                    </div>
                </div>

                <div class="p-6 mt-4 bg-white rounded-lg shadow">
                    <h1 class="text-2xl font-bold ">Reset Password</h1>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                    <div class="p-6 mt-4 mb-5 bg-yellow-100 rounded-lg shadow">
                        <p class="font-semibold text-yellow-700">Admin side password reset</p>
                        <p class="font-normal text-yellow-700">New password will be sent thru the user's email</p>
                    </div>

                    <x-blue-button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'reset-password-modal')">Reset
                        Password</x-blue-button>
                </div>

            </div>

            {{-- 3RD TAB --}}
            <div x-show="selectedTab === 3" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-cloak>


                <div class="w-full h-full p-6 mt-4 overflow-auto bg-white rounded-lg shadow">
                    <div class="mb-5">
                        <h1 class="text-2xl font-bold">Audit Logs</h1>
                        <hr class="h-px my-2 bg-gray-200 border-0">
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full mt-2 text-sm text-left text-gray-500 rtl:text-right">
                            <thead class="text-xs text-gray-700 uppercase bg-blue-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 ">
                                        <span class="font-bold text-black text-md">Model</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="font-bold text-black text-md">User</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="font-bold text-black text-md">Date</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($formattedAudits->isEmpty())
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
                                                    No audit logs available!
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($formattedAudits as $audit)
                                        <tr wire:key='audit-{{ $loop->index }}'
                                            class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <ul class="pl-5 list-disc">
                                                    @foreach ($audit['changes'] as $index => $change)
                                                        @if ($index == 0)
                                                            <b>{{ $change }}</b>
                                                        @else
                                                            <li>{{ $change }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $audit['changed_by'] }} (ID: {{ $audit['user_id'] }}, Type:
                                                {{ $audit['user_type'] }})<br>
                                                {{ $audit['ipaddress'] }}
                                            </td>
                                            <td class="px-6 py-4">

                                                {{ $audit['date'] }}
                                            </td>
                                        </tr>
                                    @endforeach

                                @endif
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $audits->links('vendor.livewire.tailwind') }}
                        </div>

                    </div>
                </div>


            </div>







        </div>
    </div>

    <x-modal name="partnership-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6" x-data="{ cancelPartnership: @entangle('cancelPartnership') }">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to cancel the partnership with this company?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">

                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="remarks" :value="__('Remarks')" />
                    <textarea wire:model='partRemarks' rows="6"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                        placeholder="Write your thoughts here..."></textarea>
                    <x-input-error :messages="$errors->get('partRemarks')" class="mt-2" />
                </div>

            </div>
            <p class="mt-2 text-sm text-justify text-gray-600 lg:text-md">
                {{ __('Please note that cancel partnership with this company will cancel all active and pending transactions associated with it. Make sure to review any ongoing processes before proceeding.') }}
            </p>
            <div class="inline-flex items-center justify-center w-full mt-2">
                <label class="relative flex items-center p-3 rounded-full cursor-pointer" for="cancelPartnership">
                    <input wire:model="cancelPartnership" type="checkbox" id="cancelPartnership"
                        class="w-5 h-5 transition-all border rounded-md appearance-none cursor-pointer border-blue-gray-200 checked:border-blue-900 checked:bg-blue-600" />
                    <span
                        class="absolute text-white transform opacity-0 top-2/4 left-2/4 -translate-x-2/4 -translate-y-2/4 peer-checked:opacity-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                            fill="currentColor" stroke="currentColor" stroke-width="1">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                </label>
                <label class="mt-px font-light text-gray-700 cursor-pointer select-none" for="cancelPartnership">
                    Confirm the transaction
                </label>
            </div>
            <div class="flex justify-between mt-6">
                <x-secondary-button wire:click.prevent="closeModal('partnership')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button x-show="cancelPartnership" wire:loading.attr="disabled"
                    wire:click.prevent="updatePartnership()" class="ms-3" type="button">
                    {{ __('Remove Partnership') }}
                    <div wire:loading.delay.long wire:target="updatePartnership()" role="status">
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

    <x-modal name="reactivate-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6 border-b">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to reactivate this account?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">

                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="remarks" :value="__('Remarks')" />
                    <textarea wire:model='reactRemarks' rows="6"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                        placeholder="Write your thoughts here..."></textarea>
                    <x-input-error :messages="$errors->get('reactRemarks')" class="mt-2" />
                </div>

            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button wire:click.prevent="closeModal('reactivate')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-green-button wire:loading.attr="disabled" wire:click.prevent="statusUser(1)" class="ms-3"
                    type="button">
                    {{ __('Activate') }}
                    <div wire:loading.delay.long wire:target="statusUser(1)" role="status">
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

    <x-modal name="deactivate-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6" x-data="{ deactivateBox: @entangle('deactivateBox') }">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to deactivate this account?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">

                <!-- Informational Message -->

                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="remarks" :value="__('Remarks')" />
                    <textarea wire:model='deactRemarks' rows="6"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                        placeholder="Write your thoughts here..."></textarea>
                    <x-input-error :messages="$errors->get('deactRemarks')" class="mt-2" />
                </div>

                <p class="mt-2 text-sm text-gray-600 lg:text-md">
                    {{ __('Please note that deactivating this account will cancel all active and pending transactions associated with it. Make sure to review any ongoing processes before proceeding.') }}
                </p>

                <div class="inline-flex items-center justify-center w-full mt-2">
                    <label class="relative flex items-center p-3 rounded-full cursor-pointer" for="deactivateBox">
                        <input wire:model="deactivateBox" type="checkbox" id="deactivateBox"
                            class="w-5 h-5 transition-all border rounded-md appearance-none cursor-pointer border-blue-gray-200 checked:border-blue-900 checked:bg-blue-600" />
                        <span
                            class="absolute text-white transform opacity-0 top-2/4 left-2/4 -translate-x-2/4 -translate-y-2/4 peer-checked:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                fill="currentColor" stroke="currentColor" stroke-width="1">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </label>
                    <label class="mt-px font-light text-gray-700 cursor-pointer select-none" for="deactivateBox">
                        Confirm the transaction
                    </label>
                </div>

            </div>
            <div class="flex justify-between mt-6">
                <x-secondary-button wire:click.prevent="closeModal('deactivate')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button x-show="deactivateBox" wire:loading.attr="disabled"
                    wire:click.prevent="statusUser(2)" class="ms-3" type="button">
                    {{ __('Deactivate') }}
                    <div wire:loading.delay.long wire:target="statusUser(2)" role="status">
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



    <x-modal name="confirm-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col my-4">
                <div class="flex flex-col items-center justify-center w-full px-4 mt-4 mb-4">
                    <span class="text-xl font-semibold">Are you sure you want to update this company's
                        profile?</span>

                </div>
            </div>
            <div class="flex justify-between mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled" wire:target='saveDetails'
                    wire:click.prevent="saveDetails" class="ms-3" type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="saveDetails" role="status">
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

    <x-modal name="reset-password-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6" x-data="{ agreeBox: @entangle('agreeBox') }">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col my-4">
                <div class="flex flex-col items-center justify-center w-full px-4 mt-4 mb-4">
                    <span class="text-xl font-semibold">Are you sure you want to reset this user's password?</span>

                </div>


                <div class="inline-flex items-center justify-center w-full mt-4">
                    <label class="relative flex items-center p-3 rounded-full cursor-pointer" for="agreeBox">
                        <input wire:model="agreeBox" type="checkbox" id="agreeBox"
                            class="w-5 h-5 transition-all border rounded-md appearance-none cursor-pointer border-blue-gray-200 checked:border-blue-900 checked:bg-blue-600" />
                        <span
                            class="absolute text-white transform opacity-0 top-2/4 left-2/4 -translate-x-2/4 -translate-y-2/4 peer-checked:opacity-100">
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
            <div class="flex justify-between mt-6">
                <x-secondary-button x-on:click="agreeBox = false; $dispatch('close-modal', 'reset-password-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>



                <x-danger-button x-show="agreeBox" wire:loading.attr="disabled" wire:target='resetPassword'
                    wire:click.prevent="resetPassword" class="ms-3" type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="resetPassword" role="status">
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
