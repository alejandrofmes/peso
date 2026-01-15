<x-modal wire:poll name="partnership-modal" focusable>
    <div class="items-center w-full max-w-4xl px-6 py-6">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Choose a PESO Municipality') }}
        </h2>
        <hr>

        <div class="relative mt-4">
            <div
                class="flex flex-col gap-2 p-1 pb-4 space-y-4 overflow-visible lg:flex-row lg:justify-between lg:space-y-0">

                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>

                    {{-- LICENSE SEARCH --}}
                    <input wire:model.live='search' type="search" id="table-search-users"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search">
                </div>

                {{-- WEB BUTTON --}}
            </div>

            {{-- LICENSE MODAL --}}
            <div class="overflow-x-auto ">
                <table class="w-full text-sm text-center text-gray-500 rtl:text-right">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                        <tr>
                            <th scope="col" class="w-1/4 px-6 py-3"></th>
                            <th scope="col" class="px-6 py-3 uppercase">PESO</th>
                            <th scope="col" class="hidden px-6 py-3 uppercase sm:table-cell">Province</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($PESO->isEmpty())
                            <tr>
                                <td colspan="3">
                                    <div class="flex flex-col items-center justify-center mt-20 mb-20">
                                        <div class="p-6 bg-gray-100 rounded-full">
                                            <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                            </svg>
                                        </div>
                                        <p class="mt-2 text-xl font-bold text-center text-black">No Record Found!</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($PESO as $data)
                                <tr wire:key='PESO-{{ $data->peso_id }}'
                                    class="bg-white border-b hover:bg-gray-50 hover:cursor-pointer"
                                    ire:loading.attr="disabled" wire:click.prevent='pesoSelect({{ $data->peso_id }})'>
                                    <td class="px-6 py-4 text-center">
                                        <button wire:loading.attr="disabled"
                                            wire:click.prevent='pesoSelect({{ $data->peso_id }})'
                                            onclick="event.stopPropagation();"
                                            class="text-blue-500 hover:underline">Select</button>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-base font-semibold uppercase">PESO
                                            {{ $data->municipality->municipality_Name }}</div>
                                        <!-- Extra mobile information -->
                                        <div class="text-sm text-gray-500 sm:hidden">Province:
                                            {{ $data->municipality->province->province_Name }}</div>
                                    </td>
                                    <td class="hidden px-6 py-4 sm:table-cell">
                                        <div class="text-base font-semibold uppercase">
                                            {{ $data->municipality->province->province_Name }}</div>
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
            {{ $PESO->links('vendor.livewire.tailwind', data: ['scrollTo' => false]) }}
        </div>

        <div class="flex justify-end mt-6">
            <x-secondary-button type="button" x-data=""
                x-on:click="$dispatch('close-modal', 'partnership-modal')">
                {{ __('Cancel') }}
            </x-secondary-button>

        </div>
    </div>


</x-modal>
