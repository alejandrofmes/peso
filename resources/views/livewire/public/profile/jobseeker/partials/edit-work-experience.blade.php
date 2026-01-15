<div>
    <div x-show="profileTab === 'editWorkExperience'" class="container"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-cloak>

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
                    <h2 class="text-xl font-bold">Work Experience</h2>

                </div>

                <div class="flex flex-row items-center gap-4">
                    <div x-data="{ tooltip: 'Add Work Experience' }">
                        <div x-tooltip="tooltip"
                            class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300"
                            wire:click.prevent='addModal()'>
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            @if ($workexp->isEmpty())

                <div class="flex flex-col items-center justify-center mt-20 mb-20">
                    <div class="flex p-1 bg-blue-200 rounded-full">

                        <svg class="w-24 h-24 text-black" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                        </svg>

                    </div>

                    <div class="mt-5 text-xl font-semibold text-center text-black">
                        Work Experience is Empty.
                    </div>
                </div>
            @else
                {{-- <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 "> --}}

                @foreach ($workexp as $experience)
                    <div wire:key="{{ $experience->workexp_id }}" class="container p-3">

                        <div class="flex flex-row items-center h-full">

                            <div class="flex flex-col">
                                <svg class="w-10 h-10 text-gray-800 lg:w-20 lg:h-20" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M10 2a3 3 0 0 0-3 3v1H5a3 3 0 0 0-3 3v2.382l1.447.723.005.003.027.013.12.056c.108.05.272.123.486.212.429.177 1.056.416 1.834.655C7.481 13.524 9.63 14 12 14c2.372 0 4.52-.475 6.08-.956.78-.24 1.406-.478 1.835-.655a14.028 14.028 0 0 0 .606-.268l.027-.013.005-.002L22 11.381V9a3 3 0 0 0-3-3h-2V5a3 3 0 0 0-3-3h-4Zm5 4V5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1h6Zm6.447 7.894.553-.276V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-5.382l.553.276.002.002.004.002.013.006.041.02.151.07c.13.06.318.144.557.242.478.198 1.163.46 2.01.72C7.019 15.476 9.37 16 12 16c2.628 0 4.98-.525 6.67-1.044a22.95 22.95 0 0 0 2.01-.72 15.994 15.994 0 0 0 .707-.312l.041-.02.013-.006.004-.002.001-.001-.431-.866.432.865ZM12 10a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>

                            <div class="flex flex-col w-full ml-4">
                                <span
                                    class="text-3xl font-black text-black uppercase">{{ $experience->work_Name }}</span>
                                <div class="text-xl font-semibold text-black uppercase">
                                    <span>{{ $experience->job_positions->position_Title }}</span>
                                    -
                                    <span>{{ $experience->work_Status }}</span>
                                </div>
                                <span class="font-medium text-gray-700 uppercase text-md">
                                    {{ $experience->work_Start->format('F Y') }} -

                                    @if ($experience->work_End)
                                        {{ $experience->work_End->format('F Y') }}
                                    @else
                                        Present
                                    @endif
                                </span>
                                <span class="font-medium text-gray-700 text-md">{{ $experience->work_Address }}</span>
                            </div>


                            <div class="flex flex-row items-center justify-center h-full gap-2">
                                <div x-data="{ tooltip: 'Remove Work Experience' }">
                                    <div x-tooltip="tooltip"
                                        wire:click.prevent='deleteData({{ $experience->workexp_id }})'
                                        class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-red-300">
                                        <svg class="w-10 h-10 text-red-700" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>


                                    </div>
                                </div>
                                <div x-data="{ tooltip: 'Edit Work Experience' }">
                                    <div x-tooltip="tooltip"
                                        wire:click.prevent='editModal({{ $experience->workexp_id }})'
                                        class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-blue-300">
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


    <x-modal name="workExp-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Work Experience') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">
                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="workEmp" :value="__('Employer')" />
                    <x-text-input wire:model="workName" class="block w-full mt-1" type="text" />
                    <x-input-error :messages="$errors->get('workName')" class="mt-2" />
                </div>
                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="workAddress" :value="__('Address')" />
                    <x-text-input wire:model="workAdd" class="block w-full mt-1" type="text" />
                    <x-input-error :messages="$errors->get('workAdd')" class="mt-2" />
                </div>
                <div class="flex flex-col w-full mt-2 lg:flex-row">

                    <div class="flex flex-col w-full">
                        <x-input-label for="workPos" :value="__('Job Position')" />
                        <x-dropdown align="left" width="full">
                            <x-slot name="trigger">
                                <button
                                    class="mt-1 inline-flex h-full items-center text-gray-800 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-md px-1.5 py-2 w-full">
                                    <div class="w-full ml-2 text-left">
                                        {{ $workPositionTitle ?? 'Select Job Position' }}
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
                                    <input wire:model.live='search' type="search" wire:model="search"
                                        placeholder="Search..."
                                        class="block w-full px-3 py-1.5 mb-2 border border-gray-300 rounded-md focus:outline-none"
                                        @click.stop>
                                </div>

                                <!-- Dropdown content with scrollbar -->
                                <div class="max-h-[120px] bg-white overflow-y-auto">
                                    <!-- Dropdown links -->
                                    @foreach ($job_positions as $data)
                                        <x-dropdown-link wire:click.prevent='updateSelect({{ $data->position_id }})'
                                            class="block px-4 py-2 uppercase cursor-pointer hover:bg-gray-100">{{ $data->position_Title }}</x-dropdown-link>
                                    @endforeach
                                </div>
                            </x-slot>

                        </x-dropdown>
                        <x-input-error :messages="$errors->get('workPosition')" class="mt-2" />
                    </div>

                    <div class="flex flex-col w-full ml-4">
                        <x-input-label for="workStatus" :value="__('Status')" />
                        <select wire:model="workStatus" class="block w-full mt-1 rounded-lg ">
                            <option value="" disabled selected>Select Work Status</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Contractual">Contractual</option>
                            <option value="Probationary">Probationary</option>
                            <option value="Part-time">Part-time</option>
                        </select>
                        <x-input-error :messages="$errors->get('workStatus')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-row w-full mt-2">
                    <div class="flex flex-col w-full">
                        <x-input-label for="workStart" :value="__('Started')" />
                        <x-text-input wire:model="workStart" class="block w-full mt-1" type="date" />
                        <x-input-error :messages="$errors->get('workStart')" class="mt-2" />
                    </div>
                    <div class="flex flex-col w-full ml-4">
                        <x-input-label for="workEnd" :value="__('Ended')" />
                        <x-text-input wire:model="workEnd" class="block w-full mt-1" type="date" />
                        <x-input-error :messages="$errors->get('workEnd')" class="mt-2" />
                    </div>

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


    <x-modal name="delete-workExp-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center my-12">

                <h1 class="text-2xl font-bold">Are you sure you want to delete this work expierence?</h1>


            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-workExp-modal')">
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
