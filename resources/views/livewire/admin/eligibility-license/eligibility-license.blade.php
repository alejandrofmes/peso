<div wire:poll.5s class="container mx-auto py-8">
    <div class="grid grid-cols-4 lg:grid-cols-12 gap-4 p-3 lg:p-0">
        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Data Management / Eligibility - License</h1>
        </div>


        <div class="col-span-4 lg:col-span-6">
            {{-- @livewire('admin.eligibility-license.eligibility-table') --}}

            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex flex-row justify-between mb-4">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold ">Eligibility List</h1>
                    </div>

                    {{-- PHONE BUTTON (SMALL SCREEN) --}}

                    <x-primary-button wire:click.prevent="open('eligibility')" type="button"
                        class="bg-blue-400 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900">Add
                        Eligibility</x-primary-button>

                </div>
                <div class="relative">
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

                            {{-- ELIGIBILITY SEARCH --}}
                            <input wire:model.live='searchEligiblity' type="search" id="table-search-users"
                                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search eligibility">
                        </div>
                        <div class="flex flex-wrap mr-3 gap-2">
                            <x-dropdown align="right" width="30">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                        <div>{{ $filterEligibility }}</div>

                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
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
                                        class="block px-4 py-2 hover:bg-gray-100 cursor-pointer">All</x-dropdown-link>

                                    <!-- Authentication -->
                                    <x-dropdown-link wire:click.prevent="updateFilter(1, 'Archived')"
                                        class="block px-4 py-2 hover:bg-gray-100 cursor-pointer">Archived</x-dropdown-link>

                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>

                    {{-- ELIGIBILITY TABLE --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-300">

                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Eligibility Code
                                    </th>
                                    <th scope="col" class="px-6 py-3 hidden lg:table-cell">
                                        Eligibility Title
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-1/4">

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($eligibility->isEmpty())
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
                                                <p class="text-xl font-bold text-black text-center mt-2">
                                                    No Records Found!
                                                </p>
                                            </div>

                                        </td>
                                    </tr>
                                @else
                                    @foreach ($eligibility as $data)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div
                                                    class="hidden lg:block text-gray-500 font-medium text-lg uppercase">
                                                    {{ $data->eligibility_Code }}
                                                </div>
                                                <div class="block lg:hidden">
                                                    <div class="text-black font-bold text-md uppercase">
                                                        {{ $data->eligibility_Name }}
                                                    </div>
                                                    <div class=" text-gray-500 font-medium text-md uppercase">
                                                        {{ $data->eligibility_Code }}
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 hidden lg:table-cell">
                                                <div class="text-black font-bold text-lg uppercase">
                                                    {{ $data->eligibility_Name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-row items-center justify-center gap-6">
                                                    <div x-data="{ tooltip: 'Edit Eligibility' }">
                                                        <button
                                                            wire:click.prevent="editEligibility({{ $data->eligibility_type_id }})"
                                                            x-tooltip="tooltip" type="button"
                                                            class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    @if ($data->eligibility_Status == 1)
                                                        <div x-data="{ tooltip: 'Archive Eligibility' }">
                                                            <button x-tooltip="tooltip" type="button"
                                                                wire:click.prevent="archiveConfirmation(1, {{ $data->eligibility_type_id }})"
                                                                class="text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                                                <svg class="h-5 w-5"
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
                                                    @if ($data->eligibility_Status == 2)
                                                        <div x-data="{ tooltip: 'Restore Eligibility' }">
                                                            <button x-tooltip="tooltip" type="button"
                                                                wire:click.prevent="restoreConfirmation(1, {{ $data->eligibility_type_id }})"
                                                                class="text-green-700 border border-green-700 hover:bg-green-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                                                <svg class="h-5 w-5"
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
                </div>

                {{-- PAGINATION --}}
                <div class="mt-4">
                    {{ $eligibility->links('vendor.livewire.tailwind') }}
                </div>


            </div>


        </div>




        <div class="col-span-4 lg:col-span-6">
            {{-- @livewire('admin.eligibility-license.license-table') --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex flex-row justify-between mb-4">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold ">License List</h1>
                    </div>


                    <x-primary-button wire:click.prevent="open('license')" type="button"
                        class="bg-blue-400 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900">Add
                        License</x-primary-button>

                </div>
                <div class="relative overflow-x-auto">
                    <div class="flex flex-col lg:flex-row p-1 lg:justify-between gap-2 space-y-4 lg:space-y-0 pb-4">

                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>

                            {{-- ELIGIBILITY SEARCH --}}
                            <input type="search" wire:model.live='searchLicense' id="table-search-users"
                                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search license">
                        </div>

                        <div class="flex flex-wrap mr-3 gap-2">
                            <x-dropdown align="right" width="30">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                        <div>{{ $filterLicense }}</div>

                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
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
                                        class="block px-4 py-2 hover:bg-gray-100 cursor-pointer">All</x-dropdown-link>

                                    <!-- Authentication -->
                                    <x-dropdown-link wire:click.prevent="updateFilter(2, 'Archived')"
                                        class="block px-4 py-2 hover:bg-gray-100 cursor-pointer">Archived</x-dropdown-link>

                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        {{-- ELIGIBILITY TABLE --}}
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 ">
                                        Code
                                    </th>
                                    <th scope="col" class="px-6 py-3 hidden lg:table-cell">
                                        License
                                    </th>
                                    <th scope="col" class="px-6 py-3 w lg:w-1/4">

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($license->isEmpty())
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
                                                <p class="text-xl font-bold text-black text-center mt-2">
                                                    No Records Found!
                                                </p>
                                            </div>

                                        </td>
                                    </tr>
                                @else
                                    @foreach ($license as $data)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div
                                                    class="hidden lg:block text-gray-500 font-medium text-lg uppercase">
                                                    {{ $data->license_Code }}
                                                </div>
                                                <div class="block lg:hidden">
                                                    <div class="text-black font-bold text-md uppercase break-all">
                                                        {{ $data->license_Name }}
                                                    </div>
                                                    <div class=" text-gray-500 font-medium text-md uppercase">
                                                        {{ $data->license_Code }}
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 hidden lg:table-cell">
                                                <div class="text-black font-bold text-lg uppercase">
                                                    {{ $data->license_Name }}
                                                </div>
                                            </td>

                                            <td class="px-6 py-4">
                                                <div class="flex flex-row items-center justify-center gap-6">
                                                    <div x-data="{ tooltip: 'Edit License' }">
                                                        <button
                                                            wire:click.prevent="editLicense({{ $data->license_type_id }})"
                                                            x-tooltip="tooltip" type="button"
                                                            class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    @if ($data->license_Status == 1)
                                                        <div x-data="{ tooltip: 'Archive License' }">
                                                            <button x-tooltip="tooltip" type="button"
                                                                wire:click.prevent="archiveConfirmation(2, {{ $data->license_type_id }})"
                                                                class="text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                                                <svg class="h-5 w-5"
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
                                                    @if ($data->license_Status == 2)
                                                        <div x-data="{ tooltip: 'Restore License' }">
                                                            <button x-tooltip="tooltip" type="button"
                                                                wire:click.prevent="restoreConfirmation(2, {{ $data->license_type_id }})"
                                                                class="text-green-700 border border-green-700 hover:bg-green-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                                                <svg class="h-5 w-5"
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
                        <div class="mt-4">
                            {{ $license->links('vendor.livewire.tailwind') }}
                        </div>
                    </div>

                    {{-- PAGINATION --}}



                </div>


            </div>


            <x-modal name="eligibility-modal" focusable>
                <div class="w-full max-w-4xl px-6 py-6 items-center border-b">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Manage Eligibility Record') }}
                    </h2>
                    <hr>
                    <div class="flex flex-col lg:flex-row gap-2 lg:gap-6 mt-2 w-full">

                        <div class="flex flex-col mt-2 w-full">
                            <x-input-label for="eligibilityPost" :value="__('Eligibility Title')" />
                            <x-text-input wire:model='eligibilityPost' id="eligibilityPost"
                                class="block mt-1 w-full uppercase" type="text" name="eligibilityPost" />
                            <x-input-error :messages="$errors->get('eligibilityPost')" class="mt-2" />
                        </div>


                        <div class="flex flex-col mt-2 w-full">
                            <x-input-label for="ecodePost" :value="__('Eligibility Code')" />
                            <x-text-input wire:model='ecodePost' id="ecodePost" class="block mt-1 w-full uppercase"
                                type="text" name="ecodePost" />
                            <x-input-error :messages="$errors->get('ecodePost')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button wire:click.prevent="close('eligibility')" type="button">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button wire:click.prevent='saveEligibility' class="ms-3" type="button"
                            id="eligibilityAdd">
                            {{ __('Save Eligibility') }}
                        </x-primary-button>
                    </div>
                </div>
            </x-modal>
            <x-modal name="license-modal" focusable>
                <div class="w-full max-w-4xl px-6 py-6 items-center border-b">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Manage License Record') }}
                    </h2>
                    <hr>
                    <div class="flex flex-col lg:flex-row gap-2 lg:gap-6 mt-2 w-full">

                        <div class="flex flex-col mt-2 w-full">
                            <x-input-label for="licensePost" :value="__('License Title')" />
                            <x-text-input wire:model='licensePost' id="licensePost"
                                class="block mt-1 w-full uppercase" type="text" name="licensePost" />
                            <x-input-error :messages="$errors->get('licensePost')" class="mt-2" />
                        </div>


                        <div class="flex flex-col mt-2 w-full">
                            <x-input-label for="lcodePost" :value="__('License Code')" />
                            <x-text-input wire:model='lcodePost' id="lcodePost" class="block mt-1 w-full uppercase"
                                type="text" name="lcodePost" />
                            <x-input-error :messages="$errors->get('lcodePost')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button wire:click.prevent="close('license')" type="button">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button wire:click.prevent='saveLicense' class="ms-3" type="button"
                            id="eligibilityAdd">
                            {{ __('Save License') }}
                        </x-primary-button>
                    </div>
                </div>
            </x-modal>



            <x-modal name="delete-eligibility-modal" focusable>
                <div class="w-full max-w-4xl px-6 py-6 items-center">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Action Confirmation') }}
                    </h2>
                    <hr>
                    <div class="flex flex-col justify-center items-center my-12">

                        <h1 class="text-2xl font-bold">Are you sure you want to archive this eligibility?</h1>


                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-eligibility-modal')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button wire:loading.attr="disabled" wire:click.prevent="confirmArchive(1)"
                            class="ms-3" type="button">
                            {{ __('Confirm') }}
                            <div wire:loading.delay.long wire:target="confirmArchive(1)" role="status">
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
            <x-modal name="delete-license-modal" focusable>
                <div class="w-full max-w-4xl px-6 py-6 items-center">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Action Confirmation') }}
                    </h2>
                    <hr>
                    <div class="flex flex-col justify-center items-center my-12">

                        <h1 class="text-2xl font-bold">Are you sure you want to archive this license?</h1>


                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-license-modal')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button wire:loading.attr="disabled" wire:click.prevent="confirmArchive(2)"
                            class="ms-3" type="button">
                            {{ __('Confirm') }}
                            <div wire:loading.delay.long wire:target="confirmArchive(2)" role="status">
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
            <x-modal name="restore-eligibility-modal" focusable>
                <div class="w-full max-w-4xl px-6 py-6 items-center">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Action Confirmation') }}
                    </h2>
                    <hr>
                    <div class="flex flex-col justify-center items-center my-12">

                        <h1 class="text-2xl font-bold">Are you sure you want to restore this eligibility?</h1>


                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close-modal', 'restore-eligibility-modal')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-green-button wire:loading.attr="disabled" wire:click.prevent="confirmRestore(1)"
                            class="ms-3" type="button">
                            {{ __('Confirm') }}
                            <div wire:loading.delay.long wire:target="confirmRestore(1)" role="status">
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
            <x-modal name="restore-license-modal" focusable>
                <div class="w-full max-w-4xl px-6 py-6 items-center">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Action Confirmation') }}
                    </h2>
                    <hr>
                    <div class="flex flex-col justify-center items-center my-12">

                        <h1 class="text-2xl font-bold">Are you sure you want to restore this license?</h1>


                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close-modal', 'restore-license-modal')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-green-button wire:loading.attr="disabled" wire:click.prevent="confirmRestore(2)"
                            class="ms-3" type="button">
                            {{ __('Confirm') }}
                            <div wire:loading.delay.long wire:target="confirmRestore(2)" role="status">
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

        </div>
    </div>
