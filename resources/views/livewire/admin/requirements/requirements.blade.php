<div class="container mx-auto py-8">

    {{-- GRID --}}
    <div class="grid grid-cols-4 lg:grid-cols-12 gap-4 p-3 lg:p-0">

        {{-- TITLE --}}
        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Requirements Management</h1>
        </div>

        <div class="col-span-4 lg:col-span-6">
            {{-- @livewire('admin.requirements.requirements-table') --}}
            <div class="bg-white shadow rounded-lg p-6">

                {{-- TITLE --}}
                <div class="flex items-center mb-2">
                    <h1 class="text-xl font-bold">Requirement List</h1>
                </div>

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
                                placeholder="Search">
                        </div>
                        {{-- ADD BUTTON --}}
                        <div class="flex flex-wrap mr-3 gap-2">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                                        <div>{{ $filter == 1 ? 'Public' : ($filter == 2 ? 'Private' : 'All') }}</div>

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
                                        max-h-[200px] bg-white
                                    </x-slot>

                                    <x-dropdown-link href="#" wire:click="updateFilter('')"
                                        class="block px-4 py-2 hover:bg-gray-100">All</x-dropdown-link>
                                    <hr>
                                    <!-- Authentication -->
                                    <x-dropdown-link href="#" wire:click="updateFilter('1')"
                                        class="block px-4 py-2 hover:bg-gray-100">Public</x-dropdown-link>

                                    <x-dropdown-link href="#" wire:click="updateFilter('2')"
                                        class="block px-4 py-2 hover:bg-gray-100">Private</x-dropdown-link>

                                    </form>
                                </x-slot>
                            </x-dropdown>

                        </div>



                    </div>

                    {{-- REQUIREMENT TABLE --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 lg:w-1/4">
                                        Requirement Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 hidden lg:table-cell">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 hidden lg:table-cell">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 hidden lg:table-cell">
                                        Date Created
                                    </th>
                                    <th scope="col" class="px-6 py-3">

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($requirements->isEmpty())
                                    <tr>
                                        <td colspan="5">
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
                                    @foreach ($requirements as $data)
                                        <tr wire:key='requirement-{{ $data->requirement_id }}'
                                            class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row" class="text-gray-900 whitespace-nowrap">

                                                <div class="ps-3 uppercase">
                                                    <div class="text-base font-semibold">{{ $data->requirement_Title }}
                                                    </div>

                                                    <div class="block lg:hidden">
                                                        <div class="text-gray-500 font-semibold text-sm uppercase">
                                                            @if ($data->requirement_Type == 1)
                                                                PUBLIC
                                                            @else
                                                                PRIVATE
                                                            @endif
                                                        </div>
                                                        <div class=" text-gray-500 font-medium text-sm uppercase">
                                                            <div class="flex items-center uppercase">
                                                                @if ($data->requirement_Status == 1)
                                                                    <div
                                                                        class="h-2.5 w-2.5 rounded-full bg-green-500 me-2">
                                                                    </div>
                                                                    ACTIVE
                                                                @else
                                                                    <div
                                                                        class="h-2.5 w-2.5 rounded-full bg-red-500 me-2">
                                                                    </div>
                                                                    DISABLED
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="text-gray-500 font-semibold text-sm">
                                                            Created: {{ $data->created_at->format('F d Y') }}
                                                        </div>
                                                    </div>
                                                </div>

                                            </th>
                                            <td class="px-6 py-4 hidden lg:table-cell">
                                                <span class="font-semibold">
                                                    @if ($data->requirement_Type == 1)
                                                        PUBLIC
                                                    @else
                                                        PRIVATE
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 hidden lg:table-cell">
                                                <div class="flex items-center uppercase">
                                                    @if ($data->requirement_Status == 1)
                                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                                        ACTIVE
                                                    @else
                                                        <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                                                        DISABLED
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 hidden lg:table-cell">
                                                <div class="text-base font-light uppercase text-sm">
                                                    {{ $data->created_at->format('h:i A') }}
                                                </div>
                                                <div class="text-base font-medium uppercase text-sm">
                                                    {{ $data->created_at->format('F d Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">

                                                <div class="flex flex-row items-center justify-center gap-6">
                                                    <div x-data="{ tooltip: 'Edit Requirement' }">
                                                        <button
                                                            wire:click.prevent="editReq({{ $data->requirement_id }})"
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
                                                    {{-- <div x-data="{ tooltip: 'Delete Requirement' }">
                                                    <button x-tooltip="tooltip" type="button"
                                                        class="text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
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
                </div>

                {{-- PAGINATION --}}
                <div class="mt-4">
                    {{ $requirements->links('vendor.livewire.tailwind') }}
                </div>

            </div>

        </div>




        <div class="col-span-4 lg:col-span-6">
            {{-- @livewire('admin.requirements.requirements-add') --}}
            <div class="bg-white shadow rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-4">Add Requirements</h1>
                <div>
                    <div class="flex flex-col lg:flex-row lg:gap-5 w-full mt-6 gap-6 ">


                        <div class="flex flex-col mt-2 w-full">
                            <x-input-label for="reqPost" :value="__('Requirement Type')" />
                            <x-text-input wire:model="reqPost" id="reqPost" class="block mt-1 w-full uppercase"
                                type="text" />
                            <x-input-error :messages="$errors->get('reqPost')" class="mt-2" />
                        </div>

                        <div class="flex flex-col mt-2 w-full">
                            <x-input-label for="trainingComplete" :value="__('Requirement Type')" />
                            <div class="flex flex-row w-full gap-2 mt-1">
                                <div class="flex flex-row items-center h-10  px-4 border border-gray-400 rounded">
                                    <input wire:model='reqType' id="bordered-radio-1" type="radio" value="1"
                                        name="bordered-radio"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                    <label for="bordered-radio-1"
                                        class="w-full py-4 ms-2 text-sm font-medium text-gray-900">Public
                                        Employers</label>
                                </div>
                                <div class="flex items-center h-10 px-4 border border-gray-400 rounded">
                                    <input wire:model='reqType' id="bordered-radio-2" type="radio" value="2"
                                        name="bordered-radio"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                    <label for="bordered-radio-2"
                                        class="w-full py-4 ms-2 text-sm font-medium text-gray-900 ">Private
                                        Employers</label>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('reqType')" class="mt-2" />
                        </div>

                    </div>

                    <div class="flex flex-row w-ful mt-6 ">
                        <x-primary-button wire:click.prevent="saveRequirement" type="submit" class="ml-auto mr-3">
                            {{ __('Add Requirement') }}
                        </x-primary-button>

                    </div>

                </div>

            </div>
        </div>




    </div>

    {{-- @livewire('admin.requirements.requirements-edit-modal') --}}
    <x-modal name="requirement-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center ">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Manage Requirement Record') }}
            </h2>

            <hr>

            <div class="flex flex-row items-center gap-6 mt-4">


                <div class="flex flex-col w-full">
                    <x-input-label for="reqPost" :value="__('Requirement Type')" />
                    <x-text-input wire:model='editreqPost' class="block mt-1 w-full uppercase" type="text" />
                    <x-input-error :messages="$errors->get('editreqPost')" class="mt-2" />
                </div>

                <div class="flex flex-col ml-5 w-full">
                    <x-input-label for="trainingComplete" :value="__('Requirement Status')" />
                    <div class="flex flex-row h-10 w-full gap-2 mt-1.5">
                        <div class="flex flex-row  items-center h-10 px-4 border border-gray-400 rounded">
                            <input wire:model='editstatusPost' id="bordered-radio-3" type="radio" value="1"
                                name="bordered-radio"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="bordered-radio-3"
                                class="w-full py-4 ms-2 text-sm font-medium text-gray-900">Active</label>
                        </div>
                        <div class="flex items-center px-4 h-10 border border-gray-400 rounded">
                            <input wire:model='editstatusPost' id="bordered-radio-4" type="radio" value="2"
                                name="bordered-radio"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="bordered-radio-4"
                                class="w-full py-4 ms-2 text-sm font-medium text-gray-900 ">Disabled</label>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('editstatusPost')" class="mt-2" />
                </div>


            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click.prevent='close' type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent='updateReq' class="ms-3" type="button">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>



</div>
