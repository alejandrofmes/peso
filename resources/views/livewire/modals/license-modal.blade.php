<x-modal wire:poll name="license-modal" focusable>
    <div class="items-center w-full max-w-4xl px-6 py-6">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('License Record') }}
        </h2>
        <hr>
        <div class="flex flex-col mt-2">
            <div class="flex flex-col w-full mt-2">
                <x-input-label for="licenseType" :value="__('License*')" />

                <x-dropdown align="left" width="full">
                    <x-slot name="trigger">
                        <button
                            class="mt-1 inline-flex h-full items-center text-gray-800 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-md px-1.5 py-2 w-full">
                            <div class="w-full ml-2 text-left">
                                {{ $licenseName ?? 'Select License' }}
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
                            <input wire:model.live='search' type="search" placeholder="Search..."
                                class="block w-full px-3 py-1.5 mb-2 border border-gray-300 rounded-md focus:outline-none"
                                @click.stop>
                        </div>

                        <!-- Dropdown content with scrollbar -->
                        <div class="max-h-[120px] bg-white overflow-y-auto">
                            <!-- Dropdown links -->

                            @foreach ($license as $data)
                                <x-dropdown-link wire:loading.attr="disabled"
                                    wire:click.prevent='selectLicense({{ $data->license_type_id }})'
                                    class="block px-4 py-2 uppercase cursor-pointer hover:bg-gray-100">{{ $data->license_Name }}</x-dropdown-link>
                            @endforeach

                        </div>
                    </x-slot>

                </x-dropdown>
                <x-input-error :messages="$errors->get('licenseId')" class="mt-2" />

            </div>
            <div class="flex flex-col w-full mt-2">
                <x-input-label for="licenseDate" :value="__('Date Validity*')" />
                <x-text-input wire:model='licenseDate' class="block w-full mt-1" type="date" />
                <x-input-error :messages="$errors->get('licenseDate')" class="mt-2" />
            </div>

        </div>
        <div class="flex justify-end mt-6">
            <x-secondary-button wire:click.prevent='close' type="button">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button wire:click.prevent='save' class="ms-3" type="button">
                {{ __('Save') }}
            </x-primary-button>
        </div>
    </div>
</x-modal>
