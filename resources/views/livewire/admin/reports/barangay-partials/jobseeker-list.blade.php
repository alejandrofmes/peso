<div>
    <div class="flex flex-col lg:flex-row p-1 lg:justify-between gap-2 space-y-4 lg:space-y-0 pb-4">


        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>

            {{-- SEARCH --}}
            <input wire:model.live='searchJobseekers' type="search"
                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Search">
        </div>

        <div class="flex flex-wrap gap-2">


            <x-dropdown align="left" width="40">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-3 py-1.5
                        text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        <div>
                            Export
                        </div>

                        <div class="ms-1">
                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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

                    <x-dropdown-link wire:click.prevent='exportExcel' x-data="{ tooltip: 'Export to Excel' }" x-tooltip='tooltip'
                        class="cursor-pointer flex flex-row gap-2 text-sm font-medium text-gray-500 bg-white rounded-lg shadow-sm hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        <svg width="24px" height="24px" viewBox="-4.08 -4.08 32.16 32.16"
                            xmlns="http://www.w3.org/2000/svg" fill="#6B7280" stroke="#6B7280"
                            stroke-width="0.00024000000000000003">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                stroke="#CCCCCC" stroke-width="0.4800000000000001"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path
                                        d="M2.859 2.877l12.57-1.795a.5.5 0 0 1 .571.495v20.846a.5.5 0 0 1-.57.495L2.858 21.123a1 1 0 0 1-.859-.99V3.867a1 1 0 0 1 .859-.99zM17 3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4V3zm-6.8 9L13 8h-2.4L9 10.286 7.4 8H5l2.8 4L5 16h2.4L9 13.714 10.6 16H13l-2.8-4z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                        <span class="flex">Export to Excel</span>
                    </x-dropdown-link>
                    <x-dropdown-link wire:click.prevent="exportPdf" x-data="{ tooltip: 'Export to PDF' }" x-tooltip='tooltip'
                        class="cursor-pointer flex flex-row gap-1 text-sm font-medium text-gray-500 bg-white rounded-lg shadow-sm hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        <svg fill="#6B7280" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" stroke="#6B7280"
                            viewBox="-10 0 100.00 120.00" enable-background="new 0 0 100 100" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path
                                        d="M94.284,65.553L75.825,52.411c-0.389-0.276-0.887-0.312-1.312-0.093c-0.424,0.218-0.684,0.694-0.685,1.173l0.009,6.221 H57.231c-0.706,0-1.391,0.497-1.391,1.204v11.442c0,0.707,0.685,1.194,1.391,1.194h16.774v6.27c0,0.478,0.184,0.917,0.609,1.136 s0.853,0.182,1.242-0.097l18.432-13.228c0.335-0.239,0.477-0.626,0.477-1.038c0-0.002,0-0.002,0-0.002 C94.765,66.179,94.621,65.793,94.284,65.553z">
                                    </path>
                                    <path
                                        d="M64.06,78.553h-6.49h0c-0.956,0-1.73,0.774-1.73,1.73h-0.007v3.01H15.191V36.16h17.723c0.956,0,1.73-0.774,1.73-1.73 V16.707h21.188l0,36.356h0.011c0.021,0.937,0.784,1.691,1.726,1.691h6.49c0.943,0,1.705-0.754,1.726-1.691h0.004v-0.038 c0,0,0-0.001,0-0.001c0-0.001,0-0.001,0-0.002l0-40.522h-0.005V8.48c0-0.956-0.774-1.73-1.73-1.73h-2.45v0H32.914v0h-1.73 L5.235,32.7v2.447v1.013v52.912v2.447c0,0.956,0.774,1.73,1.73,1.73h1.582h53.925h1.582c0.956,0,1.73-0.774,1.73-1.73v-2.448h0.005 l0-8.789l0-0.001C65.79,79.328,65.015,78.553,64.06,78.553z">
                                    </path>
                                    <path
                                        d="M21.525,61.862v9.231h2.795v-2.906h2.131c2.159,0,3.321-1.439,3.321-3.156c0-1.73-1.162-3.169-3.321-3.169H21.525z M26.936,65.031c0,0.484-0.374,0.72-0.844,0.72H24.32v-1.453h1.771C26.562,64.298,26.936,64.533,26.936,65.031z">
                                    </path>
                                    <path
                                        d="M31.228,61.862v9.231h4.138c2.893,0,5.052-1.675,5.052-4.623s-2.159-4.608-5.065-4.608H31.228z M37.58,66.471 c0,1.163-0.83,2.187-2.228,2.187h-1.329v-4.36h1.342C36.86,64.298,37.58,65.225,37.58,66.471z">
                                    </path>
                                    <polygon
                                        points="49.116,64.298 49.116,61.862 42.113,61.862 42.113,71.093 44.908,71.093 44.908,67.647 49.018,67.647 49.018,65.211 44.908,65.211 44.908,64.298 ">
                                    </polygon>
                                </g>
                            </g>
                        </svg>
                        <span class="ps-1">
                            Export to PDF
                        </span>
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>


            <button type="button" x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'filter-jobseekers-modal')"
                x-on:focus="$dispatch('open-modal', 'filter-jobseekers-modal')"
                class=" hover:bg-gray-100 text-gray-500 hover:text-blue-700 focus:z-10 bg-white inline-flex max-h-fit items-center border border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                <span class="flex flex-row items-center gap-2"> Filter
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                    </svg>
                </span>
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 mt-2">
            <thead class="text-xs text-gray-700 uppercase bg-blue-300">
                <tr>
                    <th scope="col" class="px-6 py-3 w-full">
                        <span class="text-black font-bold text-md">Applicant Name</span>
                    </th>
                    <th scope="col" class="hidden lg:table-cell px-6 py-3">
                        <span class="text-black font-bold text-md">Employment Status</span>
                    </th>
                    <th scope="col" class="hidden lg:table-cell px-6 py-3 text-center">
                        <span class="text-black font-bold text-md">Active Applications</span>
                    </th>
                    <th scope="col" class="hidden lg:table-cell px-6 py-3 text-center">
                        <span class="text-black font-bold text-md">Registered Trainings</span>
                    </th>
                    <th scope="col" class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @if ($barangayJobSeekers->isEmpty())
                    <tr>
                        <td colspan="5">
                            <div class="flex flex-col items-center justify-center mt-24 mb-24">
                                <div class="p-6 bg-gray-100 rounded-full">
                                    <svg class="w-24 h-24 text-black" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <p class="text-xl font-bold text-black text-center mt-2">No Records Found!</p>
                            </div>
                        </td>
                    </tr>
                @else
                    @foreach ($barangayJobSeekers as $data)
                        <tr wire:key='applicants-{{ $data->job_id }}' class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                <img class="w-10 h-10 rounded-full object-cover"
                                    src="{{ asset('storage/' . $data->pimg) }}" alt="img">
                                <div class="ps-3 text-wrap">
                                    <div class="text-base font-semibold uppercase">
                                        {{ $data->fname }} {{ $data->mname }} {{ $data->lname }}
                                    </div>


                                    <div class="text-sm text-gray-500 lg:hidden">
                                        <span>Active Apps: <span
                                                class="text-black font-bold">{{ $data->active_applications_count }}</span></span>
                                    </div>
                                    <div class="text-sm text-gray-500 lg:hidden">
                                        <span>Trainings: <span
                                                class="text-black font-bold">{{ $data->program_reg_count }}</span></span>
                                    </div>
                                    <div class="text-sm text-gray-500 lg:hidden">
                                        <span>
                                            @if ($data->empstatus == '2')
                                                <span
                                                    class="inline-flex items-center rounded-md bg-yellow-200 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">UNEMPLOYED</span>
                                            @elseif ($data->empstatus == '1')
                                                <span
                                                    class="inline-flex items-center rounded-md bg-green-200 px-2 py-1 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/20">EMPLOYED</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </th>

                            <td class="hidden lg:table-cell px-6 py-4">
                                @if ($data->empstatus == '2')
                                    <span
                                        class="inline-flex items-center rounded-md bg-yellow-200 px-2 py-1 text-sm font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">UNEMPLOYED</span>
                                @elseif ($data->empstatus == '1')
                                    <span
                                        class="inline-flex items-center rounded-md bg-green-200 px-2 py-1 text-sm font-medium text-green-800 ring-1 ring-inset ring-green-600/20">EMPLOYED</span>
                                @endif
                            </td>

                            <td class="hidden lg:table-cell px-6 py-4 text-center">
                                <div class="font-normal text-gray-500 text-sm uppercase">
                                    <span
                                        class="text-blue-500 font-bold text-md">{{ $data->active_applications_count }}</span>
                                </div>
                            </td>

                            <td class="hidden lg:table-cell px-6 py-4 text-center">
                                <div class="font-normal text-gray-500 text-sm uppercase">
                                    <span class="text-blue-500 font-bold text-md">{{ $data->program_reg_count }}</span>
                                </div>
                            </td>

                            <td>
                                <div x-data="{ tooltip: 'Jobseeker Overview' }">
                                    <a wire:navigate
                                        href="{{ route('admin-users-jobseeker-overview', ['id' => $data->employee_id]) }}"
                                        x-tooltip="tooltip" type="button"
                                        class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor">
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


        <div class="mt-4">
            {{ $barangayJobSeekers->links('vendor.livewire.tailwind', data: ['scrollTo' => false]) }}
        </div>
    </div>

    <x-modal name="filter-jobseekers-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Filter Job Seekers') }}
            </h2>
            <hr>
            <div class="flex flex-col w-full">
                <div class="flex-col mt-4">
                    <h1 class="text-md font-semibold">Sort By Gender</h1>

                    <div class="flex flex-col md:flex-row w-full gap-4 mt-2">
                        <div class="flex items-center">
                            <input wire:model='mountGender' id="gender-all" type="radio" value=""
                                name="gender" checked
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="gender-all" class="ms-2 text-sm font-medium text-gray-900">None</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountGender' id="gender-male" type="radio" value="1"
                                name="gender"
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="gender-male" class="ms-2 text-sm font-medium text-gray-900">Male</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountGender' id="gender-female" type="radio" value="2"
                                name="gender"
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="gender-female" class="ms-2 text-sm font-medium text-gray-900">Female</label>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-4 mb-4 mt-2">
                    <h1 class="text-md font-semibold mb-2">Sort By Age</h1>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center">
                            <input wire:model='mountAge' id="checkbox-18s" type="checkbox" value="18-19"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="checkbox-18s" class="ms-2 text-sm font-medium text-gray-900">18-19</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountAge' id="checkbox-20s" type="checkbox" value="20-29"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="checkbox-20s" class="ms-2 text-sm font-medium text-gray-900">20-29</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountAge' id="checkbox-30s" type="checkbox" value="30-39"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="checkbox-30s" class="ms-2 text-sm font-medium text-gray-900">30-39</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountAge' id="checkbox-40s" type="checkbox" value="40-49"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="checkbox-40s" class="ms-2 text-sm font-medium text-gray-900">40-49</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountAge' id="checkbox-50s" type="checkbox" value="50-59"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="checkbox-50s" class="ms-2 text-sm font-medium text-gray-900">50-59</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountAge' id="checkbox-60s" type="checkbox" value="60-69"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="checkbox-60s" class="ms-2 text-sm font-medium text-gray-900">60-69</label>
                        </div>
                    </div>
                </div>

                <div class="flex-col mt-4">
                    <h1 class="text-md font-semibold">Sort By Employment Status</h1>

                    <div class="flex flex-col md:flex-row w-full gap-4 mt-2">
                        <div class="flex items-center">
                            <input wire:model='mountEmpStatus' id="emp-none" type="radio" value=""
                                name="empStatus" checked
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="emp-none" class="ms-2 text-sm font-medium text-gray-900">All</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountEmpStatus' id="emp-emp" type="radio" value="1"
                                name="empStatus"
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="emp-emp" class="ms-2 text-sm font-medium text-gray-900">Employed</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountEmpStatus' id="emp-unemp" type="radio" value="2"
                                name="empStatus"
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="emp-unemp" class="ms-2 text-sm font-medium text-gray-900">Unemployed</label>
                        </div>
                    </div>
                </div>

                <div class="flex-col mt-4">
                    <h1 class="text-md font-semibold">Sort By Civil Status</h1>

                    <div class="flex flex-col md:flex-row w-full gap-4 mt-2">
                        <div class="flex items-center">
                            <input wire:model='mountCivilStatus' id="civil-all" type="radio" value=""
                                name="civilStatus" checked
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="civil-all" class="ms-2 text-sm font-medium text-gray-900">All</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountCivilStatus' id="civil-single" type="radio" value="1"
                                name="civilStatus" checked
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="civil-single" class="ms-2 text-sm font-medium text-gray-900">Single</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountCivilStatus' id="civil-married" type="radio" value="2"
                                name="civilStatus"
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="civil-married" class="ms-2 text-sm font-medium text-gray-900">Married</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountCivilStatus' id="civil-widowed" type="radio" value="3"
                                name="civilStatus"
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="civil-widowed" class="ms-2 text-sm font-medium text-gray-900">Widowed</label>
                        </div>
                    </div>
                </div>
                <div class="flex-col mt-4">
                    <h1 class="text-md font-semibold">Sort By OFW Record</h1>

                    <div class="flex flex-col md:flex-row w-full gap-4 mt-2">
                        <div class="flex items-center">
                            <input wire:model='mountOFWFilter' id="ofw-all" type="radio" value=""
                                name="ofwFilter" checked
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="ofw-all" class="ms-2 text-sm font-medium text-gray-900">All</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountOFWFilter' id="ofw-yes" type="radio" value="1"
                                name="ofwFilter"
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="ofw-yes" class="ms-2 text-sm font-medium text-gray-900">OFW</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountOFWFilter' id="ofw-no" type="radio" value="2"
                                name="ofwFilter"
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="ofw-no" class="ms-2 text-sm font-medium text-gray-900">Not OFW</label>
                        </div>
                    </div>
                </div>

                <div class="flex-col mt-4">
                    <h1 class="text-md font-semibold">Sort By 4Ps Record</h1>

                    <div class="flex flex-col md:flex-row w-full gap-4 mt-2">
                        <div class="flex items-center">
                            <input wire:model='mountFourPFilter' id="4ps-all" type="radio" value=""
                                name="4psFilter" checked
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="4ps-all" class="ms-2 text-sm font-medium text-gray-900">All</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountFourPFilter' id="4ps-yes" type="radio" value="1"
                                name="4psFilter"
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="4ps-yes" class="ms-2 text-sm font-medium text-gray-900">4Ps Member</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model='mountFourPFilter' id="4ps-no" type="radio" value="2"
                                name="4psFilter"
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="4ps-no" class="ms-2 text-sm font-medium text-gray-900">Not 4Ps
                                Member</label>
                        </div>
                    </div>
                </div>

                <div class="flex-col mt-4">
                    <h1 class="text-md font-semibold">Sort By Educational Attainment</h1>

                    <select wire:model="mountEducationAttainment" class="block mt-1 w-full rounded-md">
                        <option value="" selected>None</option>
                        <option value="Elementary Graduate">Elementary Graduate</option>
                        <option value="High School Level">High School Level</option>
                        <option value="High School Graduate">High School Graduate</option>
                        <option value="College Level">College Level</option>
                        <option value="College Graduate">College Graduate</option>
                    </select>
                </div>

            </div>
            <div class="mt-6 flex justify-between">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'filter-jobseekers-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <div>
                    <x-danger-button wire:click.prevent="resetFilter">
                        {{ __('Reset') }}
                    </x-danger-button>
                    <x-primary-button wire:loading.attr="disabled" wire:click.prevent="mountFilter" class="ms-3"
                        type="button">
                        {{ __('Confirm') }}
                        <div wire:loading.delay.long wire:target="mountFilter" role="status">
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
                    </x-primary-button>
                </div>

            </div>
        </div>
    </x-modal>
</div>
