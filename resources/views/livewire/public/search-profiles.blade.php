<div class="container py-8 mx-auto">

    <div class="grid grid-cols-4 gap-4 p-3 lg:grid-cols-12 lg:p-0">
        <div class="col-span-4 lg:col-start-4 lg:col-end-10">
            <div class="relative w-full shadow-xl">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>


                </div>
                <input wire:model.live='q' type="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 "
                    placeholder="Search profile..." required />
            </div>
            <div class="p-1 mt-2 overflow-hidden bg-white rounded-lg shadow-lg">
                <div class="flex flex-col w-full h-full gap-2">
                    @if ($results->isEmpty())
                        <div class="flex flex-col items-center justify-center mt-20 mb-20">
                            <div class="flex p-1 bg-gray-100 rounded-full">
                                <svg class="w-32 h-32 text-black" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>


                            </div>

                            <div class="mt-5 text-2xl font-semibold text-center text-black">
                                No Profile Found!
                            </div>
                        </div>
                    @else
                        @foreach ($results as $data)
                            @if ($data->type === 'employee')
                                <a wire:navigate href="{{ route('jobseeker.profile', ['id' => $data->id]) }}"
                                    wire:key='jobseeker-{{ $data->id }}'>
                                    <div
                                        class="flex h-full text-sm leading-6 bg-gray-200 rounded-lg shadow-lg hover:bg-gray-300">
                                        <div class="flex w-full h-full px-5 py-2">
                                            <div>
                                                <img src="{{ asset('storage/' . $data->pimage) }}" alt=""
                                                    class="flex-none object-cover w-24 h-24 rounded-full" loading="lazy"
                                                    decoding="async">
                                            </div>

                                            <div class="justify-center flex-auto h-full my-auto ml-4">
                                                <div class="text-xl font-black uppercase text-slate-900">
                                                    {{ $data->name }}
                                                </div>
                                                <div class="flex flex-row">
                                                    <div class="mt-1 font-bold text-blue-500 text-md">
                                                        <span class="font-medium">
                                                            JOBSEEKER</span> ·
                                                        <span class="font-medium">
                                                            {{ $data->empStatus == 1 ? 'EMPLOYED' : 'UNEMPLOYED' }}</span>
                                                        ·
                                                        <span class="font-medium">
                                                            {{ $data->barangay_name }},
                                                            {{ $data->municipality_name }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            @elseif ($data->type === 'company')
                                <a wire:navigate href="{{ route('employer.profile', ['id' => $data->id]) }}"
                                    wire:key='employer-{{ $data->id }}'>
                                    <div
                                        class="flex h-full text-sm leading-6 bg-gray-200 rounded-lg shadow hover:bg-gray-300">
                                        <div class="flex w-full h-full px-5 py-2">
                                            <div>
                                                <img src="{{ asset('storage/' . $data->pimage) }}" alt=""
                                                    class="flex-none object-cover w-24 h-24 rounded-full" loading="lazy"
                                                    decoding="async">
                                            </div>

                                            <div class="justify-center flex-auto h-full my-auto ml-4">
                                                <div class="text-xl font-black uppercase text-slate-900">
                                                    {{ $data->name }}
                                                </div>
                                                <div class="flex flex-row">
                                                    <div class="mt-1 font-bold text-blue-500 text-md">
                                                        <span class="font-medium">
                                                            COMPANY</span> ·
                                                        <span class="font-medium">
                                                            {{ $data->company_Type == 1 ? 'MAIN' : 'BRANCH' }}</span> ·
                                                        <span class="font-medium">
                                                            {{ $data->employer_Type == 1 ? 'PUBLIC' : 'PRIVATE' }}</span>
                                                        ·
                                                        <span class="font-medium">
                                                            {{ $data->barangay_name }},
                                                            {{ $data->municipality_name }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            @elseif ($data->type === 'peso')
                                <a wire:navigate href="{{ route('peso.profile', ['id' => $data->id]) }}"
                                    wire:key='peso-{{ $data->id }}'>
                                    <div
                                        class="flex h-full text-sm leading-6 bg-gray-200 rounded-lg shadow hover:bg-gray-300">
                                        <div class="flex w-full h-full px-5 py-2">
                                            <div>
                                                <img src="{{ $data->pimage ? asset('storage/' . $data->pimage) : asset('assets/img/PESO-Logo.png') }}"
                                                    alt="peso-{{ $data->id }}"
                                                    class="flex-none object-cover w-24 h-24 rounded-full" loading="lazy"
                                                    decoding="async">
                                            </div>

                                            <div class="justify-center flex-auto h-full my-auto ml-4">
                                                <div class="text-xl font-black uppercase text-slate-900">
                                                    {{ $data->name }}
                                                </div>
                                                <div class="flex flex-row">
                                                    <div class="mt-1 font-bold text-blue-500 text-md">
                                                        <span class="font-medium">
                                                            PESO Branch</span>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="m-4">
                    {{ $results->links('vendor.livewire.tailwind') }}
                </div>
            </div>

        </div>
    </div>
</div>
