<div class="flex flex-col w-full h-full">
    <h1 class="text-2xl font-bold">Job and Industry Preference</h1>
    <span class="text-sm text-gray-600">Fields with * are required.</span>
    <div class="flex flex-col w-full mt-5">
        <div class="mt-2 flex-inline">


            @foreach ($jobpreference as $jobData)
                <span wire:key='jobPref-{{ $jobData['position_id'] }}'
                    class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $jobData['position_Title'] }}
                    <button wire:click.prevent='removePosition( {{ $jobData['position_id'] }})' type="button"
                        class="inline-flex items-center justify-center flex-shrink-0 rounded-full size-4 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 focus:text-blue-500">
                        <span class="sr-only">Remove badge</span>
                        <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </span>
            @endforeach
        </div>
        <x-input-error :messages="$errors->get('jobpreference')" class="mt-2" />
    </div>

    <div class="flex flex-row mt-4">
        <div class="flex flex-row mt-4">
            <button type="button" x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'job-position-modal')"
                class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">
                ADD JOB PREFERENCE
            </button>
        </div>
    </div>


    {{-- LOCATION --}}
    <h1 class="mt-24 text-2xl font-bold">Choose Preferred Industry</h1>
    <div class="flex flex-col w-full mt-2">
        <div class="mt-2 flex-inline">


            @foreach ($industrypreference as $industryData)
                <span wire:key='jobPref-{{ $industryData['industry_id'] }}'
                    class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $industryData['industry_Title'] }}
                    <button wire:click.prevent='removeIndustry( {{ $industryData['industry_id'] }})' type="button"
                        class="inline-flex items-center justify-center flex-shrink-0 rounded-full size-4 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 focus:text-blue-500">
                        <span class="sr-only">Remove badge</span>
                        <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </span>
            @endforeach
        </div>
        <x-input-error :messages="$errors->get('industrypreference')" class="mt-2" />
    </div>

    <div class="flex flex-row mt-4">
        <div class="flex flex-row mt-4">
            <button type="button" x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'industry-modal')"
                class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">
                ADD INDUSTRY PREFERENCE
            </button>
        </div>
    </div>

    <div class="flex flex-row justify-between mt-6 space-x-4">
        <x-secondary-button wire:loading.attr='disabled' wire:click.prevent='prev' type="button">
            Previous
            <div wire:loading.delay.long wire:target="prev" role="status">
                <svg aria-hidden="true" class="w-6 h-6 ml-4 text-gray-200 animate-spin fill-blue-600"
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
        </x-secondary-button>


        <x-blue-button wire:loading.attr='disabled' wire:click.prevent='next' type="button">
            Next
            <div wire:loading.delay.long wire:target="next" role="status">
                <svg aria-hidden="true" class="w-6 h-6 ml-4 text-gray-200 animate-spin fill-blue-600"
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
        </x-blue-button>
    </div>



    <livewire:modals.job-position-modal />
    <livewire:modals.industry-modal />
</div>
