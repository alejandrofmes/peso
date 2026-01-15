<div wire:poll class="container mx-auto py-8">
    <div class="grid grid-cols-4 lg:grid-cols-12 gap-4 p-3 lg:p-0">

        {{-- TITLE --}}
        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Jobseeker Management \ Jobseeker Overview</h1>
        </div>

        <div class="col-span-4 lg:col-span-12 mt-5">

            <div class="flex flex-row">

                <div class="flex flex-col">
                    <h1 class="text-xl font-medium">Jobseeker ID: {{ $jobseeker->employee_id }}</h1>
                    <h1 class="text-md font-light text-gray-500">{{ $jobseeker->created_at->format('F j, Y, g:i A') }}
                    </h1>
                </div>

                {{-- DEACTIVATE BUTTON --}}
                @if (Auth::check() && Auth::user()->usertype == 10)

                    @if ($isResident == true)
                        <div class="flex flex-col ml-auto mr-0">
                            @if ($jobseeker->user->userstatus == 1)
                                <button type="button" x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'deactivate-modal')"
                                    class="bg-red-500 text-white font-semibold rounded-lg text-md px-4 py-2 transition duration-300 ease-in-out transform hover:bg-red-600 hover:scale-105 focus:ring-4 focus:ring-red-300 focus:outline-none">
                                    Deactivate Account
                                </button>
                            @elseif($jobseeker->user->userstatus == 2)
                                <button type="button" x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'reactivate-modal')"
                                    class="bg-green-500 text-white font-semibold rounded-lg text-md px-4 py-2 transition duration-300 ease-in-out transform hover:bg-green-600 hover:scale-105 focus:ring-4 focus:ring-green-300 focus:outline-none">
                                    Reactivate Account
                                </button>
                            @endif
                        </div>
                    @endif
                @endif

            </div>

        </div>

        {{-- PROFILE CONTAINER --}}
        <div class="col-span-4 lg:col-span-4">
            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex flex-col items-center">
                    {{-- IMAGE --}}
                    <img src="{{ asset('storage/' . $jobseeker->pimg) }}"
                        class="select-none w-32 h-32 bg-gray-300 rounded-md mb-4 shrink-0 grow-0 object-cover">

                    </img>

                    <h1 class="text-xl font-bold uppercase text-center"> {{ $jobseeker->fname }}
                        {{ $jobseeker->mname ?? '' }}
                        {{ $jobseeker->lname }}@if (!empty($jobseeker->suffix))
                            , {{ $jobseeker->suffix }}
                        @endif
                    </h1>
                    <p class="text-gray-700">#{{ $jobseeker->user_id }}</p>
                </div>

                <hr class="my-6 border-t border-gray-300">

                <div class="flex flex-col">

                    <span class="text-gray-700 uppercase font-bold tracking-wider mb-2">Details</span>

                    <ul>
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold text-left">Email:</li>
                            <p class="ms-4 break-all">{{ $jobseeker->user->email }}</p>
                        </div>

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold text-left">Status:</li>
                            <p class="ms-4 text-left break-all">
                                {{ $jobseeker->empstatus == 1 ? 'Employed' : 'Unemployed' }}
                            </p>
                        </div>

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Contact:</li>
                            <p class="ms-4 break-all">{{ $jobseeker->pnumber }}</p>
                        </div>

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Education:</li>
                            <p class="ms-4 break-all">{{ $attainment }}</p>
                        </div>
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Birthday:</li>
                            <p class="ms-4 break-all">{{ $jobseeker->birthdate->format('F j, Y') }}</p>
                        </div>
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">OFW:</li>
                            <p class="ms-4 break-all"> {{ $jobseeker->ofw == 1 ? 'Yes' : 'No' }}</p>
                        </div>
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">4Ps Member:</li>
                            <p class="ms-4 break-all"> {{ $jobseeker->fourp == 1 ? 'Yes' : 'No' }}</p>
                        </div>
                        @if ($jobseeker->fourp == 1 && $jobseeker->fourpID)
                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">4Ps Member ID:</li>
                                <p class="ms-4 break-all"> {{ $jobseeker->fourpID }}</p>
                            </div>
                        @endif
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Work Experience:</li>
                            <p class="ms-4 break-all">{{ $totalExperience }} Months</p>
                        </div>

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Address:</li>
                            <p class="ms-4 uppercase text-left break-all"> {{ $jobseeker->address }},
                                {{ $jobseeker->barangay->barangay_Name }},
                                {{ $jobseeker->barangay->municipality->municipality_Name }},
                                {{ $jobseeker->barangay->municipality->province->province_Name }}</p>
                        </div>

                    </ul>


                    {{-- BUTTON --}}
                    <div class="mt-6 flex flex-wrap gap-4 justify-center">
                        {{-- <a href="#" class="bg-blue-700 hover:bg-blue-800 text-white py-2 px-4 rounded">View
                        </a> --}}
                        @if ($jobseeker->resume)
                            <button wire:click.prevent="viewFile({{ $jobseeker->employee_id }}, 1)"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded">View
                                Resume</button>
                        @else
                            <button wire:click.prevent="viewFile({{ $jobseeker->employee_id }}, 2)"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded">View
                                Resume</button>
                        @endif

                    </div>

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
            <ul class="flex flex-row space-x space-x-4 text-sm font-medium text-gray-500 md:me-4 mb-4 md:mb-0">
                <li>
                    <button @click="selectedTab = 1" :class="selectedTab === 1 ? activeTab : inactiveTab"
                        class="inline-flex items-center px-4 py-3 rounded-lg w-full" aria-current="page">
                        <svg :class="selectedTab === 1 ? activeIcon : inactiveIcon" class="w-4 h-4 me-2"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                        </svg>
                        Overview
                    </button>
                </li>
                @if ($isResident == true)
                    <li>
                        <button @click="selectedTab = 2" :class="selectedTab === 2 ? activeTab : inactiveTab"
                            class="inline-flex items-center px-4 py-3 rounded-lg w-full">
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
                            class="inline-flex items-center px-4 py-3 rounded-lg w-full" aria-current="page">

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
                @endif
            </ul>

            {{-- 2ND TAB --}}
            <div x-show="selectedTab === 1" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-cloak>


                <div class="bg-white shadow rounded-lg p-6 mt-4">
                    <h1 class="text-2xl font-bold ">Overview</h1>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                    <div class="flex flex-col lg:flex-row gap-4">
                        <div class="flex flex-col w-full gap-4">
                            @if ($jobseeker->industry_preference->count() >= 1)

                                <div class="flex flex-col w-full">
                                    <span class="mb-1 font-bold">Industry Preference:</span>
                                    {{-- BADGE CONTAINER --}}
                                    <div id= "industryRow" class="flex-inline p-1">
                                        {{-- BADGE --}}

                                        @foreach ($jobseeker->industry_preference as $industryPref)
                                            <span wire:key='skills-{{ $industryPref->industry_preference_id }}'
                                                class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-2 ps-3 pe-3 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $industryPref->job_industry->industry_Title }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($jobseeker->job_preference->count() >= 1)

                                <div class="flex flex-col w-full">
                                    <span class="mb-1 font-bold">Job Preference:</span>
                                    {{-- BADGE CONTAINER --}}
                                    <div id= "jobPrefRow" class="flex-inline p-1">
                                        {{-- BADGE --}}

                                        @foreach ($jobseeker->job_preference as $jobPref)
                                            <span wire:key='skills-{{ $jobPref->job_preference_id }}'
                                                class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-2 ps-3 pe-3 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $jobPref->job_positions->position_Title }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($jobseeker->skills->count() >= 1)

                                <div class="flex flex-col w-full">
                                    <span class="mb-1 font-bold">Skills:</span>
                                    {{-- BADGE CONTAINER --}}
                                    <div id= "skillsRow" class="flex-inline p-1">
                                        {{-- BADGE --}}

                                        @foreach ($jobseeker->skills as $empSkills)
                                            <span wire:key='skills-{{ $empSkills->skills_id }}'
                                                class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-2 ps-3 pe-3 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $empSkills->skill_Type }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="flex flex-col w-full gap-4">
                            @if ($jobseeker->disability->count() >= 1)

                                <div class="flex flex-col md:w-1/2">

                                    <span class="mb-1 font-bold">Disability:</span>

                                    <div id= "disabilityRow" class="flex-inline p-1">
                                        {{-- BADGE --}}

                                        @foreach ($jobseeker->disability as $empDisability)
                                            <span wire:key='disability-{{ $empDisability->disability_id }}'
                                                class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-2 ps-3 pe-3 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $empDisability->disability_Type }}
                                            </span>
                                        @endforeach
                                    </div>



                                </div>
                            @endif

                            @if ($jobseeker->language->count() >= 1)
                                <div class="flex flex-col md:flex-row w-full gap-4 md:gap-10">
                                    <div class="flex flex-col w-full">
                                        <span class="mb-1 font-bold">Language:</span>

                                        <div class="flex flex-col gap-2 mt-2 ml-2">
                                            @foreach ($jobseeker->language as $empLanguage)
                                                <div x-data="{
                                                    skills: [],
                                                    percentage: 0,
                                                    init() {
                                                        this.skills = [];
                                                        this.percentage = 0;
                                                
                                                        if ({{ $empLanguage->language_Read }} == 1) {
                                                            this.skills.push('Read');
                                                            this.percentage += 25;
                                                        }
                                                        if ({{ $empLanguage->language_Write }} == 1) {
                                                            this.skills.push('Write');
                                                            this.percentage += 25;
                                                        }
                                                        if ({{ $empLanguage->language_Speak }} == 1) {
                                                            this.skills.push('Speak');
                                                            this.percentage += 25;
                                                        }
                                                        if ({{ $empLanguage->language_Understand }} == 1) {
                                                            this.skills.push('Understand');
                                                            this.percentage += 25;
                                                        }
                                                
                                                    }
                                                }" x-init="init">
                                                    <span class="text-base font-medium text-blue-700">
                                                        {{ $empLanguage->language_Type }}
                                                    </span>

                                                    <div class="w-full bg-gray-200 rounded-full">
                                                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                                            :style="{ width: percentage + '%' }">
                                                            <span x-text="skills.join(' / ')"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>


                </div>

                {{-- APPLICATION HISTORY CONTAINER --}}
                <div class="col-span-4 lg:col-span-6" x-data="{
                    openTab: 1,
                    activeTab: 'text-blue-600 bg-gray-100  rounded-t-lg active',
                    inactiveTab: ' rounded-t-lg hover:text-gray-600 hover:bg-gray-50',
                }">
                    <div class="bg-white shadow rounded-lg p-6 mt-4">

                        <ul
                            class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                            <li class="me-2">
                                <button @click="openTab = 1" :class="openTab === 1 ? activeTab : inactiveTab"
                                    aria-current="page" class="inline-block p-4">Application History</button>
                            </li>
                            <li class="me-2">
                                <button @click="openTab = 2" :class="openTab === 2 ? activeTab : inactiveTab"
                                    aria-current="page" class="inline-block p-4">Events History</button>
                            </li>
                            <li class="me-2">
                                <button @click="openTab = 3" :class="openTab === 3 ? activeTab : inactiveTab"
                                    class="inline-block p-4">Recommended Jobs</button>
                            </li>
                            <li class="me-2">
                                <button @click="openTab = 4" :class="openTab === 4 ? activeTab : inactiveTab"
                                    class="inline-block p-4">Licenses</button>
                            </li>
                            <li class="me-2">
                                <button @click="openTab = 5" :class="openTab === 5 ? activeTab : inactiveTab"
                                    class="inline-block p-4">Eligibilities</button>
                            </li>
                        </ul>
                        <div class="flex flex-col" x-show="openTab === 1"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100" x-cloak>
                            <div class="relative p-1 mt-4">
                                <div
                                    class="flex flex-col lg:flex-row p-1 lg:justify-between gap-2 space-y-4 lg:space-y-0 pb-4">

                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                            </svg>
                                        </div>

                                        {{-- SEARCH --}}
                                        <input wire:model.live='searchApplications' type="search"
                                            id="table-search-users"
                                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Search for Applications">
                                    </div>
                                </div>

                                {{-- HISTORY TABLE --}}
                                <div class="overflow-x-auto ">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                            <tr>
                                                <th scope="col" class="px-4 py-2 lg:px-6 lg:py-3">Job Position</th>
                                                <th scope="col" class="px-4 py-2 lg:px-6 lg:py-3">Company</th>
                                                <th scope="col"
                                                    class="px-4 py-2 lg:px-6 lg:py-3 hidden lg:table-cell">Application
                                                    Status</th>
                                                <th scope="col"
                                                    class="px-4 py-2 lg:px-6 lg:py-3 hidden lg:table-cell">PESO
                                                    Recommendation</th>
                                                <th scope="col"
                                                    class="px-4 py-2 lg:px-6 lg:py-3 hidden lg:table-cell">Applied Date
                                                </th>
                                                <th scope="col" class="px-4 py-2 lg:px-6 lg:py-3">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($application_history->isEmpty())
                                                <tr>
                                                    <td colspan="6">
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
                                                            <p class="text-xl font-bold text-black text-center mt-2">No
                                                                Records Found!</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($application_history as $data)
                                                    <tr class="bg-white border-b hover:bg-gray-50">
                                                        <th scope="row"
                                                            class="flex items-center px-4 py-2 lg:px-6 lg:py-4 text-gray-900 whitespace-nowrap">
                                                            <div class="ps-3 text-wrap">
                                                                <div class="text-base font-semibold">
                                                                    {{ $data->job_posting->job_Title }}</div>
                                                                <div class="lg:hidden text-sm text-gray-500">Status:
                                                                    {{ $data->applicant_Status }}</div>
                                                                <!-- Mobile info -->
                                                            </div>
                                                        </th>
                                                        <td class="px-4 py-2 lg:px-6 lg:py-4">
                                                            <div class="text-base font-semibold">
                                                                {{ $data->job_posting->company->business_Name }}</div>
                                                            <div class="lg:hidden text-sm text-gray-500">Applied:
                                                                {{ $data->created_at->format('F m, Y') }}</div>
                                                            <!-- Mobile info -->
                                                        </td>
                                                        <td class="px-4 py-2 lg:px-6 lg:py-4 hidden lg:table-cell">
                                                            @if ($data->applicant_Status == 'PENDING')
                                                                <span
                                                                    class="inlineflex items-center rounded-md bg-yellow-200 px-2 py-1 text-sm font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                                                            @elseif ($data->applicant_Status == 'INTERESTED')
                                                                <span
                                                                    class="inline-flex items-center rounded-md bg-purple-200 px-2 py-1 text-sm font-medium text-purple-800 ring-1 ring-inset ring-purple-600/20">INTERESTED</span>
                                                            @elseif ($data->applicant_Status == 'INTERVIEW')
                                                                <span
                                                                    class="inline-flex items-center rounded-md bg-blue-200 px-2 py-1 text-sm font-medium text-blue-800 ring-1 ring-inset ring-blue-600/20">INTERVIEW</span>
                                                            @elseif ($data->applicant_Status == 'HIRED')
                                                                <span
                                                                    class="inline-flex items-center rounded-md bg-green-200 px-2 py-1 text-sm font-medium text-green-800 ring-1 ring-inset ring-green-600/20">HIRED</span>
                                                            @elseif ($data->applicant_Status == 'ACCEPTED')
                                                                <span
                                                                    class="inline-flex items-center rounded-md bg-emerald-200 px-2 py-1 text-sm font-medium text-emerald-800 ring-1 ring-inset ring-emerald-600/20">ACCEPTED</span>
                                                            @elseif ($data->applicant_Status == 'REJECTED' || $data->applicant_Status == 'CANCELLED')
                                                                <span
                                                                    class="inline-flex items-center rounded-md bg-red-200 px-2 py-1 text-sm font-medium text-red-800 ring-1 ring-inset ring-red-600/20 uppercase">{{ $data->applicant_Status }}</span>
                                                            @endif

                                                        </td>
                                                        <td class="px-4 py-2 lg:px-6 lg:py-4 hidden lg:table-cell">
                                                            @if ($data->peso_Status == 'PENDING')
                                                                <span
                                                                    class="inline-flex items-center rounded-md bg-yellow-200 px-2 py-1 text-sm font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                                                            @elseif ($data->peso_Status == 'RECOMMENDED')
                                                                <span
                                                                    class="inline-flex items-center rounded-md bg-green-200 px-2 py-1 text-sm font-medium text-green-800 ring-1 ring-inset ring-green-600/20">RECOMMENDED</span>
                                                            @elseif ($data->peso_Status == 'REJECT')
                                                                <span
                                                                    class="inline-flex items-center rounded-md bg-red-200 px-2 py-1 text-sm font-medium text-red-800 ring-1 ring-inset ring-red-600/20">NOT
                                                                    RECOMMENDED</span>
                                                            @elseif ($data->peso_Status == 'CANCELLED')
                                                                <span
                                                                    class="inline-flex items-center rounded-md bg-red-200 px-2 py-1 text-sm font-medium text-red-800 ring-1 ring-inset ring-red-600/20">CANCELLED</span>
                                                            @endif

                                                        </td>
                                                        <td class="px-4 py-2 lg:px-6 lg:py-4 hidden lg:table-cell">
                                                            <div class="text-base">
                                                                {{ $data->created_at->format('F m, Y') }}</div>
                                                        </td>
                                                        <td class="px-4 py-2 lg:px-6 lg:py-4 text-center">
                                                            <div class="flex flex-row gap-5">
                                                                @if ($data->job_posting->peso_id == Auth::user()->peso_accounts->peso_id)
                                                                    <div x-data="{ tooltip: 'Application Overview' }">
                                                                        <a wire:navigate
                                                                            href="{{ route('admin.jobpost.applicants.overview', ['id' => $data->applicant_id]) }}"
                                                                            x-tooltip="tooltip" type="button"
                                                                            class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                                                            <svg class="h-5 w-5"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 24 24"
                                                                                fill="currentColor">
                                                                                <path
                                                                                    d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                                                <path fill-rule="evenodd"
                                                                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                                                    clip-rule="evenodd" />
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

                            <div class="mt-4">
                                {{ $application_history->links('vendor.livewire.tailwind') }}
                            </div>
                        </div>

                        <div class="flex flex-col" x-show="openTab === 2"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100" x-cloak>
                            <div class="relative overflow-x-auto p-1 mt-4">
                                <div
                                    class="flex flex-col lg:flex-row p-1 lg:justify-between gap-2 space-y-4 lg:space-y-0 pb-4">
                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                            </svg>
                                        </div>

                                        {{-- SEARCH --}}
                                        <input wire:model.live='searchEvents' type="search" id="table-search-users"
                                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Search for Events">
                                    </div>
                                </div>

                                {{-- HISTORY TABLE --}}
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Training Name
                                            </th>
                                            <th scope="col" class="hidden lg:table-cell px-6 py-3">
                                                Registered Date
                                            </th>
                                            <th scope="col" class="hidden lg:table-cell px-6 py-3">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($programHistory->isEmpty())
                                            <tr>
                                                <td colspan="4">
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
                                                        <p class="text-xl font-bold text-black text-center mt-2">
                                                            No Records Found!
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($programHistory as $data)
                                                <tr class="bg-white border-b hover:bg-gray-50">
                                                    <th scope="row"
                                                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                                        <div class="ps-3 text-wrap">
                                                            <div class="text-base font-semibold">
                                                                {{ $data->programs->program_Title }}
                                                            </div>
                                                            <div class="block lg:hidden text-gray-500 text-sm">
                                                                {{ $data->created_at->format('F m, Y') }} -

                                                                @if ($data->program_reg_Status == 'REGISTERED')
                                                                    <span class="text-yellow-800">REGISTERED</span>
                                                                @elseif ($data->program_reg_Status == 'COMPLETED')
                                                                    <span class="text-green-800">REGISTERED</span>
                                                                @elseif ($data->program_reg_Status == 'ATTENDEE')
                                                                    @if ($data->programs->program_Status == 'COMPLETED')
                                                                        <span class="text-yellow-800">ATTENDEE</span>
                                                                    @else
                                                                        <span class="text-green-800">ATTENDEE</span>
                                                                    @endif
                                                                @else
                                                                    <span
                                                                        class="text-red-800">{{ $data->program_reg_Status }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <td class="hidden lg:table-cell px-6 py-4">
                                                        <div class="text-base font-semibold">
                                                            {{ $data->created_at->format('F m, Y') }}</div>
                                                    </td>

                                                    <td class="hidden lg:table-cell px-6 py-4">
                                                        @if ($data->program_reg_Status == 'REGISTERED')
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-200 rounded-md ring-1 ring-inset ring-yellow-600/20">REGISTERED</span>
                                                        @elseif ($data->program_reg_Status == 'COMPLETED')
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">COMPLETED</span>
                                                        @elseif ($data->program_reg_Status == 'ATTENDEE')
                                                            @if ($data->programs->program_Status == 'COMPLETED')
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
                                                    </td>
                                                    <td class="px-6 py-4 text-center">
                                                        @if ($data->programs->peso_id == Auth::user()->peso_accounts->peso_id)
                                                            <div class="flex flex-row gap-5">
                                                                <div x-data="{ tooltip: 'Application Overview' }">
                                                                    <a wire:navigate
                                                                        href="{{ route('admin-registrants-training', ['id' => $data->program_id]) }}"
                                                                        x-tooltip="tooltip" type="button"
                                                                        class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                                                        <svg class="h-5 w-5"
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
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                            </div>
                            <div class="mt-4">
                                {{ $programHistory->links('vendor.livewire.tailwind') }}
                            </div>
                        </div>

                        <div class="flex flex-col" x-show="openTab === 3"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100" x-cloak>
                            <div class="relative p-1 mt-4">
                                <div
                                    class="flex flex-col lg:flex-row p-1 lg:justify-between gap-2 space-y-4 lg:space-y-0 pb-4">

                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
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
                                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Search for Jobs">
                                    </div>
                                </div>

                                {{-- Recommendation TABLE --}}
                                <div class="overflow-x-auto ">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">Job Position</th>
                                                <th scope="col" class="hidden lg:table-cell px-6 py-3">Company</th>
                                                <th scope="col" class="hidden md:table-cell px-6 py-3">Slots
                                                    Available</th>
                                                <th scope="col" class="hidden md:table-cell px-6 py-3">Application
                                                    Deadline</th>
                                                <th scope="col" class="px-6 py-3">Action</th>
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
                                                            <p class="text-xl font-bold text-black text-center mt-2">No
                                                                Matched Jobs!</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($joblist as $data)
                                                    <tr wire:key='jobPosting-{{ $data->job_id }}'
                                                        class="bg-white border-b hover:bg-gray-50">
                                                        <th scope="row"
                                                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                                            <div class="ps-3 text-wrap">
                                                                <div class="font-normal text-gray-500 lg:hidden">
                                                                    {{ $data->company->business_Name }}
                                                                </div>
                                                                <div class="text-base font-semibold">
                                                                    {{ $data->job_Title }}</div>

                                                                <div class="font-normal text-gray-500 lg:hidden">
                                                                    Slots: {{ $data->slotsLeft() }}
                                                                </div>
                                                                <div class="font-normal text-gray-500 lg:hidden">
                                                                    Deadline:
                                                                    {{ $data->job_Duration->format('F m, Y') }}
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="hidden lg:table-cell px-6 py-4">
                                                            <div class="text-base font-semibold">
                                                                {{ $data->company->business_Name }}</div>
                                                        </td>
                                                        <td class="hidden md:table-cell px-6 py-4">
                                                            <div class="text-base font-semibold">
                                                                {{ $data->slotsLeft() }}</div>
                                                        </td>
                                                        <td class="hidden md:table-cell px-6 py-4">
                                                            <div class="text-base">
                                                                {{ $data->job_Duration->format('F m, Y') }}</div>
                                                        </td>
                                                        <td class="px-6 py-4 text-center">
                                                            <div class="flex flex-row gap-5">
                                                                @if (Auth::user()->peso_accounts->peso_id == $data->peso_id)
                                                                    <div x-data="{ tooltip: 'View Job Posting' }">
                                                                        <a href="{{ route('admin.jobpost.applicants', ['id' => $data->job_id]) }}"
                                                                            x-tooltip="tooltip" type="button"
                                                                            class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                                                            <svg class="h-5 w-5"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 24 24"
                                                                                fill="currentColor">
                                                                                <path
                                                                                    d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                                                <path fill-rule="evenodd"
                                                                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                                                    clip-rule="evenodd" />
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

                            <div class="mt-4">
                                {{ $joblist->links('vendor.livewire.tailwind') }}
                            </div>
                        </div>
                        <div class="flex flex-col" x-show="openTab === 4"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100" x-cloak>
                            <div class="relative p-1 mt-4">
                                {{-- HISTORY TABLE --}}
                                <div class="overflow-x-auto ">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    License
                                                </th>
                                                <th scope="col" class="hidden lg:table-cell px-6 py-3">
                                                    Validity
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($jobseeker->license->isEmpty())
                                                <tr>
                                                    <td colspan="2">
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
                                                            <p class="text-xl font-bold text-black text-center mt-2">
                                                                No Records Found!
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($jobseeker->license as $data)
                                                    <tr class="bg-white border-b hover:bg-gray-50">
                                                        <th scope="row"
                                                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                                            <div class="ps-3 text-wrap">
                                                                <div class="text-base font-semibold">
                                                                    {{ $data->license_type->license_Name }}
                                                                </div>
                                                                <div class="lg:hidden text-sm text-gray-600">
                                                                    Valid until:
                                                                    {{ $data->license_Validity->format('F m, Y') }}
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="hidden lg:table-cell px-6 py-4">
                                                            <div class="text-base font-semibold">
                                                                {{ $data->license_Validity->format('F m, Y') }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>


                        </div>
                        <div class="flex flex-col" x-show="openTab === 5"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100" x-cloak>
                            <div class="relative p-1 mt-4">
                                {{-- HISTORY TABLE --}}
                                <div class="overflow-x-auto ">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Eligibility
                                                </th>
                                                <th scope="col" class="hidden lg:table-cell px-6 py-3">
                                                    Validity
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($jobseeker->eligibility->isEmpty())
                                                <tr>
                                                    <td colspan="2">
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
                                                            <p class="text-xl font-bold text-black text-center mt-2">
                                                                No Records Found!
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($jobseeker->eligibility as $data)
                                                    <tr class="bg-white border-b hover:bg-gray-50">
                                                        <th scope="row"
                                                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                                            <div class="ps-3 text-wrap">
                                                                <div class="text-base font-semibold">
                                                                    {{ $data->eligibility_type->eligibility_Name }}
                                                                </div>
                                                                <div class="lg:hidden text-sm text-gray-600">
                                                                    Valid until:
                                                                    {{ $data->eligibility_Date->format('F m, Y') }}
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="hidden lg:table-cell px-6 py-4">
                                                            <div class="text-base font-semibold">
                                                                {{ $data->eligibility_Date->format('F m, Y') }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>


                        </div>

                    </div>
                </div>



            </div>

            {{-- SECURITY --}}
            <div x-show="selectedTab === 2" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-cloak>

                <div class="bg-white shadow rounded-lg p-6 mt-4">

                    <h1 class="text-2xl font-bold ">Details</h1>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                    <div class="flex flex-col lg:flex-row gap-2 lg:gap-4 mt-4 w-full">
                        <div class="flex flex-col w-full">
                            <x-input-label for="fname" :value="__('First Name')" />
                            <x-text-input wire:model='fname' class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('fname')" class="mt-2" />

                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="lname" :value="__('Last Name')" />
                            <x-text-input wire:model='lname' class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('lname')" class="mt-2" />

                        </div>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-2 lg:gap-4 mt-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="mname" :value="__('Middle Name')" />
                            <x-text-input wire:model='mname' class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('mname')" class="mt-2" />

                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="suffix" :value="__('Suffix')" />
                            <select wire:model='suffix' name="suffixPost" class="block mt-1 w-full rounded-md">
                                <option value="" disabled selected>Select Suffix</option>
                                <option value="">None</option>
                                <option value="Jr">Jr. (Junior)</option>
                                <option value="Sr">Sr. (Senior)</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                                <option value="VI">VI</option>
                                <option value="VII">VII</option>
                                <option value="VIII">VIII</option>
                                <option value="IX">IX</option>
                                <option value="X">X</option>
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('suffix')" class="mt-2" />
                    </div>

                    <div class="flex flex-col lg:flex-row gap-2 lg:gap-4 mt-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="birthdate" :value="__('Birthdate')" />
                            <x-text-input wire:model='birthdate' class="block mt-1 w-full" type="date" />
                            <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />

                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="gender" :value="__('Gender')" />
                            <select wire:model='gender' class="block mt-1 w-full rounded-md">
                                <option value="" disabled selected>Select Gender</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />

                        </div>
                    </div>


                    <div class="flex flex-col lg:flex-row gap-2 lg:gap-4 mt-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="civilstatus" :value="__('Civil Status')" />
                            <select wire:model='civilstatus' class="block mt-1 w-full rounded-md">
                                <option value="" disabled selected>Select Civil Status</option>
                                <option value="1">Single</option>
                                <option value="2">Married</option>
                                <option value="3">Widowed</option>

                            </select>
                            <x-input-error :messages="$errors->get('civilstatus')" class="mt-2" />
                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="religion" :value="__('Religion')" />
                            <select wire:model='religion' class="block mt-1 w-full rounded-md">
                                <option value="" disabled selected>Select Religion</option>
                                <option value="2">ASSEMBLY OF GOD</option>
                                <option value="3">AGLIPAYAN</option>
                                <option value="4">BORN AGAIN CHRISTIAN</option>
                                <option value="5">BAPTIST</option>
                                <option value="6">BUDDIST</option>
                                <option value="7">CHURCH OF GOD THRU CHRIST JESUS</option>
                                <option value="8">CHRISTIAN</option>
                                <option value="9">CHURCH OF CHRIST</option>
                                <option value="10">CHURCH OF GOD</option>
                                <option value="25">CHURCH OF LATTER DAY SAINT</option>
                                <option value="11">EPISCOPALIAN ANGELICAN</option>
                                <option value="12">ESPIRITISM</option>
                                <option value="13">EVANGELICAL</option>
                                <option value="15">FAITH TABERNACLE</option>
                                <option value="14">FOUR SQUARE GOSPEL CHURCH</option>
                                <option value="31">FOURTH WATCH</option>
                                <option value="16">HINDU</option>
                                <option value="19">IGLESIA NG DIYOS KAY CRISTO JESUS</option>
                                <option value="18">IGLESIA NI CRISTO</option>
                                <option value="17">IGLESIA SA DIYOS ESPIRITU SANTO</option>
                                <option value="20">ISLAM</option>
                                <option value="22">JEHOVAH'S WITNESSES</option>
                                <option value="21">JESUS MIRACLE CRUSADE</option>
                                <option value="23">LUTHERAN</option>
                                <option value="24">METHODIST</option>
                                <option value="26">NON-SECTORAL CHARISMATIC</option>
                                <option value="27">ORTHODOX</option>
                                <option value="28">OTHERS</option>
                                <option value="29">PENTECOSTAL</option>
                                <option value="30">PHILIPPINE INDEPENDENT CHRISTIAN CHURCH(PICC/IFI)</option>
                                <option value="32">PRESBYTERIAN</option>
                                <option value="33">PROTESTANT</option>
                                <option value="35">RIZALIST</option>
                                <option value="34">ROMAN CATHOLIC</option>
                                <option value="36">SEVENTH DAY ADVENTIST</option>
                                <option value="1">TWELVE TRIBES OF ISRAEL</option>
                                <option value="38">UNION ESPIRITISTA CRISTIANA</option>
                                <option value="37">UNITED CHURCH CHRISTIAN OF THE PHILIPPINES (UCCP)</option>
                                <option value="39">WESLEYAN CHURCH</option>
                                <option value="40">WORD OF HOPE</option>
                                <option value="41">OTHER</option>
                            </select>
                            <x-input-error :messages="$errors->get('religion')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex w-full justify-end mt-4">
                        <x-blue-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-modal')">Save Profile</x-blue-button>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6 mt-4">
                    <h1 class="text-2xl font-bold ">Reset Password</h1>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                    <div class="bg-yellow-100 shadow rounded-lg p-6 mt-4 mb-5">
                        <p class="text-yellow-700 font-semibold">Admin side password reset</p>
                        <p class="text-yellow-700 font-normal">New password will be sent thru the user's email</p>
                    </div>

                    <x-blue-button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'reset-password-modal')">Reset
                        Password</x-blue-button>
                </div>

            </div>

            {{-- AUDITS --}}
            <div x-show="selectedTab === 3" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-cloak>


                <div class="bg-white shadow rounded-lg p-6 h-full w-full overflow-auto mt-4">
                    <div class="mb-5">
                        <h1 class="text-2xl font-bold">Audit Logs</h1>
                        <hr class="h-px my-2 bg-gray-200 border-0">
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 mt-2">
                            <thead class="text-xs text-gray-700 uppercase bg-blue-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 ">
                                        <span class="text-black font-bold text-md">Model</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="text-black font-bold text-md">User</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="text-black font-bold text-md">Date</span>
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
                                                <p class="text-xl font-bold text-black text-center mt-2">
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
                                                <ul class="list-disc pl-5">
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


    <x-modal name="confirm-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col my-4">
                <div class="flex flex-col mt-4 mb-4 w-full justify-center items-center px-4">
                    <span class="text-xl font-semibold">Are you sure you want to update this jobseeker's
                        profile?</span>

                </div>
            </div>
            <div class="mt-6 flex justify-between">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled" wire:target='saveDetails'
                    wire:click.prevent="saveDetails" class="ms-3" type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="saveDetails" role="status">
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



    <x-modal name="reactivate-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to reactivate this account?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">

                <div class="flex flex-col mt-2 w-full">
                    <x-input-label for="remarks" :value="__('Remarks')" />
                    <textarea wire:model='reactRemarks' rows="6"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                        placeholder="Write your thoughts here..."></textarea>
                    <x-input-error :messages="$errors->get('reactRemarks')" class="mt-2" />
                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click.prevent="closeModal('reactivate')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-green-button wire:loading.attr="disabled" wire:click.prevent="statusUser(1)" class="ms-3"
                    type="button">
                    {{ __('Activate') }}
                    <div wire:loading.delay.long wire:target="statusUser(1)" role="status">
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
                </x-green-button>
            </div>
        </div>
    </x-modal>

    <x-modal name="deactivate-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center" x-data="{ deactivateBox: @entangle('deactivateBox') }">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to deactivate this account?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">

                <!-- Informational Message -->

                <div class="flex flex-col mt-2 w-full">
                    <x-input-label for="remarks" :value="__('Remarks')" />
                    <textarea wire:model='deactRemarks' rows="6"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                        placeholder="Write your thoughts here..."></textarea>
                    <x-input-error :messages="$errors->get('deactRemarks')" class="mt-2" />
                </div>

                <p class="text-sm lg:text-md text-gray-600 mt-2">
                    {{ __('Please note that deactivating this account will cancel all active and pending transactions associated with it. Make sure to review any ongoing processes before proceeding.') }}
                </p>

                <div class="inline-flex justify-center items-center mt-2 w-full">
                    <label class="relative flex items-center p-3 rounded-full cursor-pointer" for="deactivateBox">
                        <input wire:model="deactivateBox" type="checkbox" id="deactivateBox"
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
                    <label class="mt-px font-light text-gray-700 cursor-pointer select-none" for="deactivateBox">
                        Confirm the transaction
                    </label>
                </div>

            </div>
            <div class="mt-6 flex justify-between">
                <x-secondary-button wire:click.prevent="closeModal('deactivate')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button x-show="deactivateBox" wire:loading.attr="disabled"
                    wire:click.prevent="statusUser(2)" class="ms-3" type="button">
                    {{ __('Deactivate') }}
                    <div wire:loading.delay.long wire:target="statusUser(2)" role="status">
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



    <x-modal name="reset-password-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center" x-data="{ agreeBox: @entangle('agreeBox') }">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col my-4">
                <div class="flex flex-col mt-4 mb-4 w-full justify-center items-center px-4">
                    <span class="text-xl font-semibold">Are you sure you want to reset this user's password?</span>

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
                <x-secondary-button x-on:click="agreeBox = false; $dispatch('close-modal', 'reset-password-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>



                <x-danger-button x-show="agreeBox" wire:loading.attr="disabled" wire:target='resetPassword'
                    wire:click.prevent="resetPassword" class="ms-3" type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="resetPassword" role="status">
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
