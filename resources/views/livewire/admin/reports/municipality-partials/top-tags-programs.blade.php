<div class="bg-white shadow rounded-lg p-6 mt-4">
    <div class="mb-4">
        <div class="flex flex-col md:flex-row w-full justify-between gap-2">

            <h1 class="text-2xl font-bold">Most Popular Trainings Tags</h1>

            <button type="button" x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'filter-trainings-tags-modal')"
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
        <hr class="h-px my-2 bg-gray-200 border-0">
    </div>
    <div class="flex flex-col h-[400px] lg:h-full items-end">
        <livewire:livewire-column-chart key="{{ $programTagsChart->reactiveKey() }}" :column-chart-model="$programTagsChart" />
    </div>




    <x-modal name="filter-trainings-tags-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Filter Trainings') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-4">
                <h1 class="text-md font-semibold">Sort By Date</h1>
                <div class="flex flex-row w-full gap-4 mt-2">
                    <!-- Dropdown for Year -->
                    <div class="flex flex-col w-full">
                        <select wire:model="mountSelectedYear" class="block mt-1  rounded-md">
                            <option value="" disabled selected>Select Year</option>
                            @for ($year = $startYear; $year <= $currentYear; $year++)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                        <x-input-error :messages="$errors->get('year')" class="mt-2" />
                    </div>
                    <div class="flex flex-col w-full">
                        <x-dropdown align="left" width="full" disableCloseOnClick>
                            <x-slot name="trigger">
                                <button
                                    class="mt-1 inline-flex h-full items-center text-gray-800 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-md px-1.5 py-2 w-full">
                                    <div class="w-full ml-2 text-left">
                                        Months
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
                                <x-slot name="contentClasses">
                                    max-h-[300px] bg-white
                                </x-slot>
                                <div class="max-h-[300px] bg-white overflow-y-auto">
                                    @foreach (range(1, 12) as $month)
                                        <div class="flex items-center p-2">
                                            <input wire:model='mountSelectedMonths' type="checkbox"
                                                id="checkboxTraingTags-{{ $month }}" value="{{ $month }}"
                                                class="h-4 w-4 text-blue-600 border-gray-300 rounded" />
                                            <label for="checkboxTraingTags-{{ $month }}"
                                                class="ml-2 text-sm font-medium text-gray-700 cursor-pointer">
                                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>


                            </x-slot>
                        </x-dropdown>
                    </div>

                </div>
            </div>


            <div class="mt-6 flex justify-between">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'filter-trainings-tags-modal')">
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
