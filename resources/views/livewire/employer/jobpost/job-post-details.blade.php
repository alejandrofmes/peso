<div class="w-full">
    <div wire:poll class="flex py-2 mx-auto lg:mx-12 ">
        <div class="grid w-full grid-cols-4 gap-10 p-3 lg:grid-cols-12 lg:p-0">
            <div class="col-span-4 lg:col-span-12">
                {{-- TITLE --}}

            </div>


            {{-- FIRST CONTAINER --}}
            {{-- <div class="col-span-4 lg:col-span-12">
              

            </div> --}}

            {{-- SECOND CONTAINER FOR JOB DESCRIPTION --}}
            <div class="col-span-4 lg:col-span-6">
                <div class="flex flex-col p-6 bg-white rounded-lg shadow">


                    <div class="flex flex-row w-full">

                        <div class="flex flex-row items-center w-full">
                            {{-- IMG --}}
                            <img src="{{ asset('storage/' . $jobpost->company->company_img) }}"
                                class="object-cover w-32 h-32 bg-gray-300 rounded-lg shadow-lg shrink-0">
                            </img>

                            <div class="flex flex-col w-full ml-4">
                                <h1 class="text-xl font-bold lg:text-3xl">{{ $jobpost->company->business_Name }}</h1>
                                <p class="text-sm text-gray-700 uppercase lg:text-lg">
                                    {{ $jobpost->company->company_Address }},
                                    {{ $jobpost->barangay->barangay_Name }},
                                    {{ $jobpost->barangay->municipality->municipality_Name }},
                                    {{ $jobpost->barangay->municipality->province->province_Name }}</p>

                                <div class="flex">
                                    @if ($jobpost->job_Status == 'PENDING')
                                        <span
                                            class="bg-yellow-100 text-yellow-800 text-sm font-medium px-2.5 py-1 lg:text-md lg:font-semibold me-2 lg:px-10 lg:py-2 rounded-lg ">PENDING</span>
                                    @elseif($jobpost->job_Status == 'ACTIVE')
                                        <span
                                            class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-1 lg:text-md lg:font-semibold me-2 lg:px-10 lg:py-2 rounded-lg ">ACTIVE</span>
                                    @elseif($jobpost->job_Status == 'CLOSED')
                                        <span
                                            class="bg-cyan-100 text-cyan-800 text-sm font-medium px-2.5 py-1 lg:text-md lg:font-semibold me-2 lg:px-10 lg:py-2 rounded-lg ">CLOSED</span>
                                    @elseif($jobpost->job_Status == 'COMPLETED')
                                        <span
                                            class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-1 lg:text-md lg:font-semibold me-2 lg:px-10 lg:py-2 rounded-lg ">COMPLETED</span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-1 lg:text-md lg:font-semibold me-2 lg:px-10 lg:py-2 rounded-lg ">{{ $jobpost->job_Status }}</span>
                                    @endif
                                </div>
                            </div>

                        </div>



                    </div>

                </div>

                <div class="flex flex-col p-6 mt-4 bg-white rounded-lg shadow">

                    <div class="flex flex-col gap-2 lg:flex-row lg:justify-between">
                        <h1 class="text-2xl font-bold">Job Posting Details</h1>

                        @if ($jobpost->job_Disability == 1)
                            <div
                                class="flex px-4 py-1 text-sm font-bold text-green-700 bg-green-200 border border-green-500 rounded-full w-fit">
                                <svg class="w-5 h-5 text-green-500" width="24" height="24" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <circle cx="11" cy="5" r="2" />
                                    <polyline points="11 7 11 15 15 15 19 20" />
                                    <line x1="11" y1="11" x2="16" y2="11" />
                                    <path d="M7 11.5a4.97 4.97 0 1 0 6 7.5" />
                                </svg>
                                PWDs Accepted
                            </div>
                        @endif

                    </div>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">



                    <div class="flex flex-col w-full gap-4 mt-4 lg:flex-row">

                        <div class="flex flex-col w-full">
                            <x-input-label for="title"> <i class="fa-solid fa-briefcase"></i> Job
                                Title
                            </x-input-label>
                            <x-text-input id="title" class="block w-full mt-1" type="text"
                                value="{{ $jobpost->job_Title }}" readonly />
                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="industry" class="flex flex-row items-center gap-1"> <svg class="w-5 h-5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4.5 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5h-.75V3.75a.75.75 0 0 0 0-1.5h-15ZM9 6a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm-.75 3.75A.75.75 0 0 1 9 9h1.5a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM9 12a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm3.75-5.25A.75.75 0 0 1 13.5 6H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM13.5 9a.75.75 0 0 0 0 1.5H15A.75.75 0 0 0 15 9h-1.5Zm-.75 3.75a.75.75 0 0 1 .75-.75H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM9 19.5v-2.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-4.5A.75.75 0 0 1 9 19.5Z"
                                        clip-rule="evenodd" />
                                </svg>Job Industry
                            </x-input-label>
                            <x-text-input id="industry" class="block w-full mt-1" type="text"
                                value="{{ $jobpost->job_industry->industry_Title }}" readonly />
                        </div>

                    </div>


                    <div class="flex flex-col w-full gap-4 mt-4 lg:flex-row">

                        <div class="flex flex-col w-full ml">
                            <x-input-label for="education" class="flex flex-row items-center gap-1"> <svg
                                    class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                                    <path
                                        d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                                    <path
                                        d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                                </svg>

                                Educational Attainment
                            </x-input-label>
                            <x-text-input id="education" class="block w-full mt-1" type="text"
                                value=" {{ $eduLevels[$jobpost->job_Edu] }}" readonly />
                        </div>

                        <div class="flex flex-col w-full lg:flex-col ml">
                            <x-input-label for="type"> <i class="fa-solid fa-briefcase"></i> Employment Type
                            </x-input-label>
                            <x-text-input id="type" class="block w-full mt-1" type="text"
                                value="{{ $jobTypes[$jobpost->job_Type] }}" readonly />
                        </div>

                    </div>

                    <div class="flex flex-col w-full gap-4 mt-4 lg:flex-row">

                        <div class="flex flex-col w-full">
                            <x-input-label for="wage" class="flex flex-row items-center gap-1"><svg class="w-5 h-5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                                    <path fill-rule="evenodd"
                                        d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z" />
                                </svg>
                                Wage Range
                            </x-input-label>
                            <x-text-input id="wage" class="block w-full mt-1" type="text" name="fnamePost"
                                value="₱{{ number_format($jobpost->job_MinWage) }} - ₱{{ number_format($jobpost->job_MaxWage) }}"
                                readonly />
                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="duration" class="flex flex-row items-center gap-1"> <svg class="w-5 h-5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                    <path fill-rule="evenodd"
                                        d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Job
                                Posting Duration
                            </x-input-label>
                            <x-text-input id="duration" class="block w-full mt-1" type="text"
                                value=" {{ $jobpost->job_Duration->format('F j, Y') }}" readonly />
                        </div>

                        <div class="flex flex-col w-2/3">
                            <x-input-label for="slots" class="flex flex-row items-center gap-1"><svg
                                    class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
                                </svg>

                                Job Slots
                            </x-input-label>
                            <x-text-input id="slots" class="block w-full mt-1" type="text"
                                value=" {{ $jobpost->job_Slots }}" readonly />
                        </div>

                    </div>

                </div>


                {{-- CONTAINER FOR JOB TAGS --}}
                <div class="flex flex-col p-6 mt-4 bg-white rounded-lg shadow">
                    {{-- TITLE --}}
                    <h1 class="text-xl font-bold lg:text-3xl">Job Posting Tags</h1>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                    <div class="flex flex-row w-full gap-4 mt-4">

                        <div class="flex flex-col w-full">
                            <x-input-label for="fname"> </i> Job Position
                                Tags
                            </x-input-label>
                            {{-- BADGE CONTAINER --}}
                            <div id= "otherSkillRow" class="p-1 mt-2 border border-gray-300 rounded-lg flex-inline">

                                {{-- BADGE --}}
                                @foreach ($jobpost->job_tags as $jobTag)
                                    <span
                                        class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $jobTag->job_positions->position_Title }}
                                    </span>
                                @endforeach

                            </div>
                        </div>

                    </div>

                </div>


                {{-- CONTAINER FOR DESCRIPTIONS --}}
                <div class="flex flex-col p-6 mt-4 bg-white rounded-lg shadow">

                    <h1 class="text-xl font-bold lg:text-3xl">Job Posting Description</h1>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                    <div class="flex flex-row w-full gap-4 mt-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="fname"> </i> Job
                                Description
                            </x-input-label>
                            <div
                                class="h-[200px] overflow-auto block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none">
                                <div class="no-tailwindcss-base">
                                    {!! trim($jobpost->job_Description) ? $jobpost->job_Description : 'Job Description: No details available' !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-row w-full gap-4 mt-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="fname"></i> Job
                                Qualification
                            </x-input-label>
                            <div
                                class="h-[200px] overflow-auto block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none">
                                <div class="no-tailwindcss-base">
                                    {!! trim($jobpost->job_Qualifications) ? $jobpost->job_Qualifications : 'Qualifications: No details available.' !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-row w-full gap-4 mt-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="fname"></i> Job
                                Company Remarks
                            </x-input-label>
                            <div
                                class="h-[200px] overflow-auto block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none">
                                <div class="no-tailwindcss-base">
                                    {!! trim($jobpost->job_Remarks) ? $jobpost->job_Remarks : 'Remarks: No additional details available.' !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>


            {{-- WEB REQUIREMENT CONTAINER --}}
            <div class="col-span-4 lg:col-span-6" x-data="{
                selectedApplicant: @entangle('selectedApplicant')
            }">


                @if (
                    ($jobpost->job_Status == 'ACTIVE' || $jobpost->job_Status == 'REJECTED' || $jobpost->job_Status == 'CANCELLED') &&
                        $jobpost->peso_Remarks)
                    <div class="flex flex-col p-6 bg-white rounded-lg shadow">

                        <div class="flex flex-row">
                            <h1 class="text-2xl font-bold ">PESO Remarks</h1>


                        </div>
                        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                        <div class="flex gap-4 lg:flex-row lg:justify-between">
                            @if ($jobpost->peso_accounts)
                                <h1 class="font-semibold text-md">{{ $jobpost->peso_accounts->peso_accounts_Fname }}
                                    {{ $jobpost->peso_accounts->peso_accounts_Lname }}</h1>
                            @endif
                            @if ($jobpost->responded_at)
                                <h1 class="text-md ">{{ $jobpost->responded_at->format('F j, Y') }}</h1>
                            @endif
                        </div>


                        <div class="flex flex-col w-full">

                            <textarea id="message" rows="6" readonly
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                placeholder="Write your thoughts here...">{{ $jobpost->peso_Remarks }}</textarea>
                        </div>

                    </div>
                @endif



                <div x-show="!selectedApplicant" class="flex flex-col p-6 mt-4 bg-white rounded-lg shadow"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
                    <h1 class="mb-3 text-xl font-bold lg:text-3xl">Job Applicants</h1>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                    <div class="flex flex-col p-1" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">


                        <div class="relative">

                            <div
                                class="flex flex-col gap-2 p-1 pb-4 space-y-4 overflow-visible lg:flex-row lg:justify-between lg:space-y-0">

                                <div>

                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative ">
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
                                        <input wire:model.live='applicantSearch' type="search"
                                            id="table-search-users"
                                            class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Search applicants">
                                    </div>
                                </div>

                                {{-- DROP DOWN BUTTON --}}

                                <div class="flex flex-row gap-2">
                                    <x-dropdown align="left" width="[150px]">
                                        <x-slot name="trigger">
                                            <button
                                                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                                <div>
                                                    {{ $filter }}
                                                </div>

                                                <div class="ms-1">
                                                    <svg class="w-4 h-4 fill-current"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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
                                                wire:click.prevent="changeFilter('All')">
                                                All
                                            </x-dropdown-link>
                                            <x-dropdown-link class="cursor-pointer"
                                                wire:click.prevent="changeFilter('Pending')">
                                                Pending
                                            </x-dropdown-link>
                                            <x-dropdown-link class="cursor-pointer"
                                                wire:click.prevent="changeFilter('Interested')">
                                                Interested
                                            </x-dropdown-link>
                                            <x-dropdown-link class="cursor-pointer"
                                                wire:click.prevent="changeFilter('Interview')">
                                                Interview
                                            </x-dropdown-link>
                                            <x-dropdown-link class="cursor-pointer"
                                                wire:click.prevent="changeFilter('Hired')">
                                                Hired
                                            </x-dropdown-link>
                                            <x-dropdown-link class="cursor-pointer"
                                                wire:click.prevent="changeFilter('Accepted')">
                                                Accepted
                                            </x-dropdown-link>
                                            <x-dropdown-link class="cursor-pointer"
                                                wire:click.prevent="changeFilter('Rejected')">
                                                Rejected
                                            </x-dropdown-link>


                                        </x-slot>
                                    </x-dropdown>
                                    <x-dropdown align="left" width="[150px]">
                                        <x-slot name="trigger">
                                            <button
                                                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                                <div>
                                                    {{ $sortDate === 'ASC' ? 'Oldest' : ($sortDate == 'DESC' ? 'Newest' : 'Sort by Date') }}
                                                </div>

                                                <div class="ms-1">
                                                    <svg class="w-4 h-4 fill-current"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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
                                            <th scope="col" class="px-4 py-2 lg:px-6 lg:py-3">
                                                <!-- Adjusted padding -->
                                                Name
                                            </th>
                                            <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                                <!-- Hidden on mobile -->
                                                Status
                                            </th>
                                            <th scope="col" class="px-4 py-2 lg:px-6 lg:py-3">
                                                <!-- Adjusted padding -->
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($applicants['list']) && count($applicants['list']) === 0)
                                            <tr>
                                                <td colspan="3">
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
                                                            No Applicants Found</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($applicants['list'] as $data)
                                                <tr wire:key='jobApplicant-{{ $data->applicant_id }}'
                                                    class="bg-white border-b hover:bg-gray-50">
                                                    <th scope="row"
                                                        class="flex items-center px-4 py-2 text-gray-900 lg:px-6 lg:py-4 whitespace-nowrap">
                                                        <!-- Adjusted padding -->
                                                        <img class="object-cover w-10 h-10 rounded-full"
                                                            src="{{ asset('storage/' . $data->employee->pimg) }}"
                                                            alt="Profile image">
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
                                                            <div class="text-xs font-medium text-gray-500">Applied
                                                                date: {{ $data->created_at->format('F j, Y') }}</div>
                                                            <div class="text-sm lg:hidden">
                                                                <div class="flex items-center ">
                                                                    @if ($data->applicant_Status === 'PENDING')
                                                                        <div
                                                                            class="h-2.5 w-2.5 rounded-full bg-yellow-500 me-2">
                                                                        </div>
                                                                        PENDING
                                                                    @elseif($data->applicant_Status === 'INTERESTED')
                                                                        <div
                                                                            class="h-2.5 w-2.5 rounded-full bg-purple-500 me-2">
                                                                        </div>
                                                                        INTERESTED
                                                                    @elseif($data->applicant_Status === 'INTERVIEW')
                                                                        <div
                                                                            class="h-2.5 w-2.5 rounded-full bg-blue-500 me-2">
                                                                        </div>
                                                                        INTERVIEW
                                                                    @elseif($data->applicant_Status === 'HIRED')
                                                                        <div
                                                                            class="h-2.5 w-2.5 rounded-full bg-green-500 me-2">
                                                                        </div>
                                                                        HIRED
                                                                    @elseif($data->applicant_Status === 'ACCEPTED')
                                                                        <div
                                                                            class="h-2.5 w-2.5 rounded-full bg-emerald-500 me-2">
                                                                        </div>
                                                                        ACCEPTED
                                                                    @elseif($data->applicant_Status === 'REJECTED' || $data->applicant_Status === 'CANCELLED')
                                                                        <div
                                                                            class="h-2.5 w-2.5 rounded-full bg-red-500 me-2">
                                                                        </div>
                                                                        <p class="uppercase">
                                                                            {{ $data->applicant_Status }}</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </th>

                                                    <td class="hidden px-6 py-4 lg:table-cell">
                                                        <!-- Hidden on mobile -->
                                                        <div class="flex items-center">
                                                            @if ($data->applicant_Status === 'PENDING')
                                                                <div
                                                                    class="h-2.5 w-2.5 rounded-full bg-yellow-500 me-2">
                                                                </div>
                                                                PENDING
                                                            @elseif($data->applicant_Status === 'INTERESTED')
                                                                <div
                                                                    class="h-2.5 w-2.5 rounded-full bg-purple-500 me-2">
                                                                </div>
                                                                INTERESTED
                                                            @elseif($data->applicant_Status === 'INTERVIEW')
                                                                <div class="h-2.5 w-2.5 rounded-full bg-blue-500 me-2">
                                                                </div>
                                                                INTERVIEW
                                                            @elseif($data->applicant_Status === 'HIRED')
                                                                <div
                                                                    class="h-2.5 w-2.5 rounded-full bg-green-500 me-2">
                                                                </div>
                                                                HIRED
                                                            @elseif($data->applicant_Status === 'ACCEPTED')
                                                                <div
                                                                    class="h-2.5 w-2.5 rounded-full bg-emerald-500 me-2">
                                                                </div>
                                                                ACCEPTED
                                                            @elseif($data->applicant_Status === 'REJECTED' || $data->applicant_Status === 'CANCELLED')
                                                                <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2">
                                                                </div>
                                                                <p class="uppercase">{{ $data->applicant_Status }}</p>
                                                            @endif
                                                        </div>
                                                    </td>

                                                    <td class="px-4 py-2 lg:px-6 lg:py-4"> <!-- Adjusted padding -->
                                                        <div class="flex flex-row items-center gap-4">
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

                </div>


                <div x-show="selectedApplicant" class="flex flex-col p-6 mt-4 bg-white rounded-lg shadow"
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
                                    class="flex w-[140px] h-[100px] bg-gray-300 object-cover rounded-lg shrink-0 grow-0">
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
                                <div class="flex flex-row ">
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


                                <div class="flex flex-row ">
                                    <li class="mb-2 font-bold">PESO Status:</li>
                                    <p class="ms-4">

                                        @if ($applicantInfo->peso_Status == 'PENDING')
                                            <span
                                                class="items-center px-1 py-1 text-sm font-medium text-yellow-800 bg-yellow-200 rounded-md inlineflex ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                                        @elseif ($applicantInfo->peso_Status == 'RECOMMENDED')
                                            <span
                                                class="inline-flex items-center px-1 py-1 text-sm font-medium text-green-800 bg-green-200 rounded-md ring-1 ring-inset ring-green-600/20">RECOMMENDED</span>
                                        @elseif ($applicantInfo->peso_Status == 'REJECT')
                                            <span
                                                class="inline-flex items-center px-1 py-1 text-sm font-medium text-red-800 uppercase bg-red-200 rounded-md ring-1 ring-inset ring-red-600/20">NOT
                                                RECOMMENDED</span>
                                        @elseif ($applicantInfo->peso_Status == 'CANCELLED')
                                            <span
                                                class="inline-flex items-center px-1 py-1 text-sm font-medium text-red-800 uppercase bg-red-200 rounded-md ring-1 ring-inset ring-red-600/20">CANCELLED</span>
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
            </div>









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
