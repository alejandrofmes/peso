<div wire:poll class="container mx-auto py-8">
    <div class="grid grid-cols-4 lg:grid-cols-12 gap-4 p-3 lg:p-0">
        <div class="col-span-4 lg:col-span-12">

            {{-- TITLE --}}
            <h1 class="text-2xl font-bold">Job Posting \ Applicants List</h1>
        </div>

        {{-- COMPANY CONTAINER --}}
        <div class="col-span-4 px-2 lg:px-0">
            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex flex-col items-center">
                    {{-- COMPANY IMAGE --}}
                    <img src="{{ asset('storage/' . $jobpost->company->company_img) }}"
                        class="select-none w-32 h-32 bg-gray-300 rounded-md mb-4  shrink-0 object-cover shadow-xl">


                    </img>

                    <h1 class="text-xl font-bold">{{ $jobpost->company->business_Name }}
                    </h1>
                    <p class="text-gray-700">#{{ $jobpost->company->company_id }}</p>

                    <div class="flex flex-row mt-6 justify-between w-full">
                        <p class="text-md text-gray-800">{{ $jobpost->company->company_Email }}</p>
                        <p class="text-sm text-gray-800">{{ $jobpost->company->company_Pnum }}</p>
                    </div>

                </div>

                {{-- DIVIDER --}}
                <hr class="my-6 border-t border-gray-300">

                <div class="flex flex-col">
                    {{-- JOB POSTING INFORMATION --}}
                    <div class="flex flex-row justify-between">
                        <span class="text-gray-700 uppercase font-bold tracking-wider mb-2">Job Posting
                            Details</span>
                        <span
                            class="text-gray-700 uppercase font-bold tracking-wider mb-2">#{{ $jobpost->job_id }}</span>
                    </div>

                    <ul>
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Total Slots:</li>
                            <p class="ms-4 text-right">{{ $jobpost->job_Slots }}</p>
                        </div>
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Job Position:</li>
                            <p class="ms-4 text-right">{{ $jobpost->job_Title }}</p>
                        </div>

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Industry:</li>

                            <p class="ms-4 text-right">{{ $jobpost->job_industry->industry_Title }}</p>
                        </div>

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Education Attainment:</li>
                            <p class="ms-4">{{ $eduLevels[$jobpost->job_Edu] }}</p>
                        </div>

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Salary Range:</li>
                            <p class="ms-4 text-right">
                                @if ($jobpost->job_MinWage)
                                    ₱{{ number_format($jobpost->job_MinWage) }}
                                    @if ($jobpost->job_MaxWage)
                                        -
                                        ₱{{ number_format($jobpost->job_MaxWage) }}
                                    @endif
                                @else
                                    Salary Not Specified
                                @endif
                            </p>
                        </div>


                        @if ($jobpost->job_Disability === 1)
                            <div class="flex flex-row justify-between">
                                <li class="mb-2 font-bold">PWDs:</li>
                                <p class="ms-4">Accepted</p>
                            </div>
                        @endif

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Address:</li>
                            <p class="ms-4 uppercase text-right">{{ $jobpost->job_Address }},
                                {{ $jobpost->barangay->barangay_Name }},
                                {{ $jobpost->barangay->municipality->municipality_Name }},
                                {{ $jobpost->barangay->municipality->province->province_Name }}</p>
                        </div>

                    </ul>

                    {{-- JOB POST LINK --}}
                    <div class="mt-6 flex flex-wrap justify-center">
                        <a wire:navigate href="{{ route('admin.jobpost', ['id' => $jobpost->job_id]) }}"
                            class="bg-blue-700 hover:bg-blue-800 text-white py-2 px-4 rounded">View
                            Job Posting</a>
                    </div>

                </div>

            </div>


            <div class="bg-white shadow rounded-lg p-6 mt-4">

                <div class="flex flex-row w-full gap-4">

                    <div class="flex flex-col w-full">
                        <x-input-label for="fname"> </i> Job Position
                            Tags
                        </x-input-label>
                        {{-- JOB TAG CONTAINER --}}
                        <div id= "otherSkillRow" class="flex-inline p-1 mt-2">

                            @foreach ($jobpost->job_tags as $jobtags)
                                {{-- JOB TAGS --}}
                                <span
                                    class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500 ">
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
                        <x-input-label for="fname"> Job Qualification
                        </x-input-label>
                        <div
                            class="h-[200px] overflow-auto block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none">
                            <div class="no-tailwindcss-base">
                                {!! trim($jobpost->job_Qualifications) ? $jobpost->job_Qualifications : 'Qualifications: No details available.' !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>





        {{-- CONTAINER FOR TABS --}}
        <div class="col-span-4 lg:col-span-8 px-2 lg:px-0">

            {{-- APPLICATION LIST CONTAINER --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex flex-row justify-between">
                    <h1 class="text-md lg:text-2xl font-bold mb">Applicant List</h1>
                    <h1 class="text-md lg:text-2xl font-bold mb">Slots Remaining: {{ $jobpost->slotsLeft }} </h1>

                </div>
                <hr class="h-px my-4  bg-gray-200 border-0 dark:bg-gray-700">

                <div class="relative overflow-x-auto">
                    <div class="flex flex-col lg:flex-row p-1 lg:justify-between gap-2 space-y-4 lg:space-y-0 pb-4">

                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>

                            {{-- SEARCH --}}
                            <input wire:model.live='search' type="search" id="table-search-users"
                                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search for Applicants">
                        </div>
                        <div class="flex flex-wrap mr-3 gap-2">
                            <div x-data="{ tooltip: 'Export to Excel' }">
                                <button x-tooltip='tooltip' type="button" wire:click.prevent='exportData'
                                    class="flex items-center py-1.5 px-4 text-xs lg:text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    <span class="mr-2">Export</span>
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </button>

                            </div>
                        </div>

                    </div>

                    {{-- APPLICANT LIST TABLE --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3 hidden lg:table-cell">Status</th>
                                    <th scope="col" class="px-6 py-3 hidden lg:table-cell">PESO Status</th>
                                    <th scope="col" class="px-6 py-3 hidden lg:table-cell">Date Applied</th>
                                    <th scope="col" class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($jobApplicants->isEmpty())
                                    <tr>
                                        <td colspan="6">
                                            <div class="flex flex-col justify-center items-center mt-20 mb-20">
                                                <div class="flex bg-gray-100 rounded-full p-1">
                                                    <svg class="w-16 h-16 text-black" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M21 21l-3.5-3.5m0 0a7 7 0 1 1-9-10.5 7 7 0 0 1 9 10.5z" />
                                                    </svg>
                                                </div>
                                                <div class="text-center text-black text-xl font-semibold mt-2">
                                                    No Applicants Found
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($jobApplicants as $applicants)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row"
                                                class="flex items-center px-2 md:px-6 py-4 text-gray-900 whitespace-nowrap">

                                                <img class="select-none w-8 h-8 md:w-10 md:h-10 rounded-full object-cover shadow-lg"
                                                    src="{{ asset('storage/' . $applicants->employee->pimg) }}"
                                                    alt="company-{{ $applicants->applicant_id }}">
                                                <div class="ps-3 text-wrap">
                                                    <div class="text-sm md:text-base font-semibold uppercase">
                                                        {{ $applicants->employee->fname }}
                                                        {{ $applicants->employee->mname }}
                                                        {{ $applicants->employee->lname }}
                                                    </div>
                                                    <div class="font-normal text-gray-500 text-sm uppercase">
                                                        {{ $applicants->employee->address }},
                                                        {{ $applicants->employee->barangay->barangay_Name }},
                                                        {{ $applicants->employee->barangay->municipality->municipality_Name }}
                                                    </div>

                                                    <div
                                                        class="font-normal text-gray-500 text-sm uppercase lg:hidden mt-2">
                                                        Status:
                                                        <span class="font-bold">
                                                            @if ($applicants->applicant_Status == 'PENDING')
                                                                <div
                                                                    class="h-2 w-2 rounded-full bg-yellow-500 inline-block">
                                                                </div> PENDING
                                                            @elseif($applicants->applicant_Status == 'INTERVIEW')
                                                                <div
                                                                    class="h-2 w-2 rounded-full bg-blue-500 inline-block">
                                                                </div> INTERVIEW
                                                            @elseif($applicants->applicant_Status == 'HIRED')
                                                                <div
                                                                    class="h-2 w-2 rounded-full bg-green-500 inline-block">
                                                                </div> HIRED
                                                            @elseif(in_array($applicants->applicant_Status, ['REJECTED', 'CANCELLED']))
                                                                <div
                                                                    class="h-2 w-2 rounded-full bg-green-500 inline-block">
                                                                </div>{{ $applicants->applicant_Status }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="font-normal text-gray-500 text-sm uppercase lg:hidden">
                                                        PESO:
                                                        <span class="font-bold">
                                                            @if ($applicants->peso_Status == 'PENDING')
                                                                <div
                                                                    class="h-2 w-2 rounded-full bg-yellow-500 inline-block">
                                                                </div> PENDING
                                                            @elseif($applicants->peso_Status == 'RECOMMENDED')
                                                                <div
                                                                    class="h-2 w-2 rounded-full bg-green-500 inline-block">
                                                                </div> RECOMMENDED
                                                            @elseif(in_array($applicants->peso_Status, ['REJECT', 'CANCELLED']))
                                                                <div
                                                                    class="h-2 w-2 rounded-full bg-red-500 inline-block">
                                                                </div> {{ $applicants->peso_Status }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <!-- Show date on mobile -->
                                                    <div class="text-gray-500 text-xs lg:hidden">
                                                        Applied: {{ $applicants->created_at->format('F j, Y') }}
                                                    </div>

                                                </div>


                                                <!-- Status (Hidden on mobile) -->
                                            <td class="px-6 py-4 hidden lg:table-cell">
                                                <div class="font-semibold">
                                                    @if ($applicants->applicant_Status == 'PENDING')
                                                        <div
                                                            class="h-2.5 w-2.5 rounded-full bg-yellow-500 inline-block">
                                                        </div> PENDING
                                                    @elseif($applicants->applicant_Status == 'INTERVIEW')
                                                        <div class="h-2.5 w-2.5 rounded-full bg-blue-500 inline-block">
                                                        </div> INTERVIEW
                                                    @elseif($applicants->applicant_Status == 'HIRED')
                                                        <div
                                                            class="h-2.5 w-2.5 rounded-full bg-green-500 inline-block">
                                                        </div> HIRED
                                                    @elseif($applicants->applicant_Status == 'HIRED')
                                                        <div
                                                            class="h-2.5 w-2.5 rounded-full bg-green-500 inline-block">
                                                        </div> HIRED
                                                    @elseif(in_array($applicants->applicant_Status, ['REJECTED', 'CANCELLED']))
                                                        <div
                                                            class="h-2.5 w-2.5 rounded-full bg-green-500 inline-block">
                                                        </div> {{ $applicants->applicant_Status }}
                                                    @endif
                                                </div>
                                            </td>
                                            <!-- PESO Status (Hidden on mobile) -->
                                            <td class="px-6 py-4 hidden lg:table-cell">
                                                <div class="font-semibold">
                                                    @if ($applicants->peso_Status == 'PENDING')
                                                        <div
                                                            class="h-2.5 w-2.5 rounded-full bg-yellow-500 inline-block">
                                                        </div> PENDING
                                                    @elseif($applicants->peso_Status == 'RECOMMENDED')
                                                        <div
                                                            class="h-2.5 w-2.5 rounded-full bg-green-500 inline-block">
                                                        </div> RECOMMENDED
                                                    @elseif(in_array($applicants->peso_Status, ['REJECT', 'CANCELLED']))
                                                        <div class="h-2.5 w-2.5 rounded-full bg-red-500 inline-block">
                                                        </div> {{ $applicants->peso_Status }}
                                                    @endif
                                                </div>
                                            </td>
                                            <!-- Date Applied (Hidden on mobile) -->
                                            <td class="px-6 py-4 hidden lg:table-cell">
                                                <div class="text-sm">{{ $applicants->created_at->format('F j, Y') }}
                                                </div>
                                            </td>
                                            <!-- Actions -->
                                            <td class="px-6 py-4 text-center">
                                                <div x-data="{ tooltip: 'Applicant Overview' }">
                                                    <a wire:navigate
                                                        href="{{ route('admin.jobpost.applicants.overview', ['id' => $applicants->applicant_id]) }}"
                                                        x-tooltip="tooltip" type="button"
                                                        class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-1 inline-flex items-center">
                                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                            <path fill-rule="evenodd"
                                                                d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
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

                <div class="mt-2">
                    {{ $jobApplicants->links('vendor.livewire.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>
