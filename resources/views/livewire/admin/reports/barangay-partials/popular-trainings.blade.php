<div class="w-full h-full p-6 overflow-auto bg-white rounded-lg shadow">
    <div class="mb-5">
        <h1 class="text-2xl font-bold">Most Popular Trainings</h1>
        <hr class="h-px my-2 bg-gray-200 border-0">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full mt-2 text-sm text-left text-gray-500 rtl:text-right">
            <thead class="text-xs text-gray-700 uppercase bg-blue-300">
                <tr>
                    <th scope="col" class="w-full px-6 py-3">
                        <span class="font-bold text-black text-md">Training Title</span>
                    </th>
                    <th scope="col" class="hidden px-6 py-3 lg:table-cell">
                        <span class="font-bold text-black text-md">Type</span>
                    </th>
                    <th scope="col" class="hidden px-6 py-3 text-center lg:table-cell">
                        <span class="font-bold text-black text-md">Registered</span>
                    </th>
                    <th scope="col" class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @if ($topPrograms->isEmpty())
                    <tr>
                        <td colspan="4">
                            <div class="flex flex-col items-center justify-center mt-24 mb-24">
                                <div class="p-6 bg-gray-100 rounded-full">
                                    <svg class="w-24 h-24 text-black" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <p class="mt-2 text-xl font-bold text-center text-black">
                                    Not enough data!
                                </p>
                            </div>
                        </td>
                    </tr>
                @else
                    @foreach ($topPrograms as $data)
                        <tr wire:key='program-{{ $data->program_id }}' class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                <img class="w-10 h-10 rounded-full"
                                    src="{{ asset('storage/' . $data->program_pubmat) }}" alt="img">
                                <div class="ps-3 text-wrap">
                                    <div class="text-base font-semibold">
                                        <div class="text-base font-semibold">{{ $data->program_Title }}</div>
                                        <div class="text-sm font-normal text-gray-500 uppercase">
                                            {{ $data->program_Host }}
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500 lg:hidden">
                                        {{ $data->program_Type }}
                                    </div>
                                    <div class="text-sm text-gray-500 lg:hidden">
                                        Registrants: <span
                                            class="font-bold text-black">{{ $data->registration_count }}</span>
                                    </div>

                                </div>
                            </th>

                            <td class="hidden px-6 py-4 lg:table-cell">
                                {{ $data->program_Type }}
                            </td>

                            <td class="hidden px-6 py-4 lg:table-cell">
                                <div class="text-sm font-normal text-center text-gray-500 uppercase">
                                    <span class="font-bold text-blue-500 text-md">
                                        {{ $data->registration_count }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div x-data="{ tooltip: 'Program Overview' }">
                                    <a wire:navigate
                                        href="{{ route('admin-registrants-training', ['id' => $data->program_id]) }}"
                                        x-tooltip="tooltip" type="button"
                                        class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                            <path fill-rule="evenodd"
                                                d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>


</div>
