<x-app-layout>
    <div class="container mx-auto py-8">

        <div class="grid grid-cols-4 sm:grid-cols-12 gap-4 p-3 sm:p-0">



            <div class="col-span-4 sm:col-span-12">

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">


                    <div class="flex flex-row w-full h-full ">
                        <div class="flex flex-row justify-center items-center h-full p-5 flex-shrink-0">
                            <img src="{{ asset('storage/' . $JobPost->company->company_img) }}" alt="Default I mage"
                                class="w-36 h-36    sm:w-48 sm:h-48 bg-gray-300 rounded object-contain">
                        </div>
                        <div class="flex flex-col w-full h-full sm:ml-5 py-5 sm:mt-5">

                            <div class="flex flex-row">
                                <h1 class=" text-4xl text-blue-500 sm:text-6xl font-bold">{{ $JobPost->job_Title }}
                                </h1>
                            </div>

                            <div class="flex-row sm:mt-5">
                                <h2 class="text-md sm:text-3xl font-semibold">{{ $JobPost->company->business_Name }}
                                </h2>
                            </div>


                            <div class="flex flex-col sm:flex-row sm:space-x-4  sm:mt-8">
                                <div class="">
                                    <h3 class="text-xs sm:text-lg text-blue-900"> <i
                                            class="fa-solid fa-location-dot"></i>
                                        {{ $JobPost->barangay->municipality->municipality_Name }},
                                        {{ $JobPost->barangay->municipality->province->province_Name }}
                                    </h3>
                                </div>

                                <div class="hidden md:flex items-center justify-center">
                                    <i class="fa-solid fa-circle text-xs" style="font-size: 0.4rem;"></i>
                                </div>

                                <div class="">
                                    <h3 class="text-xs sm:text-lg text-blue-900"> <i
                                            class="fa-solid fa-graduation-cap"></i>
                                        {{ $eduLevels[$JobPost->job_Edu] }}
                                    </h3>
                                </div>
                                <div class="hidden sm:flex items-center justify-center">
                                    <i class="fa-solid fa-circle text-xs" style="font-size: 0.4rem;"></i>
                                </div>

                                <div class="">
                                    <h3 class="text-xs sm:text-lg text-blue-900"> <i class="fa-solid fa-briefcase"></i>
                                        @if ($JobPost->job_Type == 1)
                                            Full Time
                                        @elseif ($JobPost->job_Type == 2)
                                            Part Time
                                        @endif
                                    </h3>
                                </div>

                                <div class="hidden sm:flex items-center justify-center">
                                    <i class="fa-solid fa-circle text-xs" style="font-size: 0.4rem;"></i>
                                </div>

                                <div class="">
                                    <h3 class="text-xs sm:text-lg text-blue-900"> <i class="fa-solid fa-calendar"></i>
                                        {{ $JobPost->created_at->format('F j, Y') }}
                                    </h3>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>






            <div class="col-span-4 sm:col-span-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="flex flex-col w-full h-full p-5 space-y-2">

                        <div class="Job-Description">
                            <div class="flex flex-row w-full">
                                <h1 class="text-xl text-blue-900 font-bold">Job Description</h1>
                            </div>
                            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700 mt-2">

                            <div class="p-2 no-tailwindcss-base">
                                {{ $JobPost->job_Description }}

                            </div>
                        </div>

                        <div class="Job-Qualification">

                            <h1 class="text-xl text-blue-900 font-bold">Job Qualification</h1>


                            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700 mt-2">

                            <div class="p-2 no-tailwindcss-base">
                                {{ $JobPost->job_Qualifications }}
                            </div>
                        </div>

                        <div class="Job-Remarks">

                            <h1 class="text-xl text-blue-900 font-bold">Job Remarks</h1>


                            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700 mt-2">

                            <div class="p-2 no-tailwindcss-base">
                                {{ $JobPost->job_Remarks }}

                            </div>
                        </div>

                    </div>
                </div>




                {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex flex-col w-full h-full p-5">


                        <div class="About-Company">

                            <h1 class="text-xl text-blue-900 font-bold">About National University Baliwag</h1>


                            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700 mt-2">

                            <div class="mt-2">
                                National University (NU) Baliwag is a distinguished institution of higher education
                                situated
                                in Baliwag, Bulacan, Philippines. Committed to academic excellence, innovation, and
                                social
                                responsibility, NU Baliwag aims to empower minds and transform lives through quality
                                education and holistic development.

                            </div>
                        </div>

                    </div>
                </div> --}}
            </div>


            <div class="col-span-4 sm:col-span-4">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4">
                    <div class="flex flex-col w-full">

                        @if (auth()->user()->usertype >= 5)

                            @if ($JobPost->job_Status == 'PENDING')
                                <div class="bg-yellow-100 shadow rounded-lg p-6">
                                    <div class="flex flex-row items-center justify-between">
                                        <p class="text-yellow-700 font-bold text-xl">Application is Pending</p>
                                    </div>
                                </div>
                            @elseif($JobPost->job_Status == 'REJECTED')
                                <div class="bg-red-100 shadow rounded-lg p-6">
                                    <div class="flex flex-row items-center justify-between">
                                        <p class="text-red-700 font-bold text-xl">Application is Rejected</p>
                                    </div>
                                </div>


                                <div class="flex flex-col w-full mt-4">
                                    <x-input-label for="fname"> </i> PESO Remarks
                                    </x-input-label>
                                    <textarea id="message" rows="4" readonly
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="PESO Remarks">{{ $JobPost->peso_Remarks }}</textarea>
                                </div>
                            @endif

                            @if (auth()->user()->usertype >= 8 && auth()->user()->peso->municipality_id == $JobPost->peso_municipality_id)
                                <div class="flex flex-row items-center justify-center mt-2">
                                    <a href="{{ route('admin.jobpost.applicants', ['id' => $JobPost->job_id]) }}">
                                        <x-primary-button class="w-[350px] h-[40px] justify-center">

                                            View Job Applicants

                                        </x-primary-button>
                                    </a>
                                </div>
                            @endif
                            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700 mt-4">
                        @endif

                        @if (auth()->user()->usertype >= 4 && auth()->user()->usertype < 5)
                            <div class="flex flex-row w-full items-center justify-center mt-2">
                                <h1>Applicantion ends: <span
                                        class="text-red-500 text-md font-black">{{ $JobPost->job_Duration->format('F j, Y') }}</span>
                                </h1>
                            </div>
                            <div class="flex flex-row items-center justify-center mt-2">
                                <x-primary-button class="w-[350px] h-[40px] justify-center">
                                    Apply
                                </x-primary-button>
                            </div>

                            <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700 mt-4">
                        @endif
                        <div class="flex flex-col w-full px-5 mt-5">

                            <ul>
                                <li class="mb-4">
                                    <div class="flex flex-row gap-4 w-full">
                                        <div class="flex flex-col">
                                            <svg class="w-10 h-10 text-blue-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                                            </svg>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <div class="text-xl font-bold text-black">
                                                Date Posted
                                            </div>
                                            <div class="text-md font-medium">
                                                {{ $JobPost->created_at->format('F j, Y') }}
                                            </div>


                                        </div>
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <div class="flex flex-row gap-4 w-full">
                                        <div class="flex flex-col">
                                            <svg class="w-10 h-10 text-blue-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z" />
                                            </svg>

                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <div class="text-xl font-bold text-black">
                                                Location
                                            </div>
                                            <div class="text-md font-medium">
                                                {{ $JobPost->barangay->municipality->municipality_Name }},
                                                {{ $JobPost->barangay->municipality->province->province_Name }}
                                            </div>


                                        </div>
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <div class="flex flex-row gap-4 w-full">
                                        <div class="flex flex-col">
                                            <svg class="w-10 h-10 text-blue-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                    d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                            </svg>

                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <div class="text-xl font-bold text-black">
                                                Salary Range
                                            </div>
                                            <div class="text-md font-medium">
                                                ₱{{ number_format($JobPost->job_MinWage) }} -
                                                ₱{{ number_format($JobPost->job_MaxWage) }}

                                            </div>

                                        </div>
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <div class="flex flex-row gap-4 w-full">
                                        <div class="flex flex-col">
                                            <svg class="w-10 h-10 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                            </svg>

                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <div class="text-xl font-bold text-black">
                                                Education Level
                                            </div>
                                            <div class="text-md font-medium">
                                                {{ $eduLevels[$JobPost->job_Edu] }}
                                                {{-- @if ($JobPost->job_Edu == 1)
                                                    Highschool Graduate
                                                @elseif ($JobPost->job_Edu == 2)
                                                    Master's Graduate
                                                @endif --}}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <div class="flex flex-row gap-4 w-full">
                                        <div class="flex flex-col">
                                            <svg class="w-10 h-10 text-blue-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7H5a2 2 0 0 0-2 2v4m5-6h8M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m0 0h3a2 2 0 0 1 2 2v4m0 0v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6m18 0s-4 2-9 2-9-2-9-2m9-2h.01" />
                                            </svg>

                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <div class="text-xl font-bold text-black">
                                                Job Type
                                            </div>

                                            <div class="text-md font-medium ">
                                                @if ($JobPost->job_Type == 1)
                                                    Full Time
                                                @elseif ($JobPost->job_Type == 2)
                                                    Part Time
                                                @endif
                                            </div>

                                        </div>
                                </li>
                                <li class="mb-4">
                                    <div class="flex flex-row gap-4 w-full">
                                        <div class="flex flex-col">
                                            <svg class="w-10 h-10 text-blue-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M6 4h12M6 4v16M6 4H5m13 0v16m0-16h1m-1 16H6m12 0h1M6 20H5M9 7h1v1H9V7Zm5 0h1v1h-1V7Zm-5 4h1v1H9v-1Zm5 0h1v1h-1v-1Zm-3 4h2a1 1 0 0 1 1 1v4h-4v-4a1 1 0 0 1 1-1Z" />
                                            </svg>

                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <div class="text-xl font-bold text-black">
                                                Industry
                                            </div>
                                            <div class="text-md font-medium">
                                                {{ $JobPost->industry->industry_Title }}
                                            </div>


                                        </div>
                                    </div>
                                </li>


                            </ul>
                        </div>

                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 mt-4">
                    <div class="flex flex-row w-full">
                        <h1 class="text-xl text-blue-900 font-bold">Job Tags</h1>
                    </div>
                    <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700 mt-2">

                    <div class="flex-inline  rounded-lg p-1 mt-2 ">
                        @foreach ($JobPost->job_tags as $jobTag)
                            <span
                                class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $jobTag->job_positions->position_Title }}
                            </span>
                        @endforeach


                    </div>

                </div>
            </div>




        </div>


    </div>


    {{-- <div class="mobile-apply md:hidden mt-3">
            <div class="col-span-4 sm:col-span-12">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="flex flex-col w-full h-full p-5">
                        <div class="flex flex-row space-x-2 ">
                            <div class="flex items-center justify-center ">
                                <i class="fa-solid fa-circle text-xs" style="font-size: 0.4rem;"></i>
                            </div>
                            <div class="w-1/2 justify-">
                                <h3 class="text-md "> <i class="fa-solid fa-location-dot"></i>
                                    Baliuag, Bulacan
                                </h3>
                            </div>

                            <div class="flex items-center justify-center">
                                <i class="fa-solid fa-circle text-xs" style="font-size: 0.4rem;"></i>
                            </div>

                            <div class="w-1/2">
                                <h3 class="text-md "> <i class="fa-solid fa-graduation-cap"></i>
                                    Master's
                                    Graduate</h3>
                            </div>
                        </div>
                        <div class="flex flex-row space-x-2">


                            <div class="flex items-center justify-center">
                                <i class="fa-solid fa-circle text-xs" style="font-size: 0.4rem;"></i>
                            </div>

                            <div class="w-1/2">
                                <h3 class="text-md "> <i class="fa-solid fa-briefcase"></i>
                                    Full Time
                                </h3>
                            </div>

                            <div class="flex items-center justify-center">
                                <i class="fa-solid fa-circle text-xs" style="font-size: 0.4rem;"></i>
                            </div>

                            <div class="w-1/2">
                                <h3 class="text-md"><i class="fa-solid fa-money-bill"></i>
                                    ₱50,000 - ₱70,000
                                </h3>
                            </div>

                        </div>

                        <div class="flex flex-col ml-auto mr-10 justify-center w-full mt-3 items-center md:hidden">
                            <button type="button"
                                class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-10 border border-red-500 hover:border-transparent rounded "
                                onclick="">
                                Apply Now
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div> --}}


</x-app-layout>
