<div>
    <div class="container mx-auto py-8">

        <div class="grid grid-cols-4 lg:grid-cols-12 gap-4 p-3 lg:p-0">

            <div class="col-span-4 lg:col-span-4">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4">
                    <div class="flex flex-row justify-center items-center h-full p-5 flex-shrink-0">
                        <img src="{{ asset('storage/' . $announcementInfo->announcement_pubmat) }}"
                            alt="PESO-Announcement-{{ $announcementInfo->announcement_id }}"
                            class="w-[450px] h-[450px] bg-gray-300 rounded object-contain">
                    </div>

                    {{-- <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700 mt-4"> --}}


                </div>

            </div>



            <div class="col-span-4 lg:col-span-8">
                <div class="bg-white overflow-hidden shadow-sm lg:rounded-lg">


                    <div class="flex flex-col w-full h-full p-5 space-y-2">

                        <div class="flex flex-col">
                            <h1 class="text-3xl text-blue-500 lg:text-6xl font-bold">
                                {{ $announcementInfo->announcement_Title }}
                            </h1>
                        </div>

                        <hr class="h-px  bg-gray-200 border-0 dark:bg-gray-700 mt-4">
                        <div class="flex flex-row mt-2 justify-between">
                            <h1 class="text-md text-gray-700 font-semibold">
                                PESO {{ $announcementInfo->peso->municipality->municipality_Name }}
                            </h1>
                            <h1 class="text-md text-gray-500 font-semibold">
                                {{ $announcementInfo->created_at->format('F j, Y') }}
                            </h1>
                        </div>

                        <div class="mt-4">
                            <div class="p-2 no-tailwindcss-base">
                                {!! $announcementInfo->announcement_Content !!}
                            </div>
                        </div>

                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
