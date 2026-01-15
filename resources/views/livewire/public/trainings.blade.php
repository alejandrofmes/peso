<div wire:poll.5s class="max-w-screen-xl p-5 mx-auto lg:p-10 md:p-16" x-data="{
    openTab: 1,
    activeTab: 'text-blue-600 border-b-2 border-blue-600  active',
    inactiveTab: 'text-gray-500 hover:text-gray-600 ',
}">

    <div class="flex justify-between mb-5 text-sm border-b">
        <div class="flex flex-row gap-6">
            <button x-on:click="openTab = 1" :class="openTab === 1 ? activeTab : inactiveTab"
                class="flex items-center pb-2 pr-2">
                <svg class="h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                </svg>

                <span class="inline-block font-semibold">Trainings List</span>
            </button>
            @if (Auth::check() && auth()->user()->usertype == 4)
                <button x-on:click="openTab = 2" :class="openTab === 2 ? activeTab : inactiveTab"
                    class="flex items-center pb-2 pr-2 ">
                    <svg class="h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                    </svg>

                    <span class="inline-block font-semibold">My Trainings</span>
                </button>
            @endif
        </div>

    </div>
    <div x-show="openTab === 1" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-cloak>
        <div
            class="flex flex-col gap-2 p-1 pb-4 space-y-4 overflow-visible lg:flex-row lg:justify-between lg:space-y-0">


            <label for="table-search" class="sr-only">Search</label>

            <div class="relative w-full lg:w-auto">

                <div class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                {{-- SEARCH --}}
                <input wire:model.live='search' type="search"
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search for trainings">
            </div>

            {{-- FILTER BUTTON --}}

            <div class="flex flex-wrap gap-2">
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
                            <x-dropdown-link wire:click.prevent="updateFilter('All')" class="cursor-pointer">
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
                                {{ $sortType ?: 'Sort By Type' }}
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
                        @if ($sortType)
                            <x-dropdown-link wire:click.prevent="updateSort('', 1)" class="cursor-pointer">
                                All
                            </x-dropdown-link>
                        @endif
                        <x-dropdown-link wire:click.prevent="updateSort('PESO Hosted', 1)" class="cursor-pointer">
                            PESO Hosted
                        </x-dropdown-link>
                        <x-dropdown-link wire:click.prevent="updateSort('TESDA Scholarship', 1)" class="cursor-pointer">
                            TESDA Scholarship
                        </x-dropdown-link>

                    </x-slot>
                </x-dropdown>

                <x-dropdown align="left" width="36">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                            <div>
                                @if (empty($sortDate))
                                    Sort By Date
                                @elseif($sortDate === 'ASC')
                                    Newest
                                @elseif($sortDate === 'DESC')
                                    Oldest
                                @endif
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

                        <x-dropdown-link wire:click.prevent="updateSort('ASC', 2)" class="cursor-pointer">
                            Newest
                        </x-dropdown-link>
                        <x-dropdown-link wire:click.prevent="updateSort('DESC', 2)" class="cursor-pointer">
                            Oldest
                        </x-dropdown-link>

                    </x-slot>
                </x-dropdown>
            </div>


        </div>


        <div>


            <div class="grid grid-cols-4 gap-10 lg:grid-cols-12">

                <!-- CARD 1 -->



                @if ($programList->isEmpty())
                    <div class="col-span-4 lg:col-span-12">
                        <div class="flex flex-col items-center justify-center mt-24 mb-24">
                            <div class="p-6 bg-white rounded-full">
                                <svg class="w-24 h-24 text-black" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                </svg>

                            </div>
                            <p class="mt-2 text-2xl font-bold text-center text-black">
                                No Trainings Found
                            </p>
                        </div>
                    </div>
                @else
                    @foreach ($programList as $data)
                        <a wire:navigate href="{{ route('training.show', ['id' => $data->program_id]) }}"
                            class="block col-span-4 overflow-hidden bg-white rounded-lg shadow-xl lg:hover:scale-105 lg:transition-transform">
                            <div class="flex flex-col h-full">
                                <div>
                                    <div class="relative">
                                        <div class="w-full h-64 overflow-hidden">
                                            <img class="object-cover w-full h-full"
                                                src="{{ asset('storage/' . $data->program_pubmat) }}"
                                                alt="prog-{{ $data->program_id }}">
                                        </div>
                                        <div
                                            class="absolute top-0 right-0 px-4 py-2 mt-3 mr-3 text-xs text-white transition duration-500 ease-in-out bg-indigo-600">
                                            {{ $data->program_Type }}
                                        </div>
                                    </div>
                                    <div class="px-6 py-4 mb-auto ">
                                        <span
                                            class="flex justify-center mb-2 text-2xl font-bold text-center text-blue-500 transition duration-500 ease-in-out hover:text-blue-800">
                                            {{ $data->program_Title }}
                                        </span>
                                        <p class="flex justify-center text-sm text-justify text-gray-500">
                                            {!! \Illuminate\Support\Str::limit(strip_tags($data->program_Description), 175, '...') !!}
                                        </p>
                                    </div>
                                </div>
                                <!-- Bottom section for PESO Municipality and Date -->
                                <div class="flex flex-row items-center justify-between px-6 py-3 mt-auto bg-white">
                                    <span class="flex flex-row items-center py-1 text-xs text-gray-900 font-regular">
                                        <svg height="13px" width="13px" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"
                                            xml:space="preserve">
                                            <g>
                                                <g>
                                                    <path
                                                        d="M256,0C114.837,0,0,114.837,0,256s114.837,256,256,256s256-114.837,256-256S397.163,0,256,0z M277.333,256 c0,11.797-9.536,21.333-21.333,21.333h-85.333c-11.797,0-21.333-9.536-21.333-21.333s9.536-21.333,21.333-21.333h64v-128 c0-11.797,9.536-21.333,21.333-21.333s21.333,9.536,21.333,21.333V256z">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                        <span class="ml-1">{{ $data->program_Deadline->format('F j, Y') }}</span>
                                    </span>
                                    <span class="flex flex-row items-center py-1 text-xs text-gray-900 font-regular">
                                        <svg class="h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>

                                        <span class="ml-1">PESO
                                            {{ $data->peso->municipality->municipality_Name }}</span>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif




            </div>
            <div class="mt-10">
                {{ $programList->links() }}
            </div>

        </div>


    </div>
    @if (Auth::check() && auth()->user()->usertype == 4)
        <div class="grid grid-cols-4 gap-10" x-show="openTab === 2"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100" x-cloak>

            <div class="col-span-4">
                <div class="overflow-visible table-container">
                    <div class="mx-auto overflow-visible max-w-7xl">
                        <div class="p-2 overflow-visible bg-white lg:rounded-lg">
                            <div class="relative">
                                <div class="p-6 overflow-visible ">

                                    <div
                                        class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">
                                        {{-- SEARCH BOX --}}

                                        <label for="table-search" class="sr-only">Search</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                                                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                                </svg>
                                            </div>
                                            <input wire:model.live.prevent='searchHistory' type="text"
                                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Search for trainings">
                                        </div>

                                        {{-- SORT --}}
                                        <div class="flex flex-row gap-2">
                                            <x-dropdown align="left" width="36">
                                                <x-slot name="trigger">
                                                    <button
                                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                                        <div>
                                                            {{ $sortTypeHistory ?: 'Sort By Type' }}
                                                        </div>

                                                        <div class="ms-1">
                                                            <svg class="w-4 h-4 fill-current"
                                                                xmlns="http://www.w3.org/2000/svg"
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
                                                    @if ($sortTypeHistory)
                                                        <x-dropdown-link wire:click.prevent="updateSortHistory('', 1)"
                                                            class="cursor-pointer">
                                                            All
                                                        </x-dropdown-link>
                                                    @endif
                                                    <x-dropdown-link
                                                        wire:click.prevent="updateSortHistory('PESO Hosted', 1)"
                                                        class="cursor-pointer">
                                                        PESO Hosted
                                                    </x-dropdown-link>
                                                    <x-dropdown-link
                                                        wire:click.prevent="updateSortHistory('TESDA Scholarship', 1)"
                                                        class="cursor-pointer">
                                                        TESDA Scholarship
                                                    </x-dropdown-link>

                                                </x-slot>
                                            </x-dropdown>

                                            <x-dropdown align="left" width="36">
                                                <x-slot name="trigger">
                                                    <button
                                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                                        <div>
                                                            @if (empty($sortDate))
                                                                Sort By Date
                                                            @elseif($sortDateHistory === 'DESC')
                                                                Newest
                                                            @elseif($sortDateHistory === 'ASC')
                                                                Oldest
                                                            @endif
                                                        </div>

                                                        <div class="ms-1">
                                                            <svg class="w-4 h-4 fill-current"
                                                                xmlns="http://www.w3.org/2000/svg"
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

                                                    <x-dropdown-link wire:click.prevent="updateSortHistory('DESC', 2)"
                                                        class="cursor-pointer">
                                                        Newest
                                                    </x-dropdown-link>
                                                    <x-dropdown-link wire:click.prevent="updateSortHistory('ASC', 2)"
                                                        class="cursor-pointer">
                                                        Oldest
                                                    </x-dropdown-link>

                                                </x-slot>
                                            </x-dropdown>
                                        </div>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table
                                            class="w-full text-sm text-left text-gray-500 rtl:text-right lg:table-fixed">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 md:w-96">Event Title</th>
                                                    <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                                                        Registered Date</th>
                                                    <th scope="col" class="hidden px-6 py-3 md:table-cell">
                                                        Registration Status</th>
                                                    <th scope="col" class="hidden px-6 py-3 md:table-cell">Program
                                                        Status</th>
                                                    <th scope="col" class="px-6 py-3 w-md">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($programHistory->isEmpty())
                                                    <tr>
                                                        <td colspan="5">
                                                            <div
                                                                class="flex flex-col items-center justify-center mt-24 mb-24">
                                                                <div class="p-6 bg-gray-100 rounded-full">
                                                                    <svg class="w-24 h-24 text-black"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                                    </svg>
                                                                </div>
                                                                <p
                                                                    class="mt-2 text-xl font-bold text-center text-black">
                                                                    No Trainings Found</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @else
                                                    @foreach ($programHistory as $data)
                                                        <tr wire:key='progReg-{{ $data->progra_reg_id }}'
                                                            class="bg-white border-b">
                                                            <th scope="row"
                                                                class="flex flex-col items-start px-6 py-4 text-gray-900 lg:flex-row">
                                                                <div class="ps-3">
                                                                    <div class="text-base font-semibold">
                                                                        {{ $data->programs->program_Title }}</div>
                                                                    <div class="text-sm font-normal text-gray-500">
                                                                        {{ $data->programs->program_Location }}</div>
                                                                    <div class="mt-2 text-sm text-gray-500 lg:hidden">
                                                                        {{ $data->created_at->format('F j, Y') }}</div>
                                                                    <!-- Mobile view -->
                                                                    <div class="mt-2 text-sm text-gray-500 lg:hidden">
                                                                        Program Status:
                                                                        <div class="flex items-center">
                                                                            @if ($data->programs->program_Status === 'ACTIVE')
                                                                                <div
                                                                                    class="h-2.5 w-2.5 rounded-full bg-green-500 me-2">
                                                                                </div> ACTIVE
                                                                            @elseif ($data->programs->program_Status === 'CLOSED')
                                                                                <div
                                                                                    class="h-2.5 w-2.5 rounded-full bg-cyan-500 me-2">
                                                                                </div> CLOSED
                                                                            @elseif ($data->programs->program_Status === 'COMPLETED')
                                                                                <div
                                                                                    class="h-2.5 w-2.5 rounded-full bg-blue-500 me-2">
                                                                                </div> COMPLETED
                                                                            @elseif($data->programs->program_Status === 'CANCELLED')
                                                                                <div
                                                                                    class="h-2.5 w-2.5 rounded-full bg-red-500 me-2">
                                                                                </div> CANCELLED
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="mt-2 text-sm text-gray-500 lg:hidden">
                                                                        Registration Status:
                                                                        <div class="flex items-center">
                                                                            @if ($data->program_reg_Status == 'REGISTERED')
                                                                                <div
                                                                                    class="h-2.5 w-2.5 rounded-full bg-yellow-500 me-2">
                                                                                </div> REGISTERED
                                                                            @elseif ($data->program_reg_Status == 'COMPLETED')
                                                                                <div
                                                                                    class="h-2.5 w-2.5 rounded-full bg-green-500 me-2">
                                                                                </div> COMPLETED
                                                                            @elseif ($data->program_reg_Status == 'ATTENDEE')
                                                                                @if ($data->programs->program_Status == 'COMPLETED')
                                                                                    <div
                                                                                        class="h-2.5 w-2.5 rounded-full bg-yellow-500 me-2">
                                                                                    </div> ATTENDEE
                                                                                @else
                                                                                    <div
                                                                                        class="h-2.5 w-2.5 rounded-full bg-green-500 me-2">
                                                                                    </div> ATTENDEE
                                                                                @endif
                                                                            @else
                                                                                <div
                                                                                    class="h-2.5 w-2.5 rounded-full bg-red-500 me-2">
                                                                                </div> {{ $data->program_reg_Status }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <td class="hidden px-6 py-4 lg:table-cell">
                                                                <div class="text-sm font-normal text-gray-500">
                                                                    {{ $data->created_at->format('F j, Y') }}</div>
                                                            </td>
                                                            <td class="hidden px-6 py-4 md:table-cell">
                                                                <div class="flex items-center">
                                                                    @if ($data->program_reg_Status == 'REGISTERED')
                                                                        <div
                                                                            class="h-2.5 w-2.5 rounded-full bg-yellow-500 me-2">
                                                                        </div> REGISTERED
                                                                    @elseif ($data->program_reg_Status == 'COMPLETED')
                                                                        <div
                                                                            class="h-2.5 w-2.5 rounded-full bg-green-500 me-2">
                                                                        </div> COMPLETED
                                                                    @elseif ($data->program_reg_Status == 'ATTENDEE')
                                                                        @if ($data->programs->program_Status == 'COMPLETED')
                                                                            <div
                                                                                class="h-2.5 w-2.5 rounded-full bg-yellow-500 me-2">
                                                                            </div> ATTENDEE
                                                                        @else
                                                                            <div
                                                                                class="h-2.5 w-2.5 rounded-full bg-green-500 me-2">
                                                                            </div> ATTENDEE
                                                                        @endif
                                                                    @else
                                                                        <div
                                                                            class="h-2.5 w-2.5 rounded-full bg-red-500 me-2">
                                                                        </div> {{ $data->program_reg_Status }}
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="hidden px-6 py-4 md:table-cell">
                                                                <div class="flex items-center">
                                                                    @if ($data->programs->program_Status === 'ACTIVE')
                                                                        <div
                                                                            class="h-2.5 w-2.5 rounded-full bg-green-500 me-2">
                                                                        </div> ACTIVE
                                                                    @elseif ($data->programs->program_Status === 'CLOSED')
                                                                        <div
                                                                            class="h-2.5 w-2.5 rounded-full bg-cyan-500 me-2">
                                                                        </div> CLOSED
                                                                    @elseif ($data->programs->program_Status === 'COMPLETED')
                                                                        <div
                                                                            class="h-2.5 w-2.5 rounded-full bg-blue-500 me-2">
                                                                        </div> COMPLETED
                                                                    @elseif($data->programs->program_Status === 'CANCELLED')
                                                                        <div
                                                                            class="h-2.5 w-2.5 rounded-full bg-red-500 me-2">
                                                                        </div> CANCELLED
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <div class="flex flex-row gap-5">
                                                                    @if ($data->programs->program_Status === 'ACTIVE')
                                                                        <div x-data="{ tooltip: 'View Training' }">
                                                                            <a wire:navigate
                                                                                href="{{ route('training.show', ['id' => $data->programs->program_id]) }}"
                                                                                x-tooltip="tooltip" type="button"
                                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                                                <svg class="w-5 h-5"
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
                                                                    @if ($data->program_reg_Status === 'ATTENDEE')
                                                                        <div x-data="{ tooltip: 'View Ticket' }">
                                                                            <button
                                                                                wire:click.prevent='viewTicket({{ $data->program_reg_id }})'
                                                                                x-tooltip="tooltip" type="button"
                                                                                class="inline-flex items-center p-1 text-sm font-medium text-center border rounded-lg text-cyan-700 border-cyan-700 hover:bg-cyan-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-cyan-300">
                                                                                <svg class="w-5 h-5"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    fill="none" viewBox="0 0 24 24"
                                                                                    stroke-width="1.5"
                                                                                    stroke="currentColor">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                                                                                </svg>
                                                                            </button>
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
                                    {{-- navbar --}}
                                    <div class="p-4 mt-2">
                                        {{ $programHistory->links('vendor.livewire.tailwind') }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>






        </div>
    @endif

    <x-modal name="ticket-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('My Event Ticket') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center w-full h-full my-4">
                @if ($ticket)
                    <div class="hidden my-4 lg:flex ">
                        {!! QrCode::size(400)->generate($ticket) !!}

                    </div>
                    <div class="flex my-4 lg:hidden ">
                        {!! QrCode::size(300)->generate($ticket) !!}

                    </div>
                    <div class="mt-4 text-center">
                        <h3 class="text-2xl font-semibold text-blue-500">{{ $ticketData['programTitle'] }}</h3>
                        <p class="text-sm text-gray-600">{{ $ticketData['programDate'] }}
                        </p>
                    </div>
                @else
                    <div class="flex">

                        <h1 class="text-xl font-semibold text-blue-500">No ticket can be generated. Please try again
                            later.</h1>

                    </div>
                @endif
            </div>
            <div class="flex justify-between mt-6">
                <x-secondary-button wire:click.prevent='closeTicket'>
                    {{ __('Close') }}
                </x-secondary-button>


            </div>
        </div>
    </x-modal>

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

</div>
