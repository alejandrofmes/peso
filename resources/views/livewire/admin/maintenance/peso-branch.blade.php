<div wire:poll.5s class="container py-8 mx-auto">
    {{-- GRID --}}
    <div class="grid grid-cols-4 gap-4 p-3 lg:grid-cols-12 lg:p-0">

        {{-- TITLE --}}
        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Maintenance / PESO Branches</h1>
        </div>

        <div class="col-span-4 lg:col-span-6">
            {{-- @livewire('admin.requirements.requirements-table') --}}
            <div class="p-6 bg-white rounded-lg shadow">

                {{-- TITLE --}}
                {{-- <div class="flex items-center mb-2">
                    <h1 class="text-xl font-bold">PESO Branches</h1>
                </div> --}}

                <div class="relative overflow-x-auto">

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
                            <input wire:model.live='search' type="search" id="table-search-users"
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search">
                        </div>
                        {{-- ADD BUTTON --}}
                        <div class="flex flex-wrap gap-2 mr-3">


                            {{-- <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                        <div>
                                            {{ $filter == 8 ? 'PESO Consultant' : ($filter == 9 ? 'PESO Officer' : 'All') }}
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
                                        max-h-[200px] bg-white
                                    </x-slot>

                                    <x-dropdown-link href="#" wire:click="updateFilter('')"
                                        class="block px-4 py-2 hover:bg-gray-100">All</x-dropdown-link>
                                    <hr>
                                    <!-- Authentication -->
                                    <x-dropdown-link href="#" wire:click="updateFilter('8')"
                                        class="block px-4 py-2 hover:bg-gray-100">PESO Consultant</x-dropdown-link>

                                    <x-dropdown-link href="#" wire:click="updateFilter('9')"
                                        class="block px-4 py-2 hover:bg-gray-100">PESO Officer</x-dropdown-link>

                                    </form>
                                </x-slot>
                            </x-dropdown> --}}

                        </div>



                    </div>

                    {{-- REQUIREMENT TABLE --}}
                    <table class="w-full text-sm text-left text-gray-500 rtl:text-right ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                            <tr>
                                <th scope="col" class="w-1/4 px-6 py-3">
                                    PESO ID
                                </th>
                                <th scope="col" class="w-1/4 px-6 py-3">
                                    Municipality
                                </th>
                                <th scope="col" class="w-full px-6 py-3">
                                    PESO Manager
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Created
                                </th>
                                <th scope="col" class="px-6 py-3">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($pesoData->isEmpty())
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
                                            <p class="mt-2 text-xl font-bold text-center text-black">
                                                No Records Found!
                                            </p>
                                        </div>

                                    </td>
                                </tr>
                            @else
                                @foreach ($pesoData as $data)
                                    <tr wire:key='peso-data' class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            {{ $data->peso_id }}
                                        </td>
                                        <th scope="row" class="text-gray-900 whitespace-nowrap">

                                            <div class="ps-3 text-wrap">
                                                <div class="text-base font-semibold">
                                                    <div class="text-base font-semibold uppercase">
                                                        {{ $data->municipality->municipality_Name }}

                                                    </div>

                                                </div>

                                            </div>


                                        </th>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center uppercase">
                                                @foreach ($data->peso_accounts as $account)
                                                    <div class="text-sm font-semibold uppercase">
                                                        {{ $account->peso_accounts_Fname }}
                                                        {{ $account->peso_accounts_Mname ?? '' }}
                                                        {{ $account->peso_accounts_Lname }}

                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $data->peso_accounts_count }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="text-base font-light uppercase">
                                                {{ $data->created_at->format('h:i A') }}
                                            </div>
                                            <div class="text-base font-medium uppercase">
                                                {{ $data->created_at->format('F d Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">

                                            <div class="flex flex-row items-center justify-center gap-6">
                                                <div x-data="{ tooltip: 'PESO Account Overview' }">
                                                    <button wire:click='selectBranch({{ $data->peso_id }})'
                                                        x-tooltip="tooltip" type="button"
                                                        class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24" fill="currentColor">
                                                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                            <path fill-rule="evenodd"
                                                                d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>
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
                    {{-- {{ $adminAccounts->links('vendor.livewire.tailwind') }} --}}
                </div>

            </div>

        </div>




        <div class="col-span-4 lg:col-span-6">
            <div class="p-6 bg-white rounded-lg shadow" x-data="{
                selectedBranch: @entangle('selectedBranch')
            }">


                <div class="">

                    <div x-show="!selectedBranch" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-cloak>
                        <h1 class="text-xl font-bold ">Create PESO Branch</h1>
                        <hr class="h-px my-2 bg-gray-200 border-0">

                        <div class="flex flex-col w-full">
                            <x-input-label for="phone" :value="__('PESO Municipality')" />
                            <x-dropdown align="left" width="full">
                                <x-slot name="trigger">
                                    <button
                                        class="mt-1 inline-flex h-full items-center text-gray-800 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-md px-1.5 py-2 w-full">
                                        <div class="w-full ml-2 font-mono text-xl font-extrabold text-left ">
                                            {{ $mun && $prov ? $mun . ', ' . $prov : 'Select a Municipality' }}


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
                                    <!-- Search input -->
                                    <div class="p-2">
                                        <input wire:model.live.prevent='searchMun' type="text"
                                            placeholder="Search..."
                                            class="block w-full px-3 py-1.5 mb-2 border border-gray-300 rounded-md focus:outline-none"
                                            @click.stop>
                                    </div>

                                    <!-- Dropdown content with scrollbar -->
                                    <div class="max-h-[300px] bg-white overflow-y-auto">
                                        <!-- Dropdown links -->
                                        @foreach ($municipalityData as $data)
                                            <x-dropdown-link
                                                wire:click.prevent='selectMunicipality({{ $data->municipality_id }})'
                                                class="block px-4 py-2 uppercase cursor-pointer hover:bg-gray-100">{{ $data->municipality_Name }},
                                                {{ $data->province->province_Name }}</x-dropdown-link>
                                        @endforeach
                                    </div>
                                </x-slot>

                            </x-dropdown>
                            <x-input-error :messages="$errors->get('munID')" class="mt-2" />

                        </div>
                        <div class="mt-4">
                            <h1 class="text-lg font-bold">PESO Manager </h1>
                            <hr class="h-px my-2 bg-gray-200 border-0">
                            <div class="flex flex-col w-full gap-2 lg:flex-row ">
                                <div class="flex flex-col w-full mt-2">
                                    <x-input-label for="fname" :value="__('First Name*')" />
                                    <x-text-input wire:model="fname" class="block w-full mt-1" type="text" />
                                    <x-input-error :messages="$errors->get('fname')" class="mt-2" />
                                </div>
                                <div class="flex flex-col w-full mt-2">
                                    <x-input-label for="mname" :value="__('Middle Name')" />
                                    <x-text-input wire:model="mname" class="block w-full mt-1" type="text" />
                                    <x-input-error :messages="$errors->get('mname')" class="mt-2" />
                                </div>
                                <div class="flex flex-col w-full mt-2">
                                    <x-input-label for="lname" :value="__('Last Name*')" />
                                    <x-text-input wire:model="lname" class="block w-full mt-1" type="text" />
                                    <x-input-error :messages="$errors->get('lname')" class="mt-2" />
                                </div>

                            </div>
                            <div class="flex flex-col w-full gap-2 mt-6 lg:flex-row ">

                                <div class="flex flex-col w-full mt-2">
                                    <x-input-label for="email" :value="__('Email*')" />
                                    <x-text-input wire:model="email" class="block w-full mt-1" type="email" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div class="flex flex-col w-full mt-2">
                                    <x-input-label for="phone" :value="__('Phone Number*')" />
                                    <x-text-input wire:model="phone" class="block w-full mt-1" type="tel" />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>
                            </div>
                            <div class="flex flex-row justify-end w-full mt-6">
                                <x-green-button wire:click.prevent='validateAccount' type="submit"
                                    class="ml-auto mr-3">
                                    {{ __('Create') }}
                                </x-green-button>

                            </div>

                        </div>
                    </div>

                    <div x-show="selectedBranch" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-cloak>
                        @if ($this->selectedBranch)
                            <div class="flex flex-row items-center gap-4">
                                <button wire:click.prevent='resetValues'>
                                    <div
                                        class="flex items-center p-1 transition-transform rounded-full hover:bg-gray-300">
                                        <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                        </svg>
                                    </div>
                                </button>
                                <h1 class="text-xl font-bold ">Update PESO
                                    {{ $pesoBranch->municipality->municipality_Name }} Manager</h1>
                            </div>
                            <hr class="h-px my-2 bg-gray-200 border-0">

                            <div x-data="{
                                selectedOption: @entangle('option')
                            
                            
                            }">
                                <div class="flex flex-row w-full gap-5">
                                    <!-- Radio button for creating new manager -->
                                    <div class="flex items-center w-full border border-gray-200 rounded ps-4">
                                        <input wire:model='option' id="bordered-radio-1" type="radio"
                                            value="1" name="bordered-radio" x-model="selectedOption"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                        <label for="bordered-radio-1"
                                            class="w-full py-4 text-sm font-medium text-gray-900 ms-2">Create New
                                            Manager</label>
                                    </div>
                                    <!-- Radio button for selecting existing manager -->
                                    <div class="flex items-center w-full border border-gray-200 rounded ps-4">
                                        <input wire:model='option' id="bordered-radio-2" type="radio"
                                            value="2" name="bordered-radio" x-model="selectedOption"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                        <label for="bordered-radio-2"
                                            class="w-full py-4 text-sm font-medium text-gray-900 ms-2">Select Existing
                                            Manager</label>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('option')" class="mt-2 " />


                                <!-- Conditional rendering based on the selected radio button -->

                                <div x-show="selectedOption === '1'" class="mt-4">
                                    <h1 class="text-lg font-bold">Create PESO Manager</h1>
                                    <hr class="h-px my-2 bg-gray-200 border-0">
                                    <div class="flex flex-col w-full gap-2 lg:flex-row">
                                        <div class="flex flex-col w-full mt-2">
                                            <x-input-label for="fname" :value="__('First Name*')" />
                                            <x-text-input wire:model="fname" class="block w-full mt-1"
                                                type="text" />
                                            <x-input-error :messages="$errors->get('fname')" class="mt-2" />
                                        </div>
                                        <div class="flex flex-col w-full mt-2">
                                            <x-input-label for="mname" :value="__('Middle Name')" />
                                            <x-text-input wire:model="mname" class="block w-full mt-1"
                                                type="text" />
                                            <x-input-error :messages="$errors->get('mname')" class="mt-2" />
                                        </div>
                                        <div class="flex flex-col w-full mt-2">
                                            <x-input-label for="lname" :value="__('Last Name*')" />
                                            <x-text-input wire:model="lname" class="block w-full mt-1"
                                                type="text" />
                                            <x-input-error :messages="$errors->get('lname')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="flex flex-col w-full gap-2 mt-6 lg:flex-row">
                                        <div class="flex flex-col w-full mt-2">
                                            <x-input-label for="email" :value="__('Email*')" />
                                            <x-text-input wire:model="email" class="block w-full mt-1"
                                                type="email" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>
                                        <div class="flex flex-col w-full mt-2">
                                            <x-input-label for="phone" :value="__('Phone Number*')" />
                                            <x-text-input wire:model="phone" class="block w-full mt-1"
                                                type="tel" />
                                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                        </div>
                                    </div>

                                </div>
                                <div x-show="selectedOption === '2'" class="flex flex-col w-full mt-4">

                                    <h1 class="text-lg font-bold">Select PESO Manager</h1>

                                    <hr class="h-px my-2 bg-gray-200 border-0">
                                    <x-dropdown align="left" width="full">
                                        <x-slot name="trigger">
                                            <button
                                                class="mt-1 inline-flex h-full items-center text-gray-800 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-md px-1.5 py-2 w-full">
                                                <div class="w-full ml-2 font-mono text-xl font-extrabold text-left">
                                                    {{ $pesofname && $pesolname ? $pesofname . ' ' . $pesolname : 'Select a PESO Employee' }}
                                                </div>
                                                <div class="ms-1">
                                                    <svg class="w-4 h-4 fill-current"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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
                                                <input wire:model.live.prevent='searchMun' type="text"
                                                    placeholder="Search..."
                                                    class="block w-full px-3 py-1.5 mb-2 border border-gray-300 rounded-md focus:outline-none"
                                                    @click.stop>
                                            </div>

                                            <!-- Dropdown content with scrollbar -->
                                            <div class="max-h-[300px] bg-white overflow-y-auto">
                                                <!-- Dropdown links -->
                                                @foreach ($pesoBranchAdmins as $data)
                                                    <x-dropdown-link
                                                        wire:click.prevent='selectPESO({{ $data->peso_accounts_id }})'
                                                        class="block px-4 py-2 uppercase cursor-pointer hover:bg-gray-100">{{ $data->peso_accounts_Fname }}
                                                        {{ $data->peso_accounts_Lname }}</x-dropdown-link>
                                                @endforeach
                                            </div>
                                        </x-slot>
                                    </x-dropdown>
                                    <x-input-error :messages="$errors->get('pesoid')" class="mt-2" />
                                </div>
                                <div class="flex flex-row justify-end w-full mt-6">
                                    <x-green-button wire:click.prevent='validateUpdate' type="submit"
                                        class="ml-auto mr-3">
                                        {{ __('Save') }}
                                    </x-green-button>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>




    </div>


    <x-modal name="confirm-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6" x-data="{ agreeBox: @entangle('agreeBox') }">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to create this account?') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center my-4">
                <div class="flex flex-col w-full px-4 mt-4">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col ">
                            <span class="text-xl font-bold ">Municipality:</span>
                            <span>
                                {{ $mun }}
                            </span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xl font-bold ">Full Name:</span>
                            <span>{{ $fname }}
                                @if ($mname)
                                    {{ $mname }}
                                @endif
                                {{ $lname }}
                            </span>
                        </div>
                        <div class="flex flex-col ">
                            <span class="text-xl font-bold ">Email:</span>
                            <span>{{ $email }}</span>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-xl font-bold ">Phone Number:</span>
                            <span>
                                {{ $phone }}
                            </span>
                        </div>

                    </div>

                    <div class="p-4 mt-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50" role="alert">
                        <span class="font-medium">Password will be generated and sent through the user's email.</span>
                    </div>

                    <div class="inline-flex items-center justify-center w-full mt-4">
                        <label class="relative flex items-center p-3 rounded-full cursor-pointer" for="agreeBox">
                            <input wire:model="agreeBox" type="checkbox" id="agreeBox"
                                class="w-5 h-5 transition-all border rounded-md appearance-none cursor-pointer border-blue-gray-200 checked:border-blue-900 checked:bg-blue-600" />
                            <span
                                class="absolute text-white transform opacity-0 top-2/4 left-2/4 -translate-x-2/4 -translate-y-2/4 peer-checked:opacity-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                    fill="currentColor" stroke="currentColor" stroke-width="1">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </label>
                        <label class="mt-px font-light text-gray-700 cursor-pointer select-none" for="agreeBox">
                            Confirm the transaction
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-6">
                <x-secondary-button x-on:click="agreeBox = false; $dispatch('close-modal', 'confirm-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-green-button x-bind:disabled="!agreeBox" wire:loading.attr="disabled"
                    wire:click.prevent="createPESO" class="ms-3" type="button">
                    {{ __('Create') }}
                    <div wire:loading.delay.long wire:target="createPESO" role="status">
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

    <x-modal name="new-manager-modal" focusable>
        @if ($selectedBranch)
            <div class="items-center w-full max-w-4xl px-6 py-6" x-data="{ newBox: @entangle('newBox') }">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to create this account?') }}
                </h2>
                <hr>
                <div class="flex flex-col items-center justify-center my-4">
                    <div class="flex flex-col w-full px-4 mt-4">
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col ">
                                <span class="text-xl font-bold ">Municipality:</span>
                                <span>
                                    {{ $pesoBranch->municipality->municipality_Name }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xl font-bold ">Full Name:</span>
                                <span>{{ $fname }}
                                    @if ($mname)
                                        {{ $mname }}
                                    @endif
                                    {{ $lname }}
                                </span>
                            </div>
                            <div class="flex flex-col ">
                                <span class="text-xl font-bold ">Email:</span>
                                <span>{{ $email }}</span>
                            </div>

                            <div class="flex flex-col">
                                <span class="text-xl font-bold ">Phone Number:</span>
                                <span>
                                    {{ $phone }}
                                </span>
                            </div>

                        </div>

                        <div class="p-4 mt-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50" role="alert">
                            <span class="font-medium">Password will be generated and sent through the user's
                                email.</span>
                        </div>

                        <div class="inline-flex items-center justify-center w-full mt-4">
                            <label class="relative flex items-center p-3 rounded-full cursor-pointer" for="newBox">
                                <input wire:model="newBox" type="checkbox" id="newBox"
                                    class="w-5 h-5 transition-all border rounded-md appearance-none cursor-pointer border-blue-gray-200 checked:border-blue-900 checked:bg-blue-600" />
                                <span
                                    class="absolute text-white transform opacity-0 top-2/4 left-2/4 -translate-x-2/4 -translate-y-2/4 peer-checked:opacity-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                        fill="currentColor" stroke="currentColor" stroke-width="1">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </label>
                            <label class="mt-px font-light text-gray-700 cursor-pointer select-none" for="newBox">
                                Confirm the transaction
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between mt-6">
                    <x-secondary-button x-on:click="newBox = false; $dispatch('close-modal', 'create-manger-modal')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-green-button x-bind:disabled="!newBox" wire:loading.attr="disabled"
                        wire:click.prevent="newManager" class="ms-3" type="button">
                        {{ __('Create') }}
                        <div wire:loading.delay.long wire:target="newManager" role="status">
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
        @endif
    </x-modal>


    <x-modal name="existing-manager-modal" focusable>
        @if ($pesoemail)
            <div class="items-center w-full max-w-4xl px-6 py-6" x-data="{ existingBox: @entangle('existingBox') }">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to choose this account?') }}
                </h2>
                <hr>
                <div class="flex flex-col items-center justify-center my-4">
                    <div class="flex flex-col w-full px-4 mt-4">
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col ">
                                <span class="text-xl font-bold ">Municipality:</span>
                                <span>
                                    {{ $pesoBranch->municipality->municipality_Name }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xl font-bold ">Full Name:</span>
                                <span>{{ $pesofname }}
                                    {{ $pesolname }}
                                </span>
                            </div>
                            <div class="flex flex-col ">
                                <span class="text-xl font-bold ">Email:</span>
                                <span>{{ $pesoemail }}</span>
                            </div>

                            <div class="flex flex-col">
                                <span class="text-xl font-bold ">Phone Number:</span>
                                <span>
                                    {{ $pesophone }}
                                </span>
                            </div>

                        </div>

                        <div class="inline-flex items-center justify-center w-full mt-4">
                            <label class="relative flex items-center p-3 rounded-full cursor-pointer"
                                for="existingBox">
                                <input wire:model="existingBox" type="checkbox" id="existingBox"
                                    class="w-5 h-5 transition-all border rounded-md appearance-none cursor-pointer border-blue-gray-200 checked:border-blue-900 checked:bg-blue-600" />
                                <span
                                    class="absolute text-white transform opacity-0 top-2/4 left-2/4 -translate-x-2/4 -translate-y-2/4 peer-checked:opacity-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                        fill="currentColor" stroke="currentColor" stroke-width="1">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </label>
                            <label class="mt-px font-light text-gray-700 cursor-pointer select-none"
                                for="existingBox">
                                Confirm the transaction
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between mt-6">
                    <x-secondary-button
                        x-on:click="existingBox = false; $dispatch('close-modal', 'create-manger-modal')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-green-button x-bind:disabled="!existingBox" wire:loading.attr="disabled"
                        wire:click.prevent="existingManager" class="ms-3" type="button">
                        {{ __('Create') }}
                        <div wire:loading.delay.long wire:target="existingManager" role="status">
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
        @endif
    </x-modal>


</div>
