<div class="container py-8 mx-auto">




    <div class="grid grid-cols-4 gap-4 p-3 lg:grid-cols-12 lg:p-0">


        {{-- <div class="col-span-2 lg:col-span-3">
            <div class="flex flex-col w-full h-full p-6 bg-white rounded-lg shadow">
                <div id="QrScanner" class="flex w-full h-full"></div>

            </div>

        </div> --}}


        <div class="col-span-2 lg:col-span-3">
            <div class="flex flex-col w-full h-full p-6 bg-white rounded-lg shadow">
                <div class="flex flex-row justify-start">
                    <h1 class="font-mono text-sm font-thin">Job Postings</h1>
                </div>
                <div class="flex flex-row justify-between mb-5">
                    <h1 class="font-mono text-4xl font-extrabold">{{ $totalJobPostings }}</h1>

                    <svg class="w-10 h-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>


                </div>
                <div class="flex flex-row justify-content">

                    <h1 class="font-mono text-sm font-thin"><span
                            class="bg-green-100 text-green-800 text-md font-medium me-2 px-2.5 py-0.5 rounded">
                            {{ $recentJobPostings }}</span>New Job
                        Postings
                    </h1>
                </div>


            </div>

        </div>

        <div class="col-span-2 lg:col-span-3">
            <div class="flex flex-col w-full h-full p-6 bg-white rounded-lg shadow">
                <div class="flex flex-row justify-start">
                    <h1 class="font-mono text-sm font-thin">Jobseekers</h1>
                </div>
                <div class="flex flex-row justify-between mb-5">
                    <h1 class="font-mono text-4xl font-extrabold">{{ $totalJobSeekers }}</h1>

                    <svg class="w-10 h-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>

                </div>
                <div class="flex flex-row justify-content">

                    <h1 class="font-mono text-sm font-thin"><span
                            class="bg-green-100 text-green-800 text-md font-medium me-2 px-2.5 py-0.5 rounded">
                            {{ $recentJobSeekers }}</span>New Job
                        Seekers
                    </h1>
                </div>


            </div>

        </div>

        <div class="col-span-2 lg:col-span-3">
            <div class="flex flex-col w-full h-full p-6 bg-white rounded-lg shadow">
                <div class="flex flex-row justify-start">
                    <h1 class="font-mono text-sm font-thin">Employed Users</h1>
                </div>
                <div class="flex flex-row justify-between mb-5">
                    <h1 class="font-mono text-4xl font-extrabold">{{ $totalEmployed }}</h1>

                    <svg class="w-10 h-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
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

        <div class="col-span-2 lg:col-span-3">
            <div class="flex flex-col w-full h-full p-6 bg-white rounded-lg shadow">
                <div class="flex flex-row justify-start">
                    <h1 class="font-mono text-sm font-thin">Active Applicants</h1>
                </div>
                <div class="flex flex-row justify-between mb-5">
                    <h1 class="font-mono text-4xl font-extrabold">{{ $totalActiveApplicants }}</h1>

                    <svg class="w-10 h-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
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


        <div class="col-span-4 lg:col-span-6">
            <div class="w-full h-full p-6 bg-white rounded-lg shadow">
                <h1 class="text-2xl font-bold">Recent Job Posting</h1>
                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full mt-2 text-sm text-left text-gray-500 rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase bg-blue-300">
                            <tr>
                                <th scope="col" class="px-2 py-3 md:px-6">
                                    <span class="font-bold text-black text-md">Business Name</span>
                                </th>
                                <th scope="col" class="hidden px-2 py-3 md:px-6 lg:table-cell">
                                    <span class="font-bold text-black text-md">Job Title</span>
                                </th>
                                <th scope="col" class="hidden px-2 py-3 md:px-6 lg:table-cell">
                                    <span class="font-bold text-black text-md">Date</span>
                                </th>
                                <th scope="col" class="px-2 py-3 md:px-6">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($recentJobPost->isEmpty())
                                <tr>
                                    <td colspan="4">
                                        <div class="flex flex-col items-center justify-center mt-10">
                                            <div class="p-6 bg-gray-100 rounded-full">
                                                <svg class="w-16 h-16 text-black md:w-24 md:h-24" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                </svg>
                                            </div>
                                            <p class="mt-2 mb-20 text-lg font-bold text-center text-black md:text-xl">
                                                No Recent Job Posting Found!
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($recentJobPost as $data)
                                    <tr wire:key='jobpost-{{ $data->job_id }}'
                                        class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row"
                                            class="flex items-center px-2 py-4 text-gray-900 md:px-6 whitespace-nowrap">
                                            <img class="object-cover w-8 h-8 rounded-full shadow-lg select-none md:w-10 md:h-10"
                                                src="{{ asset('storage/' . $data->company->company_img) }}"
                                                alt="company-{{ $data->job_id }}">
                                            <div class="ps-3 text-wrap">
                                                <div class="text-sm font-semibold uppercase md:text-base">
                                                    {{ $data->company->business_Name }}
                                                </div>
                                                <div class="text-xs font-normal text-gray-500 uppercase md:text-sm">
                                                    {{ $data->job_Address }}, {{ $data->barangay->barangay_Name }},
                                                    {{ $data->barangay->municipality->municipality_Name }}
                                                </div>
                                                <!-- Show Job Title on mobile view -->
                                                <div
                                                    class="text-xs font-normal text-gray-500 uppercase md:text-sm lg:hidden">
                                                    Job: <span
                                                        class="text-sm font-bold text-blue-500 md:text-md">{{ $data->job_Title }}</span>
                                                </div>
                                                <!-- Show Date on mobile view -->
                                                <div class="text-xs text-gray-500 lg:hidden">
                                                    Posted: {{ $data->created_at->format('F j, Y') }}
                                                </div>
                                            </div>
                                        </th>
                                        <!-- Hide Job Title on mobile view -->
                                        <td class="hidden px-2 py-4 md:px-6 lg:table-cell">
                                            <div class="text-xs font-normal text-gray-500 uppercase md:text-sm">
                                                <span
                                                    class="text-sm font-bold text-blue-500 md:text-md">{{ $data->job_Title }}</span>
                                            </div>
                                        </td>
                                        <!-- Hide Date on mobile view -->
                                        <td class="hidden px-2 py-4 md:px-6 lg:table-cell">
                                            {{ $data->created_at->format('F j, Y') }}
                                        </td>
                                        <td class="px-2 py-4 md:px-6">
                                            <div x-data="{ tooltip: 'Job Overview' }">
                                                <a wire:navigate
                                                    href="{{ route('admin.jobpost', ['id' => $data->job_id]) }}"
                                                    x-tooltip="tooltip" type="button"
                                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
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
        </div>



        <div class="col-span-4 lg:col-span-6">
            <div class="w-full h-full p-6 bg-white rounded-lg shadow ">
                <h1 class="text-2xl font-bold">Most Preferred Job Tags</h1>
                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                <div class="flex flex-col h-[400px] lg:h-full items-end">
                    <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}" :column-chart-model="$columnChartModel" />
                </div>
            </div>

        </div>

        <div class="col-span-4 lg:col-span-6">
            <div class="w-full h-full p-6 overflow-auto bg-white rounded-lg shadow">
                <h1 class="text-2xl font-bold">Recent Job Applications</h1>
                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                <div class="overflow-auto">
                    <table class="w-full mt-2 text-sm text-left text-gray-500 rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase bg-blue-300">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    <span class="font-bold text-black text-md">Applicant Name</span>
                                </th>
                                <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                    <span class="font-bold text-black text-md">Job Title</span>
                                </th>
                                <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                    <span class="font-bold text-black text-md">Date</span>
                                </th>
                                <th scope="col" class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($recentApplicants->isEmpty())
                                <tr>
                                    <td colspan="4">
                                        <div class="flex flex-col items-center justify-center mt-10">
                                            <div class="p-6 bg-gray-100 rounded-full">
                                                <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-width="2"
                                                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                </svg>
                                            </div>
                                            <p class="mt-2 mb-20 text-xl font-bold text-center text-black">
                                                No Recent Applicants Found!
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($recentApplicants as $data)
                                    <tr wire:key='applicants-{{ $data->job_id }}'
                                        class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row"
                                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                            <img class="object-cover w-10 h-10 rounded-full shadow-xl select-none"
                                                src="{{ asset('storage/' . $data->employee->pimg) }}"
                                                alt="applicant-{{ $data->job_id }}">
                                            <div class="ps-3 text-wrap">
                                                <div class="text-base font-semibold uppercase">
                                                    {{ $data->employee->fname }} {{ $data->employee->mname }}
                                                    {{ $data->employee->lname }}
                                                </div>
                                                <div class="text-sm font-normal text-gray-500 uppercase">
                                                    {{ $data->employee->address }},
                                                    {{ $data->employee->barangay->barangay_Name }},
                                                    {{ $data->employee->barangay->municipality->municipality_Name }}
                                                </div>
                                                <!-- Show Job Title on mobile view -->
                                                <div class="text-sm font-normal text-gray-500 uppercase lg:hidden">
                                                    Job: <span
                                                        class="font-bold text-blue-500 text-md">{{ $data->job_posting->job_Title }}</span>
                                                </div>
                                                <!-- Show Date on mobile view -->
                                                <div class="text-xs text-gray-500 lg:hidden">
                                                    Applied: {{ $data->created_at->format('F j, Y') }}
                                                </div>
                                            </div>
                                        </th>
                                        <!-- Hide Job Title and Date on mobile view -->
                                        <td class="hidden px-6 py-4 lg:table-cell">
                                            <div class="text-sm font-normal text-gray-500 uppercase">
                                                <span
                                                    class="font-bold text-blue-500 text-md">{{ $data->job_posting->job_Title }}</span>
                                            </div>
                                        </td>
                                        <td class="hidden px-6 py-4 lg:table-cell">
                                            {{ $data->created_at->format('F j, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div x-data="{ tooltip: 'Applicant Overview' }">
                                                <a wire:navigate
                                                    href="{{ route('admin.jobpost.applicants.overview', ['id' => $data->applicant_id]) }}"
                                                    x-tooltip="tooltip" type="button"
                                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor">
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
        </div>




        <div class="col-span-4 lg:col-span-6">
            <div class="items-center w-full h-full p-6 bg-white rounded-lg shadow">
                <h1 class="text-2xl font-bold">Top Job Industries</h1>
                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                <div class="flex items-end h-full">
                    <livewire:livewire-pie-chart {{-- key="{{ $columnChartModel->reactiveKey() }}" --}} :pie-chart-model="$pieChartModel">
                </div>
            </div>

        </div>



    </div>
</div>
