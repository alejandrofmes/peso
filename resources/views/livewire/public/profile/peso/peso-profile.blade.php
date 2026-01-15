<div wire:poll.10s>
    <div class="container flex flex-col w-full h-full gap-4 p-4 mx-auto md:flex-row md:p-0 md:py-8">

        <div class="flex flex-col h-full md:w-1/4 md:sticky top-5">
            <div class="p-6 bg-white rounded-lg shadow-xl">
                <div class="flex flex-col items-center">
                    <img src="{{ $pesoInfo->peso_Img ? asset('storage/' . $pesoInfo->peso_Img) : asset('assets/img/PESO-Logo.png') }}"
                        alt="peso-{{ $pesoInfo->peso_id }}"
                        class="object-cover w-32 h-32 mb-4 bg-gray-300 rounded-full shadow-xl select-none shrink-0">
                    </img>
                    <h1 class="text-xl font-bold break-all">PESO {{ $pesoInfo->municipality->municipality_Name }}</h1>



                    <p class="text-gray-700 break-all">{{ $pesoInfo->municipality->province->province_Name }}</p>

                </div>
                <hr class="my-6 border-t border-gray-300">
                <div class="flex flex-col w-full px-5 mt-5">

                    <ul class="text-wrap ... break-words truncate ...">
                        @if ($pesoInfo->peso_Email)
                            <li class="mb-4">
                                <div class="flex flex-row w-full gap-4">
                                    <div class="flex flex-col">
                                        <svg class="text-blue-500 w-7 h-7" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>

                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <div class="text-lg font-bold text-black">
                                            Email
                                        </div>
                                        <div class="font-medium uppercase break-all text-md">
                                            {{ $pesoInfo->peso_Email }}

                                        </div>


                                    </div>
                                </div>
                            </li>
                        @endif

                        @if ($pesoInfo->peso_Phone)
                            <li class="mb-4">
                                <div class="flex flex-row w-full gap-4">
                                    <div class="flex flex-col">
                                        <svg class="text-blue-500 w-7 h-7" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="5" y="2" width="14" height="20" rx="2"
                                                ry="2" />
                                            <line x1="12" y1="18" x2="12.01" y2="18" />
                                        </svg>



                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <div class="text-lg font-bold text-black">
                                            Phone Number
                                        </div>
                                        <div class="font-medium break-all text-md">
                                            {{ $pesoInfo->peso_Phone }}
                                        </div>


                                    </div>
                                </div>
                            </li>
                        @endif

                        @if ($pesoInfo->peso_Tel)
                            <li class="mb-4">
                                <div class="flex flex-row w-full gap-4">
                                    <div class="flex flex-col">
                                        <svg class="text-blue-500 w-7 h-7" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                        </svg>

                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <div class="text-lg font-bold text-black">
                                            Telephone Number
                                        </div>
                                        <div class="font-medium uppercase break-all text-md">
                                            {{ $pesoInfo->peso_Tel }}
                                        </div>


                                    </div>
                                </div>
                            </li>
                        @endif
                        @if ($pesoInfo->peso_Fax)
                            <li class="mb-4">
                                <div class="flex flex-row w-full gap-4">
                                    <div class="flex flex-col">
                                        <svg class="text-blue-500 w-7 h-7" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polyline points="6 9 6 2 18 2 18 9" />
                                            <path
                                                d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                                            <rect x="6" y="14" width="12" height="8" />
                                        </svg>


                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <div class="text-lg font-bold text-black">
                                            Fax Number
                                        </div>
                                        <div class="font-medium uppercase break-all text-md">
                                            {{ $pesoInfo->peso_Fax }}
                                        </div>


                                    </div>
                                </div>
                            </li>
                        @endif


                    </ul>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:w-3/4">

            <div class="flex flex-col space-y-5">

                <div class="container">
                    <div class="p-6 bg-white rounded-lg shadow-lg text-wrap">
                        <div class="flex flex-row items-center justify-between w-full">
                            <h2 class="text-xl font-bold">PESO Description</h2>



                        </div>

                        <p class="mt-2 text-gray-700 break-words text-wrap">
                            {{ !empty($pesoInfo->peso_Description) ? $pesoInfo->peso_Description : 'Empty PESO Description' }}

                        </p>

                    </div>
                </div>




                <div class="container select-none">
                    <div class="p-6 bg-white rounded-lg shadow">

                        <div class="flex flex-row justify-between w-full mb-4">
                            <h2 class="text-xl font-bold">Municipality Announcements</h2>


                            {{-- <div
                                class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300">
                                <a wire:navigate href="{{ route('edit.details.emp') }}">
                                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                            </div> --}}

                        </div>
                        @if ($pesoAnnouncements->isEmpty())

                            <div class="flex flex-col items-center justify-center mt-20 mb-20">
                                <div class="flex p-1 bg-gray-100 rounded-full">


                                    <svg class="w-24 h-24 text-black" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                                    </svg>


                                </div>

                                <div class="mt-5 text-xl font-semibold text-center text-black">
                                    No Announcements Found.
                                </div>
                            </div>
                        @else
                            <div class="grid grid-cols-1 gap-6 p-4 md:grid-cols-3 lg:grid-cols-4">
                                @foreach ($pesoAnnouncements as $data)
                                    <a wire:navigate
                                        href="{{ route('announcement.show', ['id' => $data->announcement_id]) }}"
                                        class="block transition-transform transform hover:scale-105 hover:shadow-lg hover:bg-gray-100">
                                        <div
                                            class="flex flex-col h-full overflow-hidden bg-white border border-gray-200 rounded-lg shadow-md">
                                            <div class="relative w-full h-48 overflow-hidden bg-gray-200 rounded-t-lg">
                                                <img src="{{ asset('storage/' . $data->announcement_pubmat) }}"
                                                    alt="announcement-{{ $data->announcement_id }}"
                                                    class="object-cover w-full h-full transition-transform duration-300 ease-in-out select-none hover:scale-110" />
                                            </div>
                                            <div class="flex flex-col flex-grow p-4">
                                                <h4
                                                    class="mb-2 text-lg font-semibold transition-colors duration-300 ease-in-out text-blue-gray-900 hover:text-blue-700">
                                                    {{ Str::limit(strip_tags($data->announcement_Title), 60, '...') }}
                                                </h4>
                                                <div
                                                    class="mt-auto text-xs font-normal text-center text-gray-600 lg:text-sm">
                                                    {{ $data->created_at->format('F j, Y') }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif


                    </div>

                </div>



            </div>






        </div>

    </div>



</div>
