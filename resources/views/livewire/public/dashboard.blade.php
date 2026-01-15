<div class="w-full">

    @if (Auth::check() && (Auth::user()->usertype == 5 || !$activePartnership))
        <div class="p-6 mx-12 my-6 bg-yellow-100 rounded-lg shadow">
            <div class="flex flex-row items-center justify-between">
                <p class="text-xl font-bold text-yellow-700">
                    Access to job post applications is restricted. Please ensure your company has an active
                    partnership to access job posting.
                </p>
                <div x-data="{ tooltip: 'View company settings to review current partnerships status.' }">
                    <svg x-tooltip="tooltip" class="w-9 h-9 lg:w-9 lg:h-9 text-yellow-700 me-2.5 hover:scale-110"
                        viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 0 1-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 0 1-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 0 1-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    @else
        <div class="flex flex-row justify-between py-2 mx-auto mt-4 lg:mx-12">
            <div>
                @if (Auth::check() && Auth::user()->usertype == 4)
                    <h1 class="text-lg font-semibod lg:text-2xl">Recommended Trainings</h1>
                @else
                    <h1 class="text-lg font-semibold lg:text-2xl">Available Trainings</h1>
                @endif
            </div>
            <div class="flex items-end">
                <a wire:navigate href="{{ route('trainings') }}"
                    class="text-sm font-semibold lg:text-md hover:text-blue-400">View more</a>
            </div>

        </div>
        <hr class="h-1 mx-auto bg-gray-200 border-0 lg:mx-12">

        @if ($programList->isEmpty())
            <div class="flex justify-center w-full mx-4">
                <div class="flex flex-col items-center justify-center mt-4 mb-4">
                    <div class="p-6 my-2 transition-transform transform bg-white rounded-full hover:scale-110">
                        <svg class="text-black w-36 h-36" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                        </svg>


                    </div>
                    <p class="mt-2 text-xl font-bold text-center text-black">
                        No New Program!
                    </p>
                </div>
            </div>
        @else
            <div class="overflow-x-auto no-scrollbar">
                <div class="flex gap-6 py-4 mx-4 flex-nowrap lg:mx-12">

                    @foreach ($programList as $data)
                        <a wire:navigate href="{{ route('training.show', ['id' => $data->program_id]) }}"
                            class="flex flex-col w-full overflow-hidden  duration-300 bg-white border border-gray-200 rounded-lg shadow-lg shrink-0 lg:flex-row lg:max-w-xl lg:max-h-72 hover:shadow-xl transition-transform ease-in-out hover:scale-[1.02]">
                            <img class="object-cover w-full h-48 select-none lg:w-60 lg:h-full "
                                src="{{ $data->program_pubmat && file_exists(public_path('storage/' . $data->program_pubmat)) ? asset('storage/' . $data->program_pubmat) : asset('assets/img/PESO-Logo.png') }}"
                                alt="prog-{{ $data->program_id }}">


                            <div class="flex flex-col justify-between flex-1 p-4 lg:p-4">
                                <h5 class="text-xl font-bold leading-snug tracking-tight text-blue-500 lg:text-2xl">
                                    {{ $data->program_Title }}
                                </h5>
                                <hr class="mb-2">

                                <div class="flex items-center mb-2 text-sm font-medium text-gray-900">
                                    <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <p class="truncate ...">{{ $data->program_Deadline->format('F j, Y') }}</p>
                                </div>

                                <p class="flex-grow mb-4 text-sm font-normal leading-relaxed text-gray-700">
                                    {!! Str::limit(strip_tags($data->program_Description), 90, '...') !!}
                                </p>

                                <p class="text-sm font-medium text-gray-900">
                                    PESO {{ $data->peso->municipality->municipality_Name }}
                                </p>
                            </div>
                        </a>
                    @endforeach

                </div>
            </div>
        @endif
    @endif

    <div wire:poll.5s class="flex py-2 mx-auto lg:mx-12 ">
        <div class="grid w-full grid-cols-4 gap-10 p-3 lg:grid-cols-12 lg:p-0">

            {{-- MAIN BAR FOR JOB POST --}}
            <div class="col-span-4 lg:col-span-9">
                <div class="p-6 overflow-visible bg-white rounded-lg shadow">
                    <div class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">

                        <label for="table-search" class="sr-only">Search</label>

                        <div class="relative w-full lg:w-auto">

                            <div
                                class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            {{-- SEARCH --}}
                            <input wire:model.live='search' type="search" id="table-search-users"
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search for job posting">
                        </div>

                        {{-- FILTER BUTTON --}}
                        <div class="flex flex-wrap gap-2 mr-3">
                            <!-- In your Blade template -->
                            <button type="button" x-data="{ filterIndustry: @entangle('filterIndustry') }"
                                x-on:click.prevent="$dispatch('open-modal', 'industry-filter-modal')"
                                :class="filterIndustry.length > 0 ?
                                    'bg-blue-500 text-white hover:bg-blue-600' :
                                    'bg-white text-gray-500 hover:bg-gray-100'"
                                class="inline-flex max-h-fit items-center border border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                Industry Filter
                            </button>
                            <button type="button" x-data="{ filterJobTags: @entangle('filterJobTags') }"
                                x-on:click.prevent="$dispatch('open-modal', 'job-tag-filter-modal')"
                                :class="filterJobTags.length > 0 ?
                                    'bg-blue-500 text-white hover:bg-blue-600' :
                                    'bg-white text-gray-500 hover:bg-gray-100'"
                                class="inline-flex max-h-fit items-center border border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                Job Tags Filter
                            </button>



                            <x-dropdown align="left" width="36">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                        <div>
                                            {{ $jobTypeFilter ? $jobTypes[$jobTypeFilter] : 'Employment Type' }}
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
                                    <x-slot name="contentClasses">
                                        max-h-[300px] bg-white
                                    </x-slot>

                                    <x-dropdown-link wire:click.prevent="updateJobType('')" class="cursor-pointer">
                                        All
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="updateJobType(1)" class="cursor-pointer">
                                        Full Time
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="updateJobType(2)" class="cursor-pointer">
                                        Contractual
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="updateJobType(3)" class="cursor-pointer">
                                        Part Time
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="updateJobType(4)" class="cursor-pointer">
                                        Project-Based
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="updateJobType(5)" class="cursor-pointer">
                                        Internship/OJT
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="updateJobType(6)" class="cursor-pointer">
                                        Work From Home
                                    </x-dropdown-link>


                                </x-slot>
                            </x-dropdown>

                            @if (Auth::check() && auth()->user()->usertype != 5)
                                <x-dropdown align="left" width="36">
                                    <x-slot name="trigger">
                                        <button
                                            class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                            <div>
                                                {{ $filter }}
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
                                        <x-slot name="contentClasses">
                                            max-h-[300px] bg-white
                                        </x-slot>

                                        @if (auth()->user()->usertype == 4)
                                            <x-dropdown-link wire:click.prevent="updateFilter('Recommended')"
                                                class="cursor-pointer">
                                                Recommended
                                            </x-dropdown-link>
                                        @endif

                                        @if (auth()->user()->usertype == 4 || (auth()->user()->usertype >= 8 && auth()->user()->usertype < 11))
                                            <x-dropdown-link wire:click.prevent="updateFilter('My Municipality')"
                                                class="cursor-pointer">
                                                My Municipality
                                            </x-dropdown-link>
                                        @endif
                                        <x-dropdown-link wire:click.prevent="updateFilter('All')"
                                            class="cursor-pointer">
                                            All
                                        </x-dropdown-link>


                                    </x-slot>
                                </x-dropdown>
                            @endif

                            <x-dropdown align="left" width="36">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                        <div>
                                            {{ $sort }}
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
                                    <x-slot name="contentClasses">
                                        max-h-[300px] bg-white
                                    </x-slot>

                                    <x-dropdown-link wire:click.prevent="updateSort('Newest')" class="cursor-pointer">
                                        Newest
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click.prevent="updateSort('Oldest')" class="cursor-pointer">
                                        Oldest
                                    </x-dropdown-link>
                                    {{-- @if ($filter != 'Recommended')
                                        <x-dropdown-link wire:click.prevent="updateSort('Random')"
                                            class="cursor-pointer">
                                            Random
                                        </x-dropdown-link>
                                    @endif --}}


                                </x-slot>
                            </x-dropdown>


                        </div>


                    </div>
                    <table class="w-full overflow-auto">

                        <tbody>
                            @if ($joblist->isEmpty())
                                <tr>
                                    <td colspan="5">
                                        <div class="flex flex-col items-center justify-center mt-10 mb-10">
                                            <div class="p-6 bg-gray-100 rounded-full">
                                                <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-width="2"
                                                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                </svg>

                                            </div>
                                            <p class="mt-2 text-xl font-bold text-center text-black">
                                                No Job Posting Found!
                                            </p>
                                        </div>

                                    </td>
                                </tr>
                            @else
                                @foreach ($joblist as $data)
                                    <tr wire:key='jobPosting-{{ $data->job_id }}'
                                        class="text-center hover:bg-gray-100 ">

                                        <td class="p-2 rounded-lg">

                                            <a wire:navigate
                                                href="{{ route('jobpost.show', ['id' => $data->job_id]) }}">
                                                <div class="flex flex-row w-full">
                                                    <div
                                                        class="flex flex-col items-center justify-center flex-shrink-0 h-full">
                                                        <img src="{{ file_exists(public_path('storage/' . $data->company->company_img)) ? asset('storage/' . $data->company->company_img) : asset('assets/img/PESO-Logo.png') }}"
                                                            alt="company-{{ $data->job_id }}"
                                                            class="object-contain w-24 h-24 bg-gray-300 rounded select-none lg:w-48 lg:h-48">
                                                    </div>
                                                    <div class="flex-col w-full ml-5 space-y-1 lg:space-y-8">
                                                        <div class="flex flex-col">
                                                            <div class="flex flex-col text-left lg:flex-row">
                                                                <div class="flex flex-col lg:w-3/4">
                                                                    <h1
                                                                        class="text-2xl font-semibold text-blue-500 uppercase lg:text-5xl">
                                                                        {{ $data->job_Title }}
                                                                    </h1>
                                                                </div>
                                                                <div class="flex-col hidden lg:flex lg:w-1/4">
                                                                    <h1
                                                                        class="text-xs font-medium text-left text-blue-500 lg:text-xl lg:text-center">
                                                                        @if ($data->job_MinWage)
                                                                            ₱{{ number_format($data->job_MinWage) }}
                                                                            @if ($data->job_MaxWage)
                                                                                -
                                                                                ₱{{ number_format($data->job_MaxWage) }}
                                                                            @endif
                                                                        @else
                                                                            Salary Not Specified
                                                                        @endif
                                                                    </h1>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="flex flex-col">
                                                            <div class="flex-row text-left lg:w-3/4">
                                                                <h2 class="text-lg font-semibold lg:text-2xl">
                                                                    {{ $data->company->business_Name }}</h2>
                                                            </div>
                                                            <h1
                                                                class="text-sm font-medium text-left text-black lg:hidden lg:text-center">
                                                                ₱{{ number_format($data->job_MinWage) }} -
                                                                ₱{{ number_format($data->job_MaxWage) }}</h1>
                                                        </div>

                                                        <div class="flex flex-col w-full">
                                                            <div class="flex flex-col lg:flex-row">
                                                                <div class="text-left lg:w-1/5">

                                                                    <h3
                                                                        class="text-xs text-blue-900 uppercase lg:text-sm">
                                                                        <i class="fa-solid fa-location-dot"></i>
                                                                        {{ $data->job_Address }},
                                                                        {{ $data->barangay->barangay_Name }},
                                                                        {{ $data->barangay->municipality->municipality_Name }},
                                                                        {{ $data->barangay->municipality->province->province_Name }}
                                                                    </h3>
                                                                </div>
                                                                <div class="text-left lg:w-1/5 lg:text-center">
                                                                    <h3
                                                                        class="text-xs text-blue-900 uppercase lg:text-sm">
                                                                        <i class="fa-solid fa-graduation-cap"></i>
                                                                        {{ $eduLevels[$data->job_Edu] }}
                                                                    </h3>
                                                                </div>
                                                                <div class="text-left lg:w-1/5 lg:text-center">
                                                                    <h3
                                                                        class="text-xs text-blue-900 uppercase lg:text-sm">
                                                                        <i class="uppercase fa-solid fa-briefcase"></i>
                                                                        {{ $jobTypes[$data->job_Type] }}

                                                                    </h3>
                                                                </div>
                                                                <div class="text-left lg:w-1/5 lg:text-center">
                                                                    <h3
                                                                        class="text-xs text-blue-900 uppercase lg:text-sm">
                                                                        <i class="fa-solid fa-calendar"></i>
                                                                        {{ $data->job_Duration->format('F j, Y') }}
                                                                    </h3>
                                                                </div>
                                                                <div class="text-left lg:w-1/5 lg:text-center">
                                                                    <h3
                                                                        class="text-xs text-blue-900 uppercase lg:text-sm">
                                                                        <i class="fa-solid fa-building-ngo"></i>
                                                                        PESO
                                                                        {{ $data->peso->municipality->municipality_Name }}
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <hr class="h-px mt-3 bg-gray-200 border-0">
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{-- PAGINATION --}}
                    <div>
                        {{ $joblist->links('vendor.livewire.tailwind', data: ['scrollTo' => false]) }}
                    </div>


                </div>
            </div>



            {{-- SIDE BAR --}}
            @if (Auth::check() && (auth()->user()->usertype == 5 || auth()->user()->usertype == 6))
                <div class="col-span-4 lg:col-span-3">
                    <div class="p-4 bg-white rounded-lg shadow">
                        <div class="w-full p-3 text-center text-gray-900">
                            <h1 class="text-2xl font-bold">Notifications</h1>
                            <div class="overflow-y-auto max-h-[300px] lg:max-h-[900px]"> <!-- Set max height here -->
                                @if (empty($formattedNotifications))
                                    <div class="flex flex-col items-center justify-center mt-12 mb-12">
                                        <div class="p-6 bg-gray-100 rounded-full">
                                            <svg class="w-24 h-24 text-black" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                            </svg>

                                        </div>
                                        <p class="mt-2 text-xl font-bold text-center text-black">
                                            No Notification Found!
                                        </p>
                                    </div>
                                @else
                                    <ul class="mt-5 space-y-3">
                                        @foreach ($formattedNotifications as $notification)
                                            <li>
                                                <div class="flex items-start space-x-4">
                                                    <span class="flex-shrink-0">
                                                        @if ($notification['type'] === 'partnership')
                                                            @if ($notification['status'] === 'APPROVED')
                                                                <div
                                                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-green-700 bg-green-100 border border-green-700 rounded-lg focus:outline-none">
                                                                    <svg class="w-5 h-5"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>

                                                                </div>
                                                            @elseif ($notification['status'] === 'CANCELLED' || $notification['status'] === 'REJECTED')
                                                                <div
                                                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-red-700 bg-red-100 border border-red-700 rounded-lg focus:outline-none">
                                                                    <svg class="w-5 h-5"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>


                                                                </div>
                                                            @endif
                                                        @else
                                                            <div
                                                                class="text-{{ $notification['type'] === 'applicant' ? 'blue' : 'green' }}-700 border border-{{ $notification['type'] === 'applicant' ? 'blue' : 'green' }}-700 bg-{{ $notification['type'] === 'applicant' ? 'blue' : 'green' }}-100 focus:outline-none font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="{{ $notification['type'] === 'applicant' ? 'M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75' : 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z' }}" />
                                                                </svg>
                                                            </div>
                                                        @endif

                                                    </span>
                                                    <div class="flex flex-col">
                                                        <span class="flex-1">
                                                            <div class="font-medium text-left text-md">
                                                                {{ $notification['message'] }}
                                                            </div>
                                                        </span>
                                                        <span
                                                            class="text-xs text-left text-grey-400">{{ \Carbon\Carbon::parse($notification['responded_at'])->format('F j, Y g:i A') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            @else
                <div class="col-span-4 lg:col-span-3">
                    <div class="flex flex-col w-full gap-4">
                        @if ($topJobTags->isNotEmpty() || $topJobIndustries->isNotEmpty())
                            <div class="p-4 bg-white rounded-md shadow-md">
                                @if ($topJobTags->isNotEmpty())
                                    <h1 class="mb-4 text-2xl font-bold text-center">TOP JOB TAGS</h1>
                                    <ul>
                                        @foreach ($topJobTags as $index => $jobTag)
                                            <li
                                                class="flex items-center justify-between py-2 border-b border-gray-300">
                                                <div class="flex items-center">
                                                    <span
                                                        class="mr-4 text-lg font-semibold">{{ $index + 1 }}</span>
                                                    <span
                                                        wire:click.prevent="mountTopJobTags('{{ $jobTag->position_Title }}')"
                                                        class="font-semibold text-gray-800 break-all cursor-pointer hover:text-blue-500"
                                                        style="max-width: 200px;">
                                                        {{ $jobTag->position_Title }}
                                                    </span>
                                                </div>
                                                <span
                                                    class="ml-4 font-semibold text-green-500">{{ $jobTag->active_job_posting_count }}
                                                    Active Jobs</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if ($topJobIndustries->isNotEmpty())
                                    <h1 class="mt-4 mb-4 text-2xl font-bold text-center">TOP JOB INDUSTRY</h1>
                                    <ul>
                                        @foreach ($topJobIndustries as $index => $jobTag)
                                            <li
                                                class="flex items-center justify-between py-2 border-b border-gray-300">
                                                <div class="flex items-center">
                                                    <span
                                                        class="mr-4 text-lg font-semibold">{{ $index + 1 }}</span>
                                                    <span
                                                        wire:click.prevent="mountTopJobTags('{{ $jobTag->industry_Title }}')"
                                                        class="font-semibold text-gray-800 break-all cursor-pointer hover:text-blue-500"
                                                        style="max-width: 200px;">
                                                        {{ $jobTag->industry_Title }}
                                                    </span>
                                                </div>
                                                <span
                                                    class="ml-4 font-semibold text-green-500">{{ $jobTag->active_job_posting_count }}
                                                    Active Jobs</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif



                        <div class="w-full text-center text-gray-900">
                            <h1 class="text-2xl font-bold">ANNOUNCEMENTS</h1>
                            <div class = "flex flex-col items-center justify-center mt-4">
                                @if ($announcements->isEmpty())
                                    <div class="flex flex-col items-center justify-center mt-12 mb-12">
                                        <div
                                            class="p-6 my-12 transition-transform transform bg-white rounded-full hover:scale-110">
                                            <svg class="text-black w-36 h-36" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                                            </svg>


                                        </div>
                                        <p class="mt-2 text-xl font-bold text-center text-black">
                                            No New Announcements!
                                        </p>
                                    </div>
                                @else
                                    <div
                                        class="flex flex-row w-full gap-4 mt-2 overflow-x-auto lg:flex-col lg:overflow-visible text-center no-scrollbar ">
                                        @foreach ($announcements as $data)
                                            <a wire:navigate
                                                href="{{ route('announcement.show', ['id' => $data->announcement_id]) }}"
                                                class="flex-shrink-0 w-full lg:w-full">
                                                <div
                                                    class="relative flex flex-col w-full max-w-sm lg:max-w-full overflow-hidden text-gray-700 transition-transform transform bg-white rounded-lg shadow-md h-96 hover:scale-105 hover:shadow-lg">
                                                    <div class="relative w-full h-56 overflow-hidden rounded-t-lg">
                                                        <img src="{{ file_exists(public_path('storage/' . $data->announcement_pubmat)) ? asset('storage/' . $data->announcement_pubmat) : asset('assets/img/PESO-Logo.png') }}"
                                                            alt="announcement-{{ $data->announcement_id }}"
                                                            class="object-cover w-full h-full transition-transform duration-300 ease-in-out rounded-t-lg select-none hover:scale-110" />


                                                    </div>
                                                    <div class="flex flex-col flex-grow p-4">
                                                        <h4
                                                            class="mb-2 text-lg font-semibold transition-colors duration-300 ease-in-out text-blue-gray-900 hover:text-blue-700">
                                                            {{ Str::limit(strip_tags($data->announcement_Title), 80, '...') }}
                                                        </h4>
                                                        <div
                                                            class="flex items-end justify-between mt-auto text-xs font-normal text-gray-600">
                                                            <p class="truncate">PESO
                                                                {{ $data->peso->municipality->municipality_Name }}
                                                            </p>
                                                            <p class="truncate">
                                                                {{ $data->created_at->format('F j, Y') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


            @endif


        </div>

    </div>

    {{-- <div id="sticky-banner" tabindex="-1"
        class="fixed bottom-0 z-50 flex justify-between w-full p-4 bg-blue-500 border-b border-gray-200 start-0 lg:p-8">
        <div class="flex items-center mx-auto">
            <p class="flex items-center text-sm font-bold text-justify text-white lg:text-xl">

                </span>
                <span class="font-bold uppercase">Please note: The system is currently in a testing phase. Postings are
                    for testing purposes only and do not reflect actual opportunities.</span>
            </p>
        </div>
        <div class="flex items-center ml-4">
            <button data-dismiss-target="#sticky-banner" type="button"
                class="flex-shrink-0 inline-flex justify-center w-7 h-7 items-center text-black hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm p-1.5">
                <svg class="w-10 h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close banner</span>
            </button>
        </div>
    </div> --}}

    <x-modal name="industry-filter-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Filter Industry') }}
            </h2>
            <hr>

            <div class="relative mt-4">
                <div class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">

                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>


                        <input wire:model.live='searchIndustry' type="search"
                            class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search industry">
                    </div>


                </div>


                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-center text-gray-500 rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                            <tr>
                                <th scope="col" class="w-1/4 px-6 py-3"> <!-- Hidden on small screens -->
                                </th>
                                <th scope="col" class="px-6 py-3 uppercase">Job Industry</th>
                                <th scope="col" class="hidden px-6 py-3 uppercase sm:table-cell">Code</th>
                                <!-- Hidden on small screens -->
                            </tr>
                        </thead>
                        <tbody>
                            @if ($industry->isEmpty())
                                <tr>
                                    <td colspan="3">
                                        <div class="flex flex-col items-center justify-center mt-24 mb-24">
                                            <div class="p-6 bg-gray-100 rounded-full">
                                                <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-width="2"
                                                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                </svg>
                                            </div>
                                            <p class="mt-2 text-xl font-bold text-center text-black">No Record Found!
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($industry as $data)
                                    <tr wire:key='industry-{{ $data->industry_id }}'
                                        class="bg-white border-b cursor-pointer hover:bg-gray-50"
                                        onclick="document.getElementById('industry-{{ $data->industry_id }}').click();">
                                        <td class="px-6 py-4 text-center">
                                            <!-- Hidden on small screens -->

                                            <input wire:model="mountIndustryFilter" type="checkbox"
                                                id="industry-{{ $data->industry_id }}"
                                                value="{{ $data->industry_id }}"
                                                onclick="document.getElementById('industry-{{ $data->industry_id }}').click();"
                                                class="w-5 h-5 transition-all border rounded-md appearance-none cursor-pointer border-blue-gray-200 checked:border-blue-900 checked:bg-blue-600" />
                                            <span
                                                class="absolute text-white transform opacity-0 top-2/4 left-2/4 -translate-x-2/4 -translate-y-2/4 peer-checked:opacity-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                    viewBox="0 0 20 20" fill="currentColor" stroke="currentColor"
                                                    stroke-width="1">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                            </label>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-base font-semibold uppercase">{{ $data->industry_Title }}
                                            </div>
                                            <!-- Additional information for mobile view -->
                                            <div class="text-sm text-gray-500 sm:hidden">Code:
                                                {{ $data->industry_Code }}</div>
                                        </td>
                                        <td class="hidden px-4 py-2 sm:table-cell"> <!-- Hidden on small screens -->
                                            <div class="text-base font-semibold uppercase">{{ $data->industry_Code }}
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
            <div class="mt-4">
                {{ $industry->links('vendor.livewire.tailwind', data: ['scrollTo' => false]) }}
            </div>


            <div class="flex justify-between mt-6">
                <x-secondary-button type="button" x-data=""
                    x-on:click="$dispatch('close-modal', 'industry-filter-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <div>
                    <x-danger-button wire:click.prevent="resetIndustry">
                        {{ __('Reset') }}
                    </x-danger-button>
                    <x-primary-button wire:loading.attr="disabled" wire:click.prevent="mountIndustry" class="ms-3"
                        type="button">
                        {{ __('Confirm') }}
                        <div wire:loading.delay.long wire:target="mountIndustry" role="status">
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
                    </x-primary-button>
                </div>


            </div>
        </div>

    </x-modal>

    <x-modal name="job-tag-filter-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Filter Job Tags') }}
            </h2>
            <hr>

            <div class="relative mt-4">
                <div class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>

                        <input type="search" wire:model.live='searchTags'
                            class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search Job Position">
                    </div>


                </div>
                <div class="overflow-x-auto ">

                    <table class="w-full text-sm text-center text-gray-500 rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                            <tr>
                                <th scope="col" class="w-1/4 px-6 py-3"></th> <!-- Hidden on small screens -->
                                <th scope="col" class="px-6 py-3 uppercase">Job Position</th>
                                <th scope="col" class="hidden px-6 py-3 uppercase md:table-cell">Code</th>
                                <!-- Hidden on smaller than md screens -->
                            </tr>
                        </thead>
                        <tbody>
                            @if ($jobposition->isEmpty())
                                <tr>
                                    <td colspan="3">
                                        <div class="flex flex-col items-center justify-center mt-24 mb-24">
                                            <div class="p-6 bg-gray-100 rounded-full">
                                                <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-width="2"
                                                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                </svg>
                                            </div>
                                            <p class="mt-2 text-xl font-bold text-center text-black">No Record Found!
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($jobposition as $data)
                                    <tr wire:key='jobTags-{{ $data->position_id }}'
                                        class="bg-white border-b cursor-pointer hover:bg-gray-50"
                                        onclick="document.getElementById('jobTags-{{ $data->position_id }}').click();">
                                        <td class="px-6 py-4 text-center">
                                            <input wire:model="mountJobTagsFilter" type="checkbox"
                                                id="jobTags-{{ $data->position_id }}"
                                                value="{{ $data->position_id }}"
                                                onclick="document.getElementById('jobTags-{{ $data->position_id }}').click();"
                                                class="w-5 h-5 transition-all border rounded-md appearance-none cursor-pointer border-blue-gray-200 checked:border-blue-900 checked:bg-blue-600" />
                                            <span
                                                class="absolute text-white transform opacity-0 top-2/4 left-2/4 -translate-x-2/4 -translate-y-2/4 peer-checked:opacity-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                    viewBox="0 0 20 20" fill="currentColor" stroke="currentColor"
                                                    stroke-width="1">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                            </label>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-base font-semibold uppercase">
                                                {{ $data->position_Title }}
                                            </div>
                                            <div class="text-sm text-gray-600 sm:hidden">
                                                Code: {{ $data->position_Code }}
                                                <!-- Extra information for mobile screens -->
                                            </div>
                                        </td>
                                        <td class="hidden px-6 py-4 md:table-cell">
                                            <div class="text-base font-semibold uppercase">{{ $data->position_Code }}
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
            <div class="mt-4">
                {{ $jobposition->links('vendor.livewire.tailwind', data: ['scrollTo' => false]) }}
            </div>

            <div class="flex justify-between mt-6">
                <x-secondary-button type="button" x-data=""
                    x-on:click="$dispatch('close-modal', 'job-tag-filter-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <div>
                    <x-danger-button wire:click.prevent="resetJobTags">
                        {{ __('Reset') }}
                    </x-danger-button>
                    <x-primary-button wire:loading.attr="disabled" wire:click.prevent="mountJobTags" class="ms-3"
                        type="button">
                        {{ __('Confirm') }}
                        <div wire:loading.delay.long wire:target="mountJobTags" role="status">
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
                    </x-primary-button>
                </div>


            </div>


        </div>


    </x-modal>


</div>
