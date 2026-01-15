<div wire:poll.5s class="container py-8 mx-auto">

    {{-- GRID --}}
    <div class="grid grid-cols-4 gap-4 p-3 sm:grid-cols-12 sm:p-0">

        {{-- TITLE --}}
        <div class="col-span-4 sm:col-span-12">
            <h1 class="text-2xl font-bold">Data Management / Location </h1>
        </div>

        {{-- TABLE CONTAINER --}}
        <div class="col-span-4 sm:col-span-6">


            <div class="p-6 bg-white rounded-lg shadow">
                <div class="relative overflow-x-auto">

                    <div class="flex flex-col gap-2 p-1 pb-4 space-y-4 sm:flex-row sm:justify-between sm:space-y-0">


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
                            <input wire:model.live="search" type="search"
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 sm:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search">
                        </div>

                        {{-- ADD BUTTON --}}
                        <div class="flex flex-wrap gap-2 mr-3">

                            <div class="flex flex-row items-center">
                                <h1 class="mr-2 font-semibold text-md">Filter by:</h1>
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button
                                            class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                            <div>{{ $defaultFilter }}</div>

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

                                        <x-dropdown-link wire:click.prevent="locationFilter('Barangay')"
                                            class="block px-4 py-2 cursor-pointer hover:bg-gray-100">Barangay</x-dropdown-link>

                                        <!-- Authentication -->
                                        <x-dropdown-link wire:click.prevent="locationFilter('Municipalities')"
                                            class="block px-4 py-2 cursor-pointer hover:bg-gray-100">Municipalities</x-dropdown-link>

                                        <x-dropdown-link wire:click.prevent="locationFilter('Provinces')"
                                            class="block px-4 py-2 cursor-pointer hover:bg-gray-100">Provinces</x-dropdown-link>

                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>


                    </div>





                    {{-- TABLE BARANGAY/LOCATION --}}
                    @if ($defaultFilter === 'Barangay')
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-center text-gray-500 rtl:text-right">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Barangay
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 sm:table-cell">
                                            Municipality
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 sm:table-cell">
                                            Province
                                        </th>
                                        <th scope="col" class="px-6 py-3">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($locationData->isEmpty())
                                        <tr>
                                            <td colspan="4">
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
                                        @foreach ($locationData as $data)
                                            <tr wire:key='barangay-{{ $data->barangay_id }}'
                                                class="bg-white border-b hover:bg-gray-50">
                                                <td class="px-6 py-4">
                                                    <div class="font-semibold text-black uppercase">
                                                        {{ $data->barangay_Name }}
                                                        <div class="block sm:hidden">
                                                            <div class="font-semibold text-black uppercase">
                                                                {{ $data->municipality->municipality_Name }},
                                                                {{ $data->municipality->province->province_Name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="hidden px-6 py-4 sm:table-cell">
                                                    <div class="font-semibold text-black uppercase">
                                                        {{ $data->municipality->municipality_Name }}</div>
                                                </td>
                                                <td class="hidden px-6 py-4 sm:table-cell">
                                                    <div class="font-semibold text-black uppercase">
                                                        {{ $data->municipality->province->province_Name }}
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="flex flex-row items-center justify-center gap-6">
                                                        <div x-data="{ tooltip: 'Edit Barangay' }">
                                                            <button
                                                                wire:click.prevent="editLocation('barangay', {{ $data->barangay_id }})"
                                                                x-tooltip="tooltip" type="button"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke-width="1.5" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        {{-- <div x-data="{ tooltip: 'Delete Barangay' }">
                                                            <button x-tooltip="tooltip" type="button"
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
                                                        </div> --}}

                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @elseif ($defaultFilter === 'Municipalities')
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-center text-gray-500 rtl:text-right">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Municipality
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 sm:table-cell">
                                            Province
                                        </th>
                                        <th scope="col" class="px-6 py-3">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($locationData->isEmpty())
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
                                        @foreach ($locationData as $data)
                                            <tr class="bg-white border-b hover:bg-gray-50 ">
                                                <td class="px-6 py-4">
                                                    <div class="font-semibold text-black uppercase">
                                                        {{ $data->municipality_Name }}
                                                        <div class="font-semibold text-black uppercase">
                                                            {{ $data->province->province_Name }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="hidden px-6 py-4 sm:table-cell">
                                                    <div class="font-semibold text-black uppercase">
                                                        {{ $data->province->province_Name }}
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4">
                                                    <div class="flex flex-row items-center justify-center gap-6">
                                                        <div x-data="{ tooltip: 'Edit Municipality' }">
                                                            <button
                                                                wire:click.prevent="editLocation('municipality', {{ $data->municipality_id }})"
                                                                x-tooltip="tooltip" type="button"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        {{-- <div x-data="{ tooltip: 'Delete Municipality' }">
                                                            <button x-tooltip="tooltip" type="button"
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
                                                        </div> --}}

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @elseif ($defaultFilter === 'Provinces')
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-center text-gray-500 rtl:text-right">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Province
                                        </th>
                                        <th scope="col" class="px-6 py-3">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($locationData->isEmpty())
                                        <tr>
                                            <td colspan="2">
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
                                        @foreach ($locationData as $data)
                                            <tr class="bg-white border-b hover:bg-gray-50">
                                                <td class="px-6 py-4">
                                                    <div class="font-semibold text-black uppercase">
                                                        {{ $data->province_Name }}
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4">
                                                    <div class="flex flex-row items-center justify-center gap-6">
                                                        <div x-data="{ tooltip: 'Edit Province' }">
                                                            <button
                                                                wire:click.prevent="editLocation('province', {{ $data->province_id }})"
                                                                x-tooltip="tooltip" type="button"
                                                                class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                                <svg class="w-5 h-5"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        {{-- <div x-data="{ tooltip: 'Delete Province' }">
                                                            <button x-tooltip="tooltip" type="button"
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
                                                        </div> --}}

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <div class="mt-4">
                    {{ $locationData->links('vendor.livewire.tailwind') }}
                </div>
            </div>




        </div>



        <div class="col-span-4 sm:col-span-6" x-data="{
            openTab: 1,
            activeClasses: 'text-gray-900 bg-gray-100 active',
            inactiveClasses: 'bg-white hover:text-gray-700 hover:bg-gray-50'
        }">
            <div class="p-6 bg-white rounded-lg shadow">

                <h1 class="mb-4 text-2xl font-bold">Add Locations</h1>



                <div class="sm:hidden">
                    <label for="tabs" class="sr-only">Select your country</label>
                    <select id="tabs"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        x-on:change="openTab = parseInt($event.target.value)">
                        <option value="1">Barangay</option>
                        <option value="2">Municipality</option>
                        <option value="3">Province</option>
                    </select>
                </div>
                <ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow-lg sm:flex ">
                    <li class="w-full focus-within:z-10">
                        <button x-on:click="openTab = 1" :class="openTab === 1 ? activeClasses : inactiveClasses"
                            class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none rounded-s-lg">Barangay</button>
                    </li>
                    <li class="w-full focus-within:z-10">
                        <button x-on:click="openTab = 2" :class="openTab === 2 ? activeClasses : inactiveClasses"
                            class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none ">Municipality</button>
                    </li>
                    <li class="w-full focus-within:z-10">
                        <button x-on:click="openTab = 3" :class="openTab === 3 ? activeClasses : inactiveClasses"
                            class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none rounded-e-lg">Province</button>
                    </li>

                </ul>

                <div x-show="openTab === 1" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">

                    <div class="flex flex-col w-full gap-2 mt-6 md:flex-row md:gap-6">


                        <div class="flex flex-col w-full mt-2">
                            <x-input-label for="barPost" :value="__('Barangay Title')" />
                            <x-text-input wire:model="barPost" class="block w-full mt-1 uppercase" type="text" />
                            <x-input-error :messages="$errors->get('barPost')" class="mt-2" />
                        </div>

                        <div class="flex flex-col w-full mt-2">
                            <x-input-label for="bcodePost" :value="__('Barangay Code')" />
                            <x-text-input wire:model="bcodePost" class="block w-full mt-1 uppercase"
                                type="text" />
                            <x-input-error :messages="$errors->get('bcodePost')" class="mt-2" />
                        </div>


                        <div class="flex flex-col w-full mt-2">
                            <x-input-label for="municipalitySelect" :value="__('Municipality')" />
                            <x-text-input wire:model="munSelect" class="block w-full mt-1 uppercase" type="text"
                                placeholder="Select Municipality" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'municipality-modal')"
                                x-on:focus="$dispatch('open-modal', 'municipality-modal')" readonly />
                            <x-input-error :messages="$errors->get('munSelect')" class="mt-2" />

                        </div>
                    </div>

                    <div class="flex flex-row mt-6 w-ful ">
                        <x-green-button wire:click.prevent="saveLocation('barangay')" type="submit"
                            class="ml-auto mr-3">
                            {{ __('Add Barangay') }}
                            <div wire:loading.delay.long wire:target="saveLocation('barangay')" role="status">
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

                <div x-show="openTab === 2" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>
                    <div class="flex flex-col w-full ">
                        <div class="flex flex-col w-full gap-2 mt-6 md:flex-row md:gap-6">


                            <div class="flex flex-col w-full mt-2">
                                <x-input-label for="munPost" :value="__('Municipality Title')" />
                                <x-text-input wire:model="munPost" class="block w-full mt-1 uppercase" type="text"
                                    name="munPost" />
                                <x-input-error :messages="$errors->get('munPost')" class="mt-2" />
                            </div>

                            <div class="flex flex-col w-full mt-2">
                                <x-input-label for="mcodePost" :value="__('Municipality Code')" />
                                <x-text-input wire:model="mcodePost" class="block w-full mt-1 uppercase"
                                    type="text" name="mcodePost" />
                                <x-input-error :messages="$errors->get('mcodePost')" class="mt-2" />
                            </div>


                            <div class="flex flex-col w-full mt-2">
                                <x-input-label for="provSelect" :value="__('Province')" />
                                <x-text-input wire:model="provSelect" class="block w-full mt-1 uppercase"
                                    type="text" name="provSelect" placeholder="Select Province"
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'province-modal')"
                                    x-on:focus="$dispatch('open-modal', 'province-modal')" readonly />
                                <x-input-error :messages="$errors->get('provSelect')" class="mt-2" />
                                <x-text-input wire:model="provHidden" type="hidden" readonly />
                            </div>
                        </div>

                        <div class="flex flex-row mt-6 w-ful ">
                            <x-green-button wire:click.prevent="saveLocation('municipality')" type="submit"
                                class="ml-auto mr-3">
                                {{ __('Add Municipality') }}
                                <div wire:loading.delay.long wire:target="saveLocation('municipality')"
                                    role="status">
                                    <svg aria-hidden="true"
                                        class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
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
                </div>

                <div x-show="openTab === 3" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-cloak>
                    <div class="flex flex-col w-full">
                        <div class="flex flex-col w-full gap-2 mt-6 md:flex-row md:gap-6">


                            <div class="flex flex-col w-1/2 mt-2">
                                <x-input-label for="provPost" :value="__('Province Title')" />
                                <x-text-input wire:model="provPost" class="block w-full mt-1 uppercase"
                                    type="text" name="provPost" />
                                <x-input-error :messages="$errors->get('provPost')" class="mt-2" />
                            </div>
                            <div class="flex flex-col w-1/2 mt-2">
                                <x-input-label for="pcodePost" :value="__('Province Code')" />
                                <x-text-input wire:model="pcodePost" class="block w-full mt-1 uppercase"
                                    type="text" name="pcodePost" />
                                <x-input-error :messages="$errors->get('pcodePost')" class="mt-2" />
                            </div>
                        </div>



                        <div class="flex flex-row mt-6 w-ful ">
                            <x-green-button wire:click.prevent="saveLocation('province')" type="submit"
                                class="ml-auto mr-3">
                                {{ __('Add Province') }}
                                <div wire:loading.delay.long wire:target="saveLocation('province')" role="status">
                                    <svg aria-hidden="true"
                                        class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
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
                </div>





            </div>
        </div>

    </div>
    {{-- MODALS --}}

    <x-modal name="municipality-modal" focusable>
        <div class="flex flex-col w-full px-6 py-6 ">

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Choose a Municipality') }}
            </h2>
            <hr>

            <div class="relative mt-4">
                <div
                    class="flex flex-wrap items-center justify-between pb-4 space-y-4 flex-column md:flex-row md:space-y-0">

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

                        {{-- LICENSE SEARCH --}}
                        <input wire:model.live.prevent="searchMun" type="text"
                            class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 w-60 md:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search municipality">
                    </div>

                </div>

                {{-- LICENSE MODAL --}}
                <table class="w-full text-sm text-center text-gray-500 rtl:text-right">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                        <tr>
                            <th scope="col" class="w-1/4 px-6 py-3">

                            </th>
                            <th scope="col" class="px-6 py-3 uppercase">
                                Municipality, Province
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($municipalities->isEmpty())
                            <tr>
                                <td colspan="2">
                                    <div class="flex flex-col items-center justify-center mt-24 mb-24">
                                        <div class="p-6 bg-gray-100 rounded-full">
                                            <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                            </svg>

                                        </div>
                                        <p class="mt-2 text-xl font-bold text-center text-black">
                                            No Record Found
                                        </p>
                                    </div>

                                </td>
                            </tr>
                        @else
                            @foreach ($municipalities as $data)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-center">

                                        <button
                                            wire:click.prevent="selectLocation('municipality',{{ $data->municipality_id }})"
                                            x-data="" x-on:click.prevent="$dispatch('close')"
                                            class="text-blue-500 hover:underline">Select</button>

                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-base font-semibold uppercase">{{ $data->municipality_Name }},
                                            {{ $data->province->province_Name }} </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div>
                {{ $municipalities->links('vendor.livewire.tailwind') }}

            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button wire:click.prevent="close('municipality')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>
            </div>


        </div>
    </x-modal>

    <x-modal name="province-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Choose a Province') }}
            </h2>
            <hr>

            <div class="relative mt-4">
                <div
                    class="flex flex-wrap items-center justify-between pb-4 space-y-4 flex-column md:flex-row md:space-y-0">

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
                        <input wire:model.live.prevent="searchProv" type="text"
                            class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 w-60 md:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search province">
                    </div>

                    {{-- WEB BUTTON --}}
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-center text-gray-500 rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                            <tr>
                                <th scope="col" class="w-1/4 px-6 py-3">

                                </th>
                                <th scope="col" class="px-6 py-3 uppercase">
                                    Province
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($provinces->isEmpty())
                                <tr>
                                    <td colspan="2">
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
                                                No Record Found
                                            </p>
                                        </div>

                                    </td>
                                </tr>
                            @else
                                @foreach ($provinces as $data)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 text-center">

                                            <button
                                                wire:click.prevent="selectLocation('province',{{ $data->province_id }})"
                                                class="text-blue-500 hover:underline" x-data=""
                                                x-on:click.prevent="$dispatch('close')">Select</button>

                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-base font-semibold uppercase">{{ $data->province_Name }}
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
            <div>
                {{ $provinces->links('vendor.livewire.tailwind') }}

            </div>

            <div class="flex justify-end mt-6">
                <x-secondary-button wire:click.prevent="close('province')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>
            </div>


        </div>

    </x-modal>

    <x-modal name="bar-edit-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Edit Barangay') }}
            </h2>
            <hr>

            <div class="flex flex-col w-full gap-6 mt-6 ">
                <div class="flex flex-col w-full gap-2 mt-2 sm:flex-row sm:gap-6">
                    <div class="flex flex-col w-full mt-2">
                        <x-input-label for="barPost" :value="__('Barangay Title')" />
                        <x-text-input wire:model="editbarPost" class="block w-full mt-1 uppercase" type="text" />
                        <x-input-error :messages="$errors->get('editbarPost')" class="mt-2" />
                    </div>

                    <div class="flex flex-col w-full mt-2">
                        <x-input-label for="bcodePost" :value="__('Barangay Code')" />
                        <x-text-input wire:model="editbcodePost" class="block w-full mt-1 uppercase"
                            type="text" />
                        <x-input-error :messages="$errors->get('editbcodePost')" class="mt-2" />
                    </div>
                </div>


                <div class="flex flex-col w-full">

                    <x-input-label for="barPost" class="mb-2" :value="__('Municipality')" />
                    <x-dropdown align="left" width="[300px]">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-1.5 py-2 w-[300px]">
                                <div class="w-full ml-2 text-left uppercase">{{ $editmunSelect }}</div>
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
                            <!-- Search input -->
                            <div class="p-2">
                                <input wire:model.live.prevent='searchMun' type="text" placeholder="Search..."
                                    class="block w-full px-3 py-1.5 mb-2 border border-gray-300 rounded-md focus:outline-none"
                                    @click.stop>
                            </div>

                            <!-- Dropdown content with scrollbar -->
                            <div class="max-h-[150px] bg-white overflow-y-auto no-scrollbar">
                                <!-- Dropdown links -->
                                @foreach ($municipalities as $data)
                                    <x-dropdown-link
                                        wire:click.prevent="setLocation('municipality','{{ $data->municipality_id }}')"
                                        class="block px-4 py-2 uppercase cursor-pointer hover:bg-gray-100">{{ $data->municipality_Name }}
                                        ,
                                        {{ $data->province->province_Name }}</x-dropdown-link>
                                @endforeach
                            </div>
                        </x-slot>

                    </x-dropdown>
                    <x-input-error :messages="$errors->get('editmunHidden')" class="mt-2" />

                </div>

            </div>

            <div class="flex justify-end mt-6">
                <x-secondary-button wire:click.prevent="close('bar-edit')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent="updateLocation('barangay')" type="submit" class="ms-3">
                    {{ __('Save') }}
                    <div wire:loading.delay.long wire:target="updateLocation('barangay')" role="status">
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
    </x-modal>

    <x-modal name="mun-edit-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Edit Municipality') }}
            </h2>
            <hr>

            <div class="flex flex-col w-full gap-6 mt-6 ">
                <div class="flex flex-col w-full gap-2 mt-2 sm:flex-row sm:gap-6">
                    <div class="flex flex-col w-full mt-2">
                        <x-input-label for="munPost" :value="__('Municipality Title')" />
                        <x-text-input wire:model="editmunPost" class="block w-full mt-1 uppercase" type="text" />
                        <x-input-error :messages="$errors->get('editmunPost')" class="mt-2" />
                    </div>

                    <div class="flex flex-col w-full mt-2">
                        <x-input-label for="mcodePost" :value="__('Municipality Code')" />
                        <x-text-input wire:model="editmcodePost" class="block w-full mt-1 uppercase"
                            type="text" />
                        <x-input-error :messages="$errors->get('editmcodePost')" class="mt-2" />
                    </div>
                </div>


                <div class="flex flex-col">


                    <x-input-label for="provSelect" class="mb-2" :value="__('Province')" />
                    <x-dropdown align="left" width="80">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex text-left text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 w-[150px]">
                                <div class="w-full uppercase">{{ $editprovSelect }}</div>
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
                            <!-- Search input -->
                            <div class="p-2">
                                <input wire:model.live.prevent='searchProv' type="text" placeholder="Search..."
                                    class="block w-full px-3 py-1.5 mb-2 border border-gray-300 rounded-md focus:outline-none"
                                    @click.stop>
                            </div>

                            <!-- Dropdown content with scrollbar -->
                            <div class="max-h-[150px] bg-white overflow-y-auto no-scrollbar">
                                <!-- Dropdown links -->
                                @foreach ($provinces as $data)
                                    <x-dropdown-link 
                                        wire:click.prevent="setLocation('province','{{ $data->province_id }}')"
                                        class="block px-4 py-2 uppercase cursor-pointer hover:bg-gray-100">
                                        {{ $data->province_Name }}</x-dropdown-link>
                                @endforeach
                            </div>
                        </x-slot>

                    </x-dropdown>
                    <x-input-error :messages="$errors->get('editmunHidden')" class="mt-2" />
                </div>

            </div>

            <div class="flex justify-end mt-6">
                <x-secondary-button wire:click.prevent="close('mun-edit')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent="updateLocation('municipality')" type="submit"
                    class="ms-3">{{ __('Save') }}
                    <div wire:loading.delay.long wire:target="updateLocation('municipality')" role="status">
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
    </x-modal>

    <x-modal name="prov-edit-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Edit Province') }}
            </h2>
            <hr>

            <div class="flex flex-col w-full gap-6 mt-6 ">
                <div class="flex flex-col w-full gap-2 mt-2 sm:flex-row sm:gap-6">
                    <div class="flex flex-col w-full mt-2">
                        <x-input-label for="editprovPost" :value="__('Province Title')" />
                        <x-text-input wire:model="editprovPost" class="block w-full mt-1 uppercase" type="text" />
                        <x-input-error :messages="$errors->get('editprovPost')" class="mt-2" />
                    </div>

                    <div class="flex flex-col w-full mt-2">
                        <x-input-label for="editpcodePost" :value="__('Province Code')" />
                        <x-text-input wire:model="editpcodePost" class="block w-full mt-1 uppercase"
                            type="text" />
                        <x-input-error :messages="$errors->get('editpcodePost')" class="mt-2" />
                    </div>
                </div>



            </div>

            <div class="flex justify-end mt-6">
                <x-secondary-button wire:click.prevent="close('prov-edit')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent="updateLocation('province')" type="submit" class="ms-3">
                    {{ __('Save') }}
                    <div wire:loading.delay.long wire:target="updateLocation('province')" role="status">
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
    </x-modal>





</div>
