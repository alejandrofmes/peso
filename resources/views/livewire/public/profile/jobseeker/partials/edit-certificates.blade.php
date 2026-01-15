<div>
    <div x-show="profileTab === 'editCertificates'" class="container" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-cloak>
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <div class="flex flex-row items-center justify-between w-full mb-4">
                <div class="flex flex-row items-center gap-4">

                    <div class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300"
                        @click="profileTab = 'profileOverview'">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold">Certificates</h2>

                </div>

                <div class="flex flex-row items-center gap-4">
                    <div x-data="{ tooltip: 'Add Certificate Record' }">
                        <div x-tooltip="tooltip"
                            class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300"
                            x-data="" wire:click.prevent = 'addModal'>
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                    </div>
                </div>

            </div>
            @if ($certs->isEmpty())

                <div class="flex flex-col items-center justify-center mt-20 mb-20">
                    <div class="flex p-1 bg-blue-200 rounded-full">

                        <svg class="w-24 h-24 text-black" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                        </svg>

                    </div>

                    <div class="mt-5 text-xl font-semibold text-center text-black">
                        Certificate Record is empty.
                    </div>
                </div>
            @else
                {{-- <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 "> --}}
                @foreach ($certs as $userCerts)
                    <div wire:key="{{ $userCerts->cert_id }}" class="container p-3">

                        <div class="flex flex-row items-center h-full">

                            <div class="flex flex-col">
                                <svg class="w-10 h-10 text-gray-800 lg:w-20 lg:h-20" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M211 7.3C205 1 196-1.4 187.6 .8s-14.9 8.9-17.1 17.3L154.7 80.6l-62-17.5c-8.4-2.4-17.4 0-23.5 6.1s-8.5 15.1-6.1 23.5l17.5 62L18.1 170.6c-8.4 2.1-15 8.7-17.3 17.1S1 205 7.3 211l46.2 45L7.3 301C1 307-1.4 316 .8 324.4s8.9 14.9 17.3 17.1l62.5 15.8-17.5 62c-2.4 8.4 0 17.4 6.1 23.5s15.1 8.5 23.5 6.1l62-17.5 15.8 62.5c2.1 8.4 8.7 15 17.1 17.3s17.3-.2 23.4-6.4l45-46.2 45 46.2c6.1 6.2 15 8.7 23.4 6.4s14.9-8.9 17.1-17.3l15.8-62.5 62 17.5c8.4 2.4 17.4 0 23.5-6.1s8.5-15.1 6.1-23.5l-17.5-62 62.5-15.8c8.4-2.1 15-8.7 17.3-17.1s-.2-17.4-6.4-23.4l-46.2-45 46.2-45c6.2-6.1 8.7-15 6.4-23.4s-8.9-14.9-17.3-17.1l-62.5-15.8 17.5-62c2.4-8.4 0-17.4-6.1-23.5s-15.1-8.5-23.5-6.1l-62 17.5L341.4 18.1c-2.1-8.4-8.7-15-17.1-17.3S307 1 301 7.3L256 53.5 211 7.3z" />
                                </svg>
                            </div>


                            <div class="flex flex-col w-full ml-4">
                                <span
                                    class="text-3xl font-black text-black uppercase">{{ $userCerts->certificateType->cert_Name }}</span>
                                <span class="text-xl font-semibold text-black uppercase">
                                    {{ $userCerts->cert_From }}
                                </span>
                                <span class="font-medium text-gray-700 uppercase text-md"> {{ $userCerts->cert_Rating }}
                                </span>
                                <span class="font-medium text-gray-700 uppercase text-md">
                                    {{ $userCerts->cert_Date_Issued->format('F Y') }}
                                </span>
                            </div>


                            <div class="flex flex-row items-center justify-center h-full gap-2">
                                <div x-data="{ tooltip: 'Remove Training Record' }">
                                    <div x-tooltip="tooltip" wire:click.prevent='deleteData({{ $userCerts->cert_id }})'
                                        class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-red-300">
                                        <svg class="w-10 h-10 text-red-700" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>


                                    </div>
                                </div>
                                <div x-tooltip="tooltip" x-data="{ tooltip: 'Edit Certificate Record' }">
                                    <div wire:click.prevent = 'editModal({{ $userCerts->cert_id }})'
                                        class="flex items-center p-1 transition-transform rounded-full cursor-pointer  hover:bg-blue-300">
                                        <svg class="w-10 h-10 text-blue-700" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <hr class="h-0.5 my-2 mx-10 bg-blue-200 border-0">
                @endforeach


                {{-- </div> --}}

            @endif
        </div>
    </div>


    <x-modal name="certificate-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Certificate Record') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">


                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="level" :value="__('Certification')" />

                    {{-- DROP DOWN --}}
                    <x-dropdown align="left" width="full">
                        <x-slot name="trigger">
                            <button
                                class="mt-1 inline-flex h-full items-center text-gray-800 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-md px-1.5 py-2 w-full">
                                <div class="w-full ml-2 text-left">
                                    {{ $certName ?? 'Select Certification' }}
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
                                <input wire:model.live='search' wire:model="search" type="search"
                                    placeholder="Search..."
                                    class="block w-full px-3 py-1.5 mb-2 border border-gray-300 rounded-md focus:outline-none"
                                    @click.stop>
                            </div>

                            <!-- Dropdown content with scrollbar -->
                            <div class="max-h-[120px] bg-white overflow-y-auto">
                                <!-- Dropdown links -->
                                {{-- LOOP HERE --}}
                                @foreach ($certTypes as $certType)
                                    <x-dropdown-link wire:click.prevent='certtypeid({{ $certType->cert_type_id }})'
                                        class="block px-4 py-2 uppercase cursor-pointer hover:bg-gray-100">
                                        {{ $certType->cert_Name }}
                                    </x-dropdown-link>
                                @endforeach

                                {{-- LOOP END --}}
                            </div>
                        </x-slot>

                    </x-dropdown>
                    <x-input-error :messages="$errors->get('certTypeID')" class="mt-2" />
                </div>

                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="certIssued" :value="__('Issued By')" />
                    <x-text-input wire:model="certFrom" id="certIssued" class="block w-full mt-1" type="text" />
                    <x-input-error :messages="$errors->get('jobTags')" class="mt-2" />
                </div>

                <div class="flex flex-row w-full mt-2">
                    <div class="flex flex-col w-full">
                        <x-input-label for="certDate" :value="__('Earned At')" />
                        <x-text-input wire:model="certEarned" id="certDate" class="block w-full mt-1"
                            type="date" />
                        <x-input-error :messages="$errors->get('certEarned')" class="mt-2" />
                    </div>
                    <div class="flex flex-col w-full ml-4">
                        <x-input-label for="certRating" :value="__('Rating')" />
                        <x-text-input wire:model="certRate" id="certRating" class="block w-full mt-1"
                            type="number" />
                        <x-input-error :messages="$errors->get('certRate')" class="mt-2" />
                    </div>
                </div>

            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button wire:click.prevent='close' type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent='save' class="ms-3" type="button" id="certAdd">
                    {{ __('Save') }}
                </x-primary-button>
            </div>

        </div>
    </x-modal>

    <x-modal name="delete-cert-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center my-12">

                <h1 class="text-2xl font-bold">Are you sure you want to delete this certifcate record?</h1>


            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-cert-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled" wire:click.prevent="deleteRecord()" class="ms-3"
                    type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="deleteRecord()" role="status">
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


</div>
