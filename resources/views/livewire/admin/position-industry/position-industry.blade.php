<div wire:poll.5s class="container py-8 mx-auto">

    {{-- CONTIANER --}}
    <div class="grid grid-cols-4 gap-4 p-3 lg:grid-cols-12 lg:p-0">

        {{-- TITLE --}}
        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold ">Data Management / Position - Industry</h1>
        </div>

        {{-- JOB POSITION CONTAINER --}}
        <div class="col-span-4 lg:col-span-6">
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex flex-row justify-between mb-4">
                    {{-- TITLE --}}
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold ">Job Position List</h1>
                    </div>


                    {{-- PHONE BUTTON (SMALL SCREEN) --}}
                    <div>
                        <x-primary-button wire:click.prevent="open('jobposition')" type="button"
                            class="bg-blue-400 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900">Add
                            Job Position</x-primary-button>
                    </div>
                </div>

                <div class="relative overflow-x-auto ">

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
                            {{-- SEARCH --}}
                            <input type="search" wire:model.live='searchPosition'
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search for job position">
                        </div>
                        <div class="flex flex-wrap gap-2 mr-3">
                            <x-dropdown align="right" width="30">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                        <div>{{ $filterJob }}</div>

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

                                    <x-dropdown-link wire:click.prevent="updateFilter(1, 'All')"
                                        class="block px-4 py-2 cursor-pointer hover:bg-gray-100">All</x-dropdown-link>

                                    <!-- Authentication -->
                                    <x-dropdown-link class="cursor-pointer"
                                        wire:click.prevent="updateFilter(1, 'Archived')"
                                        class="block px-4 py-2 cursor-pointer hover:bg-gray-100">Archived</x-dropdown-link>

                                </x-slot>
                            </x-dropdown>
                        </div>


                    </div>

                    {{-- POSITION TABLE --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 lg:w-1/3">
                                        Job Code
                                    </th>
                                    <th scope="col" class="hidden px-6 py-3 lg:w-full lg:table-cell">
                                        Position Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 lg:w-1/3">

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($jobpositions->isEmpty())
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
                                                <p class="mt-2 text-xl font-bold text-center text-black">
                                                    No Records Found!
                                                </p>
                                            </div>

                                        </td>
                                    </tr>
                                @else
                                    @foreach ($jobpositions as $data)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="hidden text-lg font-medium text-gray-500 uppercase lg:block">
                                                    {{ $data->position_Code }}
                                                </div>
                                                <div class="block lg:hidden">
                                                    <div class="font-bold text-black uppercase text-md">
                                                        {{ $data->position_Title }}
                                                    </div>
                                                    <div class="font-medium text-gray-500 uppercase  text-md">
                                                        {{ $data->position_Code }}
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="hidden px-6 py-4 lg:table-cell">
                                                <div class="text-lg font-bold text-black uppercase">
                                                    {{ $data->position_Title }}
                                                </div>
                                            </td>

                                            <td class="px-6 py-4">
                                                <div class="flex flex-row items-center justify-center gap-6">
                                                    <div x-data="{ tooltip: 'Edit Job Position' }">
                                                        <button
                                                            wire:click.prevent="editPosition('{{ $data->position_id }}')"
                                                            x-tooltip="tooltip" type="button"
                                                            class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    @if ($data->position_Status == 1)
                                                        <div x-data="{ tooltip: 'Archive Job Position' }">
                                                            <button x-tooltip="tooltip" type="button"
                                                                wire:click.prevent="archiveConfirmation(1, {{ $data->position_id }})"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-red-700 border border-red-700 rounded-lg hover:bg-red-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-red-300">
                                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke-width="1.5" stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>

                                                        </div>
                                                        </button>
                                                    @endif
                                                    @if ($data->position_Status == 2)
                                                        <div x-data="{ tooltip: 'Restore Job Position' }">
                                                            <button x-tooltip="tooltip" type="button"
                                                                wire:click.prevent="restoreConfirmation(1, {{ $data->position_id }})"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-green-700 border border-green-700 rounded-lg hover:bg-green-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-green-300">
                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24" fill="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                                                                        clip-rule="evenodd" />
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
                    <div class="mt-4">
                        {{ $jobpositions->links('vendor.livewire.tailwind') }}
                    </div>
                </div>

            </div>
        </div>



        {{-- INDUSTRY CONTAINER --}}
        <div class="col-span-4 lg:col-span-6">
            <div class="p-6 bg-white rounded-lg shadow">

                {{-- TITLE --}}
                <div class="flex flex-row justify-between mb-4">
                    {{-- TITLE --}}
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold ">Industry List</h1>
                    </div>


                    {{-- PHONE BUTTON (SMALL SCREEN) --}}

                    <x-primary-button type="button"
                        class="bg-blue-400 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900"
                        x-data="" x-on:click.prevent="$dispatch('open-modal', 'industry-modal')">Add
                        Industry</x-primary-button>

                </div>

                <div class="relative overflow-x-auto ">

                    <div class="flex flex-col gap-2 p-1 pb-4 space-y-4 lg:flex-row lg:justify-between lg:space-y-0">


                        <label for="table-search" class="sr-only">Search</label>


                        <div class="relative">
                            <div
                                class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            {{-- SEARCH --}}
                            <input type="search" wire:model.live='searchIndustry'
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search for industry">
                        </div>
                        <div class="flex flex-wrap gap-2 mr-3">
                            <x-dropdown align="right" width="30">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                        <div>{{ $filterIndustry }}</div>

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

                                    <x-dropdown-link wire:click.prevent="updateFilter(2, 'All')"
                                        class="block px-4 py-2 cursor-pointer hover:bg-gray-100">All</x-dropdown-link>

                                    <!-- Authentication -->
                                    <x-dropdown-link wire:click.prevent="updateFilter(2, 'Archived')"
                                        class="block px-4 py-2 cursor-pointer hover:bg-gray-100">Archived</x-dropdown-link>

                                </x-slot>
                            </x-dropdown>

                        </div>
                    </div>

                    {{-- POSITION TABLE --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 lg:w-1/3">
                                        Industry Code
                                    </th>
                                    <th scope="col" class="hidden px-6 py-3 lg:w-full lg:table-cell">
                                        Industry Title
                                    </th>
                                    <th scope="col" class="px-6 py-3 lg:w-1/3">

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($industry->isEmpty())
                                    <tr>
                                        <td colspan="3">
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
                                                    No Records Found!
                                                </p>
                                            </div>

                                        </td>
                                    </tr>
                                @else
                                    @foreach ($industry as $data)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="hidden text-lg font-medium text-gray-500 uppercase lg:block">
                                                    {{ $data->industry_Code }}
                                                </div>
                                                <div class="block lg:hidden">
                                                    <div class="font-bold text-black uppercase text-md">
                                                        {{ $data->industry_Title }}
                                                    </div>
                                                    <div class="font-medium text-gray-500 uppercase  text-md">
                                                        {{ $data->industry_Code }}
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="hidden px-6 py-4 lg:table-cell">
                                                <div class="text-lg font-bold text-black uppercase">
                                                    {{ $data->industry_Title }}
                                                </div>
                                            </td>

                                            <td class="px-6 py-4">
                                                <div class="flex flex-row items-center justify-center gap-6">
                                                    <div x-data="{ tooltip: 'Edit Industry' }">
                                                        <button
                                                            wire:click.prevent="editIndustry('{{ $data->industry_id }}')"
                                                            x-tooltip="tooltip" type="button"
                                                            class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    @if ($data->industry_Status == 1)
                                                        <div x-data="{ tooltip: 'Archive Industry' }">
                                                            <button x-tooltip="tooltip" type="button"
                                                                wire:click.prevent="archiveConfirmation(2, {{ $data->industry_id }})"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-red-700 border border-red-700 rounded-lg hover:bg-red-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-red-300">
                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>

                                                            </button>
                                                        </div>
                                                    @endif
                                                    @if ($data->industry_Status == 2)
                                                        <div x-data="{ tooltip: 'Restore Industry' }">
                                                            <button x-tooltip="tooltip" type="button"
                                                                wire:click.prevent="restoreConfirmation(2, {{ $data->industry_id }})"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-green-700 border border-green-700 rounded-lg hover:bg-green-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-green-300">
                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24" fill="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                                                                        clip-rule="evenodd" />
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
                    {{-- PAGINATION --}}
                    <div class="mt-4">
                        {{ $industry->links('vendor.livewire.tailwind') }}
                    </div>

                </div>

            </div>
        </div>


    </div>


    {{-- JOB POSITION MODAL --}}
    <x-modal name="jobposition-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Add Job Position') }}
            </h2>

            <hr>

            <div class="flex flex-col w-full gap-2 mt-2 lg:flex-row lg:gap-6">

                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="positionPost" :value="__('Job Position Title')" />
                    <x-text-input wire:model='positionPost' id="positionPost" class="block w-full mt-1 uppercase"
                        type="text" />
                    <x-input-error :messages="$errors->get('positionPost')" class="mt-2" />
                </div>

                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="pcodePost" :value="__('Job Position Code')" />
                    <x-text-input wire:model='pcodePost' id="pcodePost" class="block w-full mt-1 uppercase"
                        type="text" />
                    <x-input-error :messages="$errors->get('pcodePost')" class="mt-2" />
                </div>


            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button wire:click.prevent="close('jobposition')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent='savePosition' class="ms-3" type="button"
                    id="eligibilityAdd">
                    {{ __('Save Position') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>


    {{-- INDUSTRY MODAL --}}
    <x-modal name="industry-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Add Industry') }}
            </h2>

            <hr>

            <div class="flex flex-col w-full gap-2 mt-2 lg:flex-row lg:gap-6">

                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="industryPost" :value="__('Industry Title')" />
                    <x-text-input wire:model='industryPost' id="industryPost" class="block w-full mt-1 uppercase"
                        type="text" />
                    <x-input-error :messages="$errors->get('industryPost')" class="mt-2" />
                </div>

                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="icodePost" :value="__('Industry Code')" />
                    <x-text-input wire:model='icodePost' id="icodePost" class="block w-full mt-1 uppercase"
                        type="text" />
                    <x-input-error :messages="$errors->get('icodePost')" class="mt-2" />
                </div>


            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button wire:click.prevent="close('industry')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent='saveIndustry' class="ms-3" type="button">
                    {{ __('Save Industry') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    <x-modal name="delete-jobposition-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center my-12">

                <h1 class="text-2xl font-bold">Are you sure you want to archive this job position?</h1>


            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-jobposition-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled" wire:click.prevent="confirmArchive(1)" class="ms-3"
                    type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="confirmArchive(1)" role="status">
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
    <x-modal name="delete-industry-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center my-12">

                <h1 class="text-2xl font-bold">Are you sure you want to archive this industry?</h1>


            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-industry-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled" wire:click.prevent="confirmArchive(2)" class="ms-3"
                    type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="confirmArchive(2)" role="status">
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
    <x-modal name="restore-jobposition-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center my-12">

                <h1 class="text-2xl font-bold">Are you sure you want to restore this job position?</h1>


            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'restore-jobposition-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-green-button wire:loading.attr="disabled" wire:click.prevent="confirmRestore(1)" class="ms-3"
                    type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="confirmRestore(1)" role="status">
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
    <x-modal name="restore-industry-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center my-12">

                <h1 class="text-2xl font-bold">Are you sure you want to restore this industry?</h1>


            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'restore-industry-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-green-button wire:loading.attr="disabled" wire:click.prevent="confirmRestore(2)" class="ms-3"
                    type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="confirmRestore(2)" role="status">
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

</div>
