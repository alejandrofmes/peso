<div wire:poll class="lg:mx-10">
    <div class="container py-8">

        <div class="grid grid-cols-4 lg:grid-cols-12 gap-4 p-3 lg:p-0">


            <div class="col-span-4 lg:col-span-12">

                {{-- TITLE --}}
                <h1 class="text-2xl font-bold">Job Posting \ Applicants List \ Applicant Overview</h1>
            </div>

            {{-- ALERT MESSAGE FOR MATCH --}}
            <div class="col-span-4 lg:col-span-12">

                @if ($isMatch === true)
                    <div class="bg-green-100 shadow rounded-lg p-6">
                        <div class="flex flex-row items-center justify-between">
                            <p class="text-green-700 font-bold text-xl">This job matches the applicant's preferences.</p>
                            <svg class="w-9 h-9 lg:w-9 lg:h-9 text-green-700 me-2.5" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                        </div>
                        @if ($isResident === false)
                            <div class="flex flex-row items-center mt-2 gap-1">
                                <svg class="w-4 h-4 lg:w-6 lg:h-6 text-yellow-700" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <p class="text-yellow-700 font-bold text-sm">This applicant is from a different
                                    municipality.
                                </p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-red-100 shadow rounded-lg p-6">
                        <div class="flex flex-row items-center justify-between">
                            <p class="text-red-700 font-bold  text-xl">This job doesn't match the applicant's
                                preferences.
                            </p>
                            <svg class="w-9 h-9 lg:w-10 lg:h-10 text-red-700 me-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0V8Zm-1 7a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        @if ($isResident === false)
                            <div class="flex flex-row items-center mt-2 gap-1">
                                <svg class="w-4 h-4 lg:w-6 lg:h-6 text-yellow-700" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <p class="text-yellow-700 font-bold text-sm">This applicant is from a different
                                    municipality.
                                </p>
                            </div>
                        @endif
                    </div>
                @endif
                    
                {{-- @if ($isResident === false)
                    <div class="bg-yellow-100 shadow rounded-lg p-6 mt-2">
                        <div class="flex flex-row items-center justify-between">
                            <p class="text-yellow-700 font-bold  text-xl">This applicant is from a different
                                municipality.
                            </p>
                            <svg class="w-9 h-9 lg:w-10 lg:h-10 text-yellow-700 me-2" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                @endif --}}

            </div>

            {{-- COMPANY CONTAINER --}}
            <div class="col-span-4 px-2 lg:px-0">
                <div class="bg-white shadow rounded-lg p-6">

                    <div class="flex flex-col items-center">
                        {{-- IMAGE --}}
                        <img src="{{ asset('storage/' . $applicant->job_posting->company->company_img) }}"
                            class="select-none w-32 h-32 bg-gray-300 rounded-md mb-4 shrink-0 object-cover shadow-xl">
                        </img>

                        <h1 class="text-xl font-bold">{{ $applicant->job_posting->company->business_Name }}</h1>
                        <p class="text-gray-700">#{{ $applicant->job_posting->company->company_id }}</p>

                        <div class="flex flex-row mt-6 justify-between w-full">
                            <p class="text-md text-gray-800">
                                {{ $applicant->job_posting->company->company_Email }}</p>
                            <p class="text-sm text-gray-800">
                                {{ $applicant->job_posting->company->company_Pnum }}</p>
                        </div>

                    </div>

                    <hr class="my-6 border-t border-gray-300">

                    <div class="flex flex-col">
                        {{-- JOB POSTING INFORMATION --}}
                        <span class="text-gray-700 uppercase font-bold tracking-wider mb-2">Job Posting
                            Details</span>

                        <ul>
                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">Job Position:</li>
                                <p class="ms-4 text-right">{{ $applicant->job_posting->job_Title }}</p>
                            </div>

                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">Industry:</li>
                                <p class="ms-4 text-right">
                                    {{ $applicant->job_posting->job_industry->industry_Title }}
                                </p>
                            </div>

                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">Education Attainment:</li>
                                <p class="ms-4 text-right">{{ $eduLevels[$applicant->job_posting->job_Edu] }}
                                </p>
                            </div>

                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">Salary Range:</li>
                                <p class="ms-4 text-right">
                                    @if ($applicant->job_posting->job_MinWage)
                                        ₱{{ number_format($applicant->job_posting->job_MinWage) }}
                                        @if ($applicant->job_posting->job_MaxWage)
                                            -
                                            ₱{{ number_format($applicant->job_posting->job_MaxWage) }}
                                        @endif
                                    @else
                                        Salary Not Specified
                                    @endif

                            </div>


                            @if ($applicant->job_posting->job_Disability === 1)
                                <div class="flex flex-row justify-between">
                                    <li class="mb-2 font-bold">PWDs:</li>
                                    <p class="ms-4">Accepted</p>
                                </div>
                            @endif

                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">Address:</li>
                                <p class="ms-4 uppercase text-right">
                                    {{ $applicant->job_posting->job_Address }},
                                    {{ $applicant->job_posting->barangay->barangay_Name }},
                                    {{ $applicant->job_posting->barangay->municipality->municipality_Name }},
                                    {{ $applicant->job_posting->barangay->municipality->province->province_Name }}
                                </p>
                            </div>

                        </ul>

                        <div class="mt-6 flex flex-wrap justify-center">
                            <a wire:navigate
                                href="{{ route('admin.jobpost', ['id' => $applicant->job_posting->job_id]) }}"
                                class="bg-blue-700 hover:bg-blue-800 text-white py-2 px-4 rounded">View
                                Job Posting</a>
                        </div>

                    </div>

                </div>

                {{-- TAGS CONTAINER --}}
                <div class="bg-white shadow rounded-lg p-6 mt-4">
                    <div class="flex flex-row w-full gap-4">

                        <div class="flex flex-col w-full">
                            <x-input-label for="fname"> </i> Job Position
                                Tags
                            </x-input-label>
                            {{-- BADGE CONTAINER --}}
                            <div id= "otherSkillRow" class="flex-inline p-1 mt-2">

                                {{-- BADGE --}}
                                @foreach ($applicant->job_posting->job_tags as $jobtags)
                                    <span
                                        class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $jobtags->job_positions->position_Title }}
                                    </span>
                                @endforeach

                            </div>
                        </div>

                    </div>

                </div>


                {{-- JOB QUALIFICATION CONTAINER --}}
                <div class="bg-white shadow rounded-lg p-6 mt-4">

                    <div class="flex flex-row w-full gap-4">

                        <div class="flex flex-col w-full">
                            <x-input-label for="fname"> </i> Job Qualifications
                            </x-input-label>
                            <div
                                class="h-[200px] overflow-auto block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none">
                                <div class="no-tailwindcss-base">
                                    {!! trim($applicant->job_posting->job_Qualifications)
                                        ? $applicant->job_posting->job_Qualifications
                                        : 'Qualifications: No details available.' !!}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>






            <div class="col-span-4 lg:col-span-8 px-2 lg:px-0">
                {{-- CONTAINER FOR APPLICANT INFORMATION --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex flex-row justify-between items-center  mb-6">


                        <h1 class="text-2xl font-bold ">Applicant Information</h1>


                        @if ($applicant->applicant_Status == 'PENDING')
                            <span
                                class="inlineflex items-center rounded-md bg-yellow-200 px-2 py-1 text-sm font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                        @elseif ($applicant->applicant_Status == 'INTERESTED')
                            <span
                                class="inline-flex items-center rounded-md bg-purple-200 px-2 py-1 text-sm font-medium text-purple-800 ring-1 ring-inset ring-purple-600/20">INTERESTED</span>
                        @elseif ($applicant->applicant_Status == 'INTERVIEW')
                            <span
                                class="inline-flex items-center rounded-md bg-blue-200 px-2 py-1 text-sm font-medium text-blue-800 ring-1 ring-inset ring-blue-600/20">INTERVIEW</span>
                        @elseif ($applicant->applicant_Status == 'HIRED')
                            <span
                                class="inline-flex items-center rounded-md bg-green-200 px-2 py-1 text-sm font-medium text-green-800 ring-1 ring-inset ring-green-600/20">HIRED</span>
                        @elseif ($applicant->applicant_Status == 'ACCEPTED')
                            <span
                                class="inline-flex items-center rounded-md bg-emerald-200 px-2 py-1 text-sm font-medium text-emerald-800 ring-1 ring-inset ring-emerald-600/20">ACCEPTED</span>
                        @elseif ($applicant->applicant_Status == 'REJECTED' || $applicant->applicant_Status == 'CANCELLED')
                            <span
                                class="inline-flex items-center rounded-md bg-red-200 px-2 py-1 text-sm font-medium text-red-800 ring-1 ring-inset ring-red-600/20 uppercase">{{ $applicant->applicant_Status }}</span>
                        @endif

                    </div>


                    {{-- PHONE DATE (SMALL SCREEN) --}}
                    <div class="lg:hidden flex flex-row w-full justify-end">
                        <h1 class="text-sm font-light ml-auto mr-5 mt-1 mb-auto">April 28, 2024</h1>
                    </div>

                    <div class="flex flex-row w-full">
                        <div class="flex flex-row w-full items-center">
                            {{-- IMG --}}
                            <img src="{{ asset('storage/' . $applicant->employee->pimg) }}"
                                class="select-none w-32 h-32 bg-gray-300 rounded-lg shrink-0 object-cover shadow-lg">
                            </img>

                            <div class="flex flex-col ml-4 w-full">
                                <h1 class="text-xl lg:text-3xl font-bold uppercase">
                                    {{ $applicant->employee->fname }}
                                    {{ $applicant->employee->mname }} {{ $applicant->employee->lname }}</h1>
                                <p class="text-sm lg:text-lg text-gray-700">Employee ID:
                                    {{ $applicant->employee->employee_id }}</p>
                                <div>
                                    @if ($applicant->peso_Status == 'PENDING')
                                        <span
                                            class="inline-flex items-center rounded-md bg-yellow-200 px-2 py-1 text-sm font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">PENDING</span>
                                    @elseif ($applicant->peso_Status == 'RECOMMENDED')
                                        <span
                                            class="inline-flex items-center rounded-md bg-green-200 px-2 py-1 text-sm font-medium text-green-800 ring-1 ring-inset ring-green-600/20">RECOMMENDED</span>
                                    @elseif ($applicant->peso_Status == 'REJECT')
                                        <span
                                            class="inline-flex items-center rounded-md bg-red-200 px-2 py-1 text-sm font-medium text-red-800 ring-1 ring-inset ring-red-600/20">NOT
                                            RECOMMENDED</span>
                                    @elseif ($applicant->peso_Status == 'CANCELLED')
                                        <span
                                            class="inline-flex items-center rounded-md bg-red-200 px-2 py-1 text-sm font-medium text-red-800 ring-1 ring-inset ring-red-600/20">CANCELLED</span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="flex flex-col w-full">
                            {{-- WEB DATE --}}
                            <h1 class="hidden lg:block text-lg font-light ml-auto mr-2 mb-auto">
                                {{ $applicant->created_at->format('F j, Y') }}
                            </h1>
                            {{-- WEB BUTTONS --}}
                            @if ($applicant->peso_Status == 'PENDING')
                                <div class="hidden lg:flex flex-row w-full justify-end gap-2">
                                    <x-danger-button type="button" x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'reject-modal')">Not
                                        Recommend</x-danger-button>
                                    <x-green-button type="button" x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'recommendation-modal')">Recommend</x-green-button>
                                </div>
                            @endif

                        </div>

                    </div>

                    {{-- MOBILE BUTTONS (SMALL SCREEN) --}}
                    @if ($applicant->peso_Status == 'PENDING')
                        <div class="lg:hidden flex flex-row w-full mt-4 justify-center space-x-4">
                            <x-danger-button type="button" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'reject-modal')">Not
                                Recommend</x-danger-button>
                            <x-green-button type="button" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'recommendation-modal')">Recommend</x-green-button>
                        </div>
                    @endif

                    <hr class="my-6 border-t border-gray-300">

                    <div class="flex flex-col lg:flex-row">

                        <div class="flex flex-col w-full">
                            <ul>
                                <div class="flex flex-row">
                                    <li class="mb-2 font-bold">Status:</li>
                                    <p class="ms-4">
                                        {{ $applicant->employee->empstatus == 1 ? 'Employed' : 'Unemployed' }}
                                    </p>
                                </div>

                                <div class="flex flex-row">
                                    <li class="mb-2 font-bold">Birthdate:</li>
                                    <p class="ms-4">July 1, 1990</p>
                                </div>

                                <div class="flex flex-row">
                                    <li class="mb-2 font-bold">Gender:</li>
                                    <p class="ms-4">
                                        {{ $applicant->employee->gender == 1 ? 'Male' : 'Female' }}</p>
                                </div>
                                <div class="flex flex-row">
                                    <li class="mb-2 font-bold">Contact:</li>
                                    <p class="ms-4">{{ $applicant->employee->pnumber }}</p>
                                </div>
                                <div class="flex flex-row">
                                    <li class="mb-2 font-bold">Email:</li>
                                    <p class="ms-4">{{ $applicant->employee->user->email }}</p>
                                </div>
                                <div class="flex flex-row">
                                    <li class="mb-2 font-bold">Education:</li>
                                    <p class="ms-4 uppercase">
                                        {{ $attainment }}
                                    </p>
                                </div>
                                <div class="flex flex-row">
                                    <li class="mb-2 font-bold">Work Experience:</li>
                                    <p class="ms-4 uppercase">
                                        {{ $totalExperience }} Months
                                    </p>
                                </div>
                                <div class="flex flex-row">
                                    <li class="mb-2 font-bold">OFW Record:</li>
                                    <p class="ms-4 uppercase">
                                        {{ $applicant->employee->ofw == 1 ? 'Yes' : 'No' }}
                                    </p>
                                </div>
                                <div class="flex flex-row">
                                    <li class="mb-2 font-bold">4Ps Member:</li>
                                    <p class="ms-4 uppercase">
                                        {{ $applicant->employee->fourp == 1 ? 'Yes' : 'No' }}
                                    </p>
                                </div>
                                @if ($applicant->employee->fourp == 1 && $applicant->employee->fourpID)
                                    <div class="flex flex-row">
                                        <li class="mb-2 font-bold">4Ps Member ID:</li>
                                        <p class="ms-4 uppercase">
                                            {{ $applicant->employee->fourpID }}
                                        </p>
                                    </div>
                                @endif

                                <div class="flex flex-row">
                                    <li class="mb-2 font-bold">Address:</li>
                                    <p class="ms-4 uppercase">{{ $applicant->employee->address }},
                                        {{ $applicant->employee->barangay->barangay_Name }},
                                        {{ $applicant->employee->barangay->municipality->municipality_Name }},
                                        {{ $applicant->employee->barangay->municipality->province->province_Name }}
                                    </p>
                                </div>
                            </ul>

                        </div>


                        <div class="flex flex-col w-full gap-5">
                            <div>
                                <x-input-label for="fname"> </i> Job Preferences
                                </x-input-label>
                                {{-- BADGE CONTAINER --}}
                                <div id= "job-preference" class="flex-inline p-1 mt-2">
                                    @foreach ($applicant->employee->job_preference as $jobpref)
                                        {{-- BADGE --}}
                                        <span
                                            class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 px-2.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $jobpref->job_positions->position_Title }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <x-input-label for="industry-preference"> </i> Industry Preference
                                </x-input-label>
                                {{-- BADGE CONTAINER --}}
                                <div id= "otherSkillRow" class="flex-inline p-1 mt-2">
                                    @foreach ($applicant->employee->industry_preference as $industrypref)
                                        {{-- BADGE --}}
                                        <span
                                            class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 px-2.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $industrypref->job_industry->industry_Title }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <x-input-label for="skills"> </i> Skills
                                </x-input-label>
                                {{-- BADGE CONTAINER --}}
                                <div id= "otherSkillRow" class="flex-inline p-1 mt-2">
                                    @foreach ($applicant->employee->skills as $skills)
                                        {{-- BADGE --}}
                                        <span
                                            class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 px-2.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $skills->skill_Type }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    </div>
                    @if ($applicant->peso_Status != 'PENDING' && $applicant->peso_Remarks)
                        <hr class="my-6 border-t border-gray-300">

                        <div class="flex flex-col  mt-2">
                            <h1 class="mb-2 font-bold">PESO Remarks -
                                @if ($applicant->peso_accounts)
                                    {{ $applicant->peso_accounts->peso_accounts_Fname }}
                                    {{ $applicant->peso_accounts->peso_accounts_Lname }}
                                @else
                                    System
                                @endif
                            </h1>

                            <textarea id="message" rows="6"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                                placeholder="Company remarks..." maxlength="600" readonly>{{ $applicant->peso_Remarks }}</textarea>
                        </div>
                    @endif

                    {{-- BUTTONS --}}
                    <div class="flex flex-row mt-4 justify-center w-full">
                        <div class="mt-6 flex flex-wrap gap-4 justify-center">
                            <div x-data="{ tooltip: 'View Resume' }">
                                <button {{-- x-on:click="openNewTab('{{ asset('storage/images/requirements/tXllyVuLtDR7W0X5cF6EdkZ9H1BWD2t4odWIFBpT.pdf') }}')" --}} {{-- wire:click.prevent='printResume({{ $applicant->employee_id }}, {{ $applicant->applicant_Resume }})' --}}
                                    wire:click.prevent="viewFile({{ $applicant->employee_id }},{{ $applicant->applicant_Resume }} )"
                                    x-tooltip="tooltip" type="button"
                                    class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                                    </svg>
                                </button>
                            </div>
                            @if ($applicant->peso_Status == 'RECOMMENDED')
                                <div x-data="{ tooltip: 'View Recommendation Letter' }">
                                    <button wire:click.prevent="viewFile({{ $applicant->applicant_id }}, 3 )"
                                        {{-- wire:click.prevent='printRecom({{ $applicant->applicant_id }})' --}} x-tooltip="tooltip" type="button"
                                        class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
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



            </div>
        </div>
    </div>


    {{-- RECOMMENDATION BUTTON MODAL --}}
    <x-modal name="recommendation-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center border-b">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to recommend?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">

                <div class="flex flex-col ">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Upload
                        Recommendation Letter</label>
                    <div class="flex flex-row items-center">

                        <input wire:model='recLetter'
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                            aria-describedby="file_input_help" type="file">
                        <div wire:loading.delay.long wire:target="recLetter" role="status">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-200 animate-spin fill-blue-600 ml-4"
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
                    </div>

                    <p class="mt-1 text-sm text-gray-500 0">PDF Only</p>
                    <x-input-error :messages="$errors->get('recLetter')" class="mt-2" />
                </div>

                <div class="flex flex-col mt-2 w-full">
                    <x-input-label for="remarks" :value="__('Remarks')" />
                    <textarea wire:model='recommendationRemarks' rows="6"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                        placeholder="Write your thoughts here..."></textarea>
                    <x-input-error :messages="$errors->get('recommendationRemarks')" class="mt-2" />
                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click.prevent="closeModal('recommendation')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-green-button wire:loading.attr="disabled"
                    wire:click.prevent="updateApplicant('RECOMMENDED', 'recommendation')" class="ms-3"
                    type="button">
                    {{ __('Confirm Recommendation') }}
                    <div wire:loading.delay.long wire:target="updateApplicant('RECOMMENDED', 'recommendation')"
                        role="status">
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


    {{-- REJECT MODAL --}}
    <x-modal name="reject-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center border-b">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to Reject?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">

                <div class="flex flex-col mt-2 w-full">
                    <x-input-label for="remarks" :value="__('Remarks')" />
                    <textarea wire:model='rejectRemarks' rows="6"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                        placeholder="Write your thoughts here..."></textarea>
                    <x-input-error :messages="$errors->get('rejectRemarks')" class="mt-2" />
                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click.prevent="closeModal('reject')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled" wire:click.prevent="updateApplicant('REJECT', 'reject')"
                    class="ms-3" type="button">
                    {{ __('Reject') }}
                    <div wire:loading.delay.long wire:target="updateApplicant('REJECT', 'reject')" role="status">
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
