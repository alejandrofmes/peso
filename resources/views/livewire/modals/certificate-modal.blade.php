<x-modal wire:poll name="certificate-modal" focusable>
    <div class="w-full max-w-4xl px-6 py-6 items-center">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Certificate Record') }}
        </h2>
        <hr>
        <div class="flex flex-col mt-2">


            <div class="flex flex-col mt-2 w-full">
                <x-input-label for="level" :value="__('Certification*')" />

                {{-- DROP DOWN --}}
                <x-dropdown align="left" width="full">
                    <x-slot name="trigger">
                        <button
                            class="mt-1 inline-flex h-full items-center text-gray-800 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-md px-1.5 py-2 w-full">
                            <div class="w-full ml-2 text-left">
                                {{ $certName ?? 'Select Certification' }}
                            </div>
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
                            @foreach ($certTypes as $data)
                                <x-dropdown-link wire:loading.attr="disabled"
                                    wire:click.prevent='selectCertificate({{ $data->cert_type_id }})'
                                    class="cursor-pointer block px-4 py-2 hover:bg-gray-100 uppercase">
                                    {{ $data->cert_Name }}
                                </x-dropdown-link>
                            @endforeach

                            {{-- LOOP END --}}
                        </div>
                    </x-slot>

                </x-dropdown>
                <x-input-error :messages="$errors->get('certTypeID')" class="mt-2" />
            </div>

            <div class="flex flex-col mt-2 w-full">
                <x-input-label for="certIssued" :value="__('Issued By*')" />
                <x-text-input wire:model="certFrom" class="block mt-1 w-full" type="text" />
                <x-input-error :messages="$errors->get('certFrom')" class="mt-2" />
            </div>

            <div class="flex flex-row mt-2 w-full">
                <div class="flex flex-col w-full">
                    <x-input-label for="certDate" :value="__('Earned At*')" />
                    <x-text-input wire:model="certEarned" class="block mt-1 w-full" type="date" />
                    <x-input-error :messages="$errors->get('certEarned')" class="mt-2" />
                </div>
                <div class="flex flex-col ml-4 w-full">
                    <x-input-label for="certRating" :value="__('Rating*')" />
                    <x-text-input wire:model="certRate" class="block mt-1 w-full" type="number" />
                    <x-input-error :messages="$errors->get('certRate')" class="mt-2" />
                </div>
            </div>

        </div>
        <div class="mt-6 flex justify-end">
            <x-secondary-button wire:click.prevent='close' type="button">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button wire:click.prevent='save' class="ms-3" type="button">
                {{ __('Save') }}
            </x-primary-button>
        </div>

    </div>
</x-modal>
