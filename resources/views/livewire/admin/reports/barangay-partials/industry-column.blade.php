<div class="p-6 bg-white rounded-lg shadow">
    <div class="mb-10">
        <div class="flex flex-col lg:flex-row lg:justify-between gap-2">
            <h1 class="text-2xl font-bold">Most Preferred Industries</h1>

            <x-dropdown align="left" width="36">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                        <div>
                            {{ $filter }}
                        </div>

                        <div class="ms-1">
                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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

                    <x-dropdown-link wire:click.prevent="changeFilter('All')" class="cursor-pointer">
                        All
                    </x-dropdown-link>
                    <x-dropdown-link wire:click.prevent="changeFilter('Employed')" class="cursor-pointer">
                        Employed
                    </x-dropdown-link>
                    <x-dropdown-link wire:click.prevent="changeFilter('Unemployed')" class="cursor-pointer">
                        Unemployed
                    </x-dropdown-link>




                </x-slot>
            </x-dropdown>
        </div>

        <hr class="h-px my-2 bg-gray-200 border-0">
    </div>
    <div class="flex items-end h-full">
        <livewire:livewire-column-chart key="{{ $industries_chart->reactiveKey() }}" :column-chart-model="$industries_chart" />
    </div>
</div>
