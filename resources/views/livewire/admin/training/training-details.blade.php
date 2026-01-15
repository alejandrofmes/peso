<div wire:poll class="container py-8 mx-auto">
    <div class="grid grid-cols-4 gap-4 p-3 lg:grid-cols-12 lg:p-0">

        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Trainings / Training List / Training Details</h1>
        </div>


        <div class="col-span-4 lg:col-span-5">
            <div class="p-4 overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="flex flex-row items-center justify-center flex-shrink-0 h-full p-5">
                    <img src="{{ asset('storage/' . $programInfo->program_pubmat) }}" alt="Default I mage"
                        class="w-[260px] h-[200px] lg:w-[600px] lg:h-[450px] bg-gray-300 rounded object-fill">
                </div>


            </div>

            <div class="p-4 mt-4 overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="flex flex-row w-full">
                    <h1 class="text-xl font-bold text-blue-900">Matched Job Seekers</h1>
                </div>
                <hr class="h-px mt-2 bg-gray-200 border-0 dark:bg-gray-700">

                <div class="max-h-[500px] overflow-y-auto mt-4">
                    @if ($matchingEmployees->isEmpty())
                        <div>


                            <div class="flex flex-col items-center justify-center mt-20 mb-20">
                                <div class="flex p-1 bg-gray-100 rounded-full">

                                    <svg class="w-24 h-24 text-black" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                    </svg>

                                </div>

                                <div class="mt-5 text-xl font-semibold text-center text-black">
                                    No Matched Applicants
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-3 lg:grid-cols-3 lg:gap-4">
                            @foreach ($matchingEmployees as $data)
                                <div wire:key='jobseeker-{{ $data->employee_id }}'
                                    class="flex flex-col items-center justify-center w-full max-w-sm px-4 py-4 mx-auto transition-colors duration-300 bg-blue-50 rounded-xl shrink-0 grow-0 hover:bg-blue-200">
                                    <img class="flex mx-auto w-[100px] h-[100px] object-cover rounded-full lg:mx-0 lg:grow-0 lg:shrink-0 shadow-xl"
                                        src="{{ asset('storage/' . $data->pimg) }}"
                                        alt="jobseeker-{{ $data->employee_id }}">
                                    <div
                                        class="flex flex-col items-center justify-center mt-2 text-center lg:text-left">
                                        <div class="space-y-0.5">
                                            <p class="text-lg font-semibold text-center text-black">
                                                {{ $data->fname }}
                                                {{ $data->mname ?? '' }}
                                                {{ $data->lname }}@if (!empty($data->suffix))
                                                    , {{ $data->suffix }}
                                                @endif
                                            </p>
                                            <p class="font-medium text-center text-slate-500">
                                                {{ $data->empstatus == 1 ? 'Employed' : 'Unemployed' }}
                                            </p>
                                        </div>
                                        <a wire:navigate
                                            href="{{ route('jobseeker.profile', ['id' => $data->employee_id]) }}"
                                            class="px-4 py-1 mt-2 text-sm font-semibold text-blue-600 bg-blue-300 border border-blue-200 rounded-full hover:text-white hover:bg-blue-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">Profile</a>
                                    </div>
                                </div>
                            @endforeach


                        </div>


                    @endif

                </div>

            </div>
        </div>



        <div class="col-span-4 lg:col-span-7">
            <div class="overflow-hidden bg-white shadow-sm lg:rounded-lg">


                <div class="flex flex-col w-full h-full p-5 space-y-2">

                    <div class="flex flex-row justify-between">
                        <h1 class="text-xl font-bold text-blue-900 lg:text-2xl">Program Information
                        </h1>
                        <div class="flex flex-row gap-4">
                            @if ($programInfo->program_Status == 'ACTIVE')
                                <x-danger-button x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'cancel-modal')">
                                    Cancel Training
                                </x-danger-button>

                                <x-blue-button wire:click.prevent='editTraining({{ $programInfo->program_id }})'>
                                    Edit Training
                                </x-blue-button>
                            @endif
                        </div>
                    </div>
                    <hr class="h-px mt-2 bg-gray-200 border-0 dark:bg-gray-700">

                    <div class="mt-6">
                        <div class="flex flex-col w-full h-full ">
                            <div class="flex flex-col w-full gap-2 lg:flex-row lg:gap-4">
                                <div class="flex flex-col w-full">
                                    <x-input-label for="progTitle" :value="__('Program Title')" />
                                    <x-text-input value="{{ $programInfo->program_Title }}" class="block w-full mt-1"
                                        type="text" disabled />
                                </div>
                                <div class="flex flex-col w-full">
                                    <x-input-label for="progHost" :value="__('Program Host')" />
                                    <x-text-input value="{{ $programInfo->program_Host }}" class="block w-full mt-1"
                                        type="text" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col w-full h-full">
                            <div class="flex flex-col w-full gap-2 lg:flex-row lg:gap-4">
                                <div class="flex flex-col w-full gap-2 lg:flex-row lg:gap-4">
                                    <div class="flex flex-col w-full">
                                        <x-input-label for="progTitle" :value="__('Date Posted')" />
                                        <x-text-input value="{{ $programInfo->created_at->format('F j, Y') }}"
                                            class="block w-full mt-1" type="text" disabled />
                                    </div>
                                    <div class="flex flex-col w-full">
                                        <x-input-label for="progHost" :value="__('Registration Deadline')" />
                                        <x-text-input value="{{ $programInfo->program_Deadline->format('F j, Y') }}"
                                            class="block w-full mt-1" type="text" disabled />
                                    </div>
                                </div>
                                @if ($programInfo->program_Datetime)
                                    <div class="flex flex-col w-full gap-2 lg:flex-row lg:gap-4">
                                        <div class="flex flex-col w-full">
                                            <x-input-label for="progTitle" :value="__('Program Date')" />
                                            <x-text-input
                                                value="{{ $programInfo->program_Datetime->format('F j, Y') }}"
                                                class="block w-full mt-1" type="text" disabled />
                                        </div>
                                        <div class="flex flex-col w-full">
                                            <x-input-label for="progHost" :value="__('Program Time')" />
                                            <x-text-input value="{{ $programInfo->program_Datetime->format('g:i A') }}"
                                                class="block w-full mt-1" type="text" disabled />
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="flex flex-col w-full h-full">
                            <div class="flex flex-col w-full gap-2 lg:flex-row lg:gap-4">
                                <div class="flex flex-col w-full">
                                    <x-input-label for="progTitle" :value="__('Program Type')" />
                                    <x-text-input value="{{ $programInfo->program_Type }}" class="block w-full mt-1"
                                        type="text" disabled />
                                </div>
                                <div class="flex flex-row w-full gap-2 lg:gap-4">
                                    <div class="flex flex-col w-full">
                                        <x-input-label for="progHost" :value="__('Program Modality')" />
                                        <x-text-input value="{{ $programInfo->program_Modality }}"
                                            class="block w-full mt-1" type="text" disabled />
                                    </div>
                                    <div class="flex flex-col w-full">
                                        <x-input-label for="progHost" :value="__('Program Slots')" />
                                        <x-text-input value="{{ $programInfo->program_Slots }}"
                                            class="block w-full mt-1" type="text" disabled />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col w-full h-full">
                            <div class="flex flex-col w-full gap-2 lg:flex-row lg:gap-4">
                                <div class="flex flex-col w-full">
                                    <x-input-label for="progTitle" :value="__('Program Location')" />
                                    <x-text-input value="{{ $programInfo->program_Location }}"
                                        class="block w-full mt-1" type="text" disabled />
                                </div>
                                <div class="flex flex-col w-full lg:w-1/3">
                                    <x-input-label for="progTitle" :value="__('Industry Tag')" />
                                    <x-text-input value="{{ $programInfo->job_industry->industry_Title }}"
                                        class="block w-full mt-1" type="text" disabled />
                                </div>

                            </div>
                        </div>
                        <div class="flex flex-col w-full h-full">
                            <x-input-label for="job_tags">Job Position
                                Tags
                            </x-input-label>
                            <div
                                class="flex-inline border border-gray-300 rounded-lg p-1 mt-2 @if (empty($programInfo->program_tags)) h-[40px] @endif ">
                                @foreach ($programInfo->program_tags as $jobData)
                                    <span
                                        class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ">
                                        {{ $jobData->job_positions->position_Title }}
                                    </span>
                                @endforeach
                            </div>


                        </div>
                    </div>

                    <div class="mt-10">
                        <div class="Job-Description ">
                            <h1 class="text-xl font-bold text-blue-900">Description</h1>
                            <hr class="h-px mt-2 bg-gray-200 border-0 dark:bg-gray-700">
                            <div class="p-2 no-tailwindcss-base">
                                {!! $programInfo->program_Description !!}
                            </div>
                        </div>

                        <div class="Job-Qualification">

                            <h1 class="text-xl font-bold text-blue-900">Qualification</h1>


                            <hr class="h-px mt-2 bg-gray-200 border-0 dark:bg-gray-700">

                            <div class="p-2 no-tailwindcss-base">
                                {!! $programInfo->program_Qualification !!}
                            </div>
                        </div>

                        <div class="Job-Remarks">

                            <h1 class="text-xl font-bold text-blue-900">Remarks</h1>


                            <hr class="h-px mt-2 bg-gray-200 border-0 dark:bg-gray-700">

                            <div class="p-2 no-tailwindcss-base">
                                {!! $programInfo->program_Remarks !!}

                            </div>
                        </div>

                    </div>
                </div>
            </div>




        </div>






    </div>


    <x-modal name="cancel-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6" x-data="{ agreeBox: @entangle('agreeBox') }">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col my-4">
                <div class="flex flex-col items-center justify-center w-full px-4 mt-4 mb-4">
                    <span class="text-xl font-semibold">Are you sure you want to cancel this training?</span>
                    <p class="mt-2 text-center text-gray-600">
                        You are about to cancel the training program
                        <strong>{{ $programInfo->program_Title }}</strong>.
                        Once canceled, all registered users will be notified via email and the program will be marked as
                        <strong>Canceled</strong>. This action cannot be undone.
                    </p>
                    <p class="text-center text-gray-600">
                        Please confirm if you want to proceed.
                    </p>
                </div>

                <div class="inline-flex items-center justify-center w-full mt-4">
                    <label class="relative flex items-center p-3 rounded-full cursor-pointer" for="agreeBox">
                        <input wire:model="agreeBox" type="checkbox" id="agreeBox"
                            class="w-5 h-5 transition-all border rounded-md appearance-none cursor-pointer border-blue-gray-200 checked:border-blue-900 checked:bg-blue-600" />
                        <span
                            class="absolute text-white transform opacity-0 top-2/4 left-2/4 -translate-x-2/4 -translate-y-2/4 peer-checked:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                fill="currentColor" stroke="currentColor" stroke-width="1">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </label>
                    <label class="mt-px font-light text-gray-700 cursor-pointer select-none" for="agreeBox">
                        Confirm the cancellation of the program
                    </label>
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <x-secondary-button x-on:click="agreeBox = false; $dispatch('close-modal', 'cancel-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button x-bind:disabled="!agreeBox" wire:loading.attr="disabled" wire:target='cancelProgram'
                    wire:click.prevent="cancelProgram" class="ms-3" type="button">
                    {{ __('Confirm Cancellation') }}
                    <div wire:loading.delay.long wire:target="cancelProgram" role="status">
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
