<div wire:poll.5s>
    <div class="container py-8 mx-auto">

        <div class="grid grid-cols-4 gap-4 p-3 lg:grid-cols-12 lg:p-0">






            <div class="col-span-4 lg:col-span-5">
                <div class="p-4 overflow-hidden bg-white rounded-lg shadow-sm select-none">
                    <div class="flex flex-row items-center justify-center flex-shrink-0 h-full p-5">
                        <img src="{{ asset('storage/' . $ProgramInfo->program_pubmat) }}" alt="Default I mage"
                            class="w-[450px] h-[450px] bg-gray-300 rounded object-contain">
                    </div>

                    <hr class="h-px mt-4 bg-gray-200 border-0 dark:bg-gray-700">

                    <div class="flex flex-col w-full">

                        @php
                            $currentDate = now(); // Get the current date and time
                            $deadline = $ProgramInfo->program_Deadline; // Deadline from your data
                        @endphp

                        @if (!Auth::check() || (Auth::check() && auth()->user()->usertype <= 4))
                            <div class="flex flex-col items-center justify-center mt-5 mb-5">
                                @if ($currentDate->lessThan($deadline))
                                    <!-- Check if current date is before the deadline -->
                                    @if (!$isRegistered)
                                        <x-blue-button class="w-[350px] h-[40px] justify-center"
                                            wire:loading.attr="disabled" wire:target="registerValidate"
                                            wire:click.prevent='registerValidate'>
                                            PRE REGISTER
                                            <div wire:loading.delay.long role="status" wire:target="registerValidate">
                                                <svg aria-hidden="true"
                                                    class="w-4 h-4 ml-4 text-gray-200 animate-spin fill-blue-600"
                                                    viewBox="0 0 100 101" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
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
                                        <h1 class="mt-2">
                                            Registration ends: <span
                                                class="font-black text-red-500 text-md">{{ $deadline->format('F j, Y') }}</span>
                                        </h1>
                                    @elseif (Auth::check() && $isRegistered)
                                        <h1 class="text-xl font-semibold text-blue-500">
                                            You have already registered for this program.
                                        </h1>
                                    @endif
                                @else
                                    <!-- Content to show after the deadline -->
                                    <h1 class="text-xl font-semibold text-red-500">
                                        Registration has ended.
                                    </h1>
                                @endif
                            </div>
                        @endif

                        <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                        {{-- @endif --}}
                        <div class="flex flex-col w-full px-5 mt-5">

                            <ul>
                                <li class="mb-4">
                                    <div class="flex flex-row w-full gap-4">
                                        <div class="flex flex-col">


                                            <svg class="w-10 h-10 text-blue-500" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M3.262 10.878l7.991 8.789c.4.44 1.091.44 1.491 0l7.993-8.79c.313-.344.349-.859.087-1.243L17.287 4.44a.996.996 0 00-.823-.436H7.538a.996.996 0 00-.823.436 2713782426.663 2713782426.663 0 01-3.54 5.192c-.263.385-.227.901.087 1.246z" />
                                            </svg>


                                        </div>
                                        <div class="flex flex-col gap-1 ">
                                            <div class="text-xl font-bold text-black">
                                                Program Host
                                            </div>
                                            <div class="font-medium break-all text-md">
                                                {{ $ProgramInfo->program_Host }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <div class="flex flex-row w-full gap-4">
                                        <div class="flex flex-col">
                                            <svg class="w-10 h-10 text-blue-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                                            </svg>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <div class="text-xl font-bold text-black">
                                                Date Posted
                                            </div>
                                            <div class="font-medium break-all text-md">
                                                {{ $ProgramInfo->created_at->format('F j, Y') }}
                                            </div>


                                        </div>
                                    </div>
                                </li>
                                @if ($ProgramInfo->program_Datetime)
                                    <li class="mb-4">
                                        <div class="flex flex-row w-full gap-4">
                                            <div class="flex flex-col">

                                                <svg class="w-10 h-10 text-blue-500" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <polyline points="12 6 12 12 16 14" />
                                                </svg>
                                            </div>
                                            <div class="flex flex-col gap-1">
                                                <div class="text-xl font-bold text-black">
                                                    Program Time
                                                </div>
                                                <div class="font-medium break-all text-md">
                                                    {{ $ProgramInfo->program_Datetime->format('F j, Y g:i A') }}

                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                @endif
                                <li class="mb-4">
                                    <div class="flex flex-row w-full gap-4">
                                        <div class="flex flex-col">
                                            <svg class="w-10 h-10 text-blue-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z" />
                                            </svg>

                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <div class="text-xl font-bold text-black">
                                                Location
                                            </div>
                                            <div class="font-medium break-all text-md">
                                                {{ $ProgramInfo->program_Location }}
                                            </div>


                                        </div>
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <div class="flex flex-row w-full gap-4">
                                        <div class="flex flex-col">
                                            <svg class="w-10 h-10 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                            </svg>

                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <div class="text-xl font-bold text-black">
                                                Program Modality
                                            </div>
                                            <div class="font-medium break-all text-md">
                                                {{ $ProgramInfo->program_Modality }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <div class="flex flex-row w-full gap-4">
                                        <div class="flex flex-col">
                                            <svg class="w-10 h-10 text-blue-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M6 4h12M6 4v16M6 4H5m13 0v16m0-16h1m-1 16H6m12 0h1M6 20H5M9 7h1v1H9V7Zm5 0h1v1h-1V7Zm-5 4h1v1H9v-1Zm5 0h1v1h-1v-1Zm-3 4h2a1 1 0 0 1 1 1v4h-4v-4a1 1 0 0 1 1-1Z" />
                                            </svg>

                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <div class="text-xl font-bold text-black">
                                                Industry
                                            </div>
                                            <div class="font-medium break-all text-md">
                                                {{ $ProgramInfo->job_industry->industry_Title }}
                                            </div>


                                        </div>
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <div class="flex flex-row w-full gap-4">
                                        <div class="flex flex-col">

                                            <svg class="w-10 h-10 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>

                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <div class="text-xl font-bold text-black">
                                                Slots Left
                                            </div>

                                            <div class="font-medium break-all text-md">
                                                {{ $ProgramInfo->program_Slots - $ProgramInfo->program_reg->whereIn('program_reg_Status', ['ATTENDEE', 'COMPLETED'])->count() }}
                                            </div>

                                        </div>
                                </li>

                            </ul>
                        </div>

                    </div>
                </div>

                <div class="p-4 mt-4 overflow-hidden bg-white rounded-lg shadow-sm">
                    <div class="flex flex-row w-full select-none	">
                        <h1 class="text-xl font-bold text-blue-900">Job Tags</h1>
                    </div>
                    <hr class="h-px mt-2 bg-gray-200 border-0 dark:bg-gray-700">

                    <div class="p-1 mt-2 rounded-lg flex-inline ">
                        @foreach ($ProgramInfo->program_tags as $jobTag)
                            <span wire:key='jobTag-{{ $jobTag->job_positions->position_id }}'
                                class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $jobTag->job_positions->position_Title }}
                            </span>
                        @endforeach


                    </div>

                </div>
            </div>



            <div class="col-span-4 lg:col-span-7">
                <div class="overflow-hidden bg-white shadow-sm lg:rounded-lg">


                    <div class="flex flex-col w-full h-full p-5 space-y-2">

                        <div class="flex flex-col">
                            <h1 class="text-3xl font-bold text-blue-500 lg:text-6xl">{{ $ProgramInfo->program_Title }}
                            </h1>
                        </div>

                        <div class="Job-Description ">
                            <div class="flex flex-row w-full mt-10">
                                <h1 class="text-xl font-bold text-blue-900">Description</h1>
                            </div>
                            <hr class="h-px mt-2 bg-gray-200 border-0 dark:bg-gray-700">

                            <div class="p-2 no-tailwindcss-base">
                                {!! $ProgramInfo->program_Description !!}

                            </div>
                        </div>

                        <div class="Job-Qualification">

                            <h1 class="text-xl font-bold text-blue-900">Qualification</h1>


                            <hr class="h-px mt-2 bg-gray-200 border-0 dark:bg-gray-700">

                            <div class="p-2 no-tailwindcss-base">
                                {!! $ProgramInfo->program_Qualification !!}
                            </div>
                        </div>

                        @if ($ProgramInfo->program_Remarks)
                            <div class="Job-Remarks">

                                <h1 class="text-xl font-bold text-blue-900">Remarks</h1>


                                <hr class="h-px mt-2 bg-gray-200 border-0 dark:bg-gray-700">

                                <div class="p-2 no-tailwindcss-base">
                                    {!! $ProgramInfo->program_Remarks !!}

                                </div>
                            </div>
                        @endif

                    </div>
                </div>


            </div>
        </div>





        <x-modal name="register-modal" focusable>
            <div class="items-center w-full max-w-4xl px-6 py-6" x-data="{ agreeBox: @entangle('agreeBox') }">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to register?') }}
                </h2>
                <hr>
                <div class="flex flex-col my-4">
                    <div class="flex flex-col items-center justify-center w-full px-4 mt-4">
                        <p class="text-sm text-justify lg:text-md">
                            By registering for skills training with the Public Employment Services Office (PESO), you
                            confirm that all information provided is accurate and up-to-date. You consent to the
                            collection and use of your personal data for training and employment purposes in line with
                            data protection laws, including the Data Privacy Act. Your data will be accessible only to
                            authorized personnel involved in managing the program. Any false or misleading information
                            may affect your eligibility and reputation. You agree to these terms and conditions by
                            proceeding with your registration.
                        </p>
                        <div class="inline-flex items-center mt-4">
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
                                I agree with the terms
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between mt-6">
                    <x-secondary-button x-on:click="agreeBox = false; $dispatch('close-modal', 'register-modal')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-green-button x-show="agreeBox" wire:loading.attr="disabled" wire:click.prevent="register"
                        class="ms-3" type="button">
                        {{ __('Confirm') }}
                        <div wire:loading.delay.long wire:target="updateApplicant('REJECT', 'reject')" role="status">
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
                    </x-green-button>
                </div>
            </div>
        </x-modal>

        <x-modal name="login-modal" focusable>
            <div
                class="w-full max-w-2xl px-6 py-8 mx-auto border border-gray-200 rounded-lg shadow-xl bg-gradient-to-r from-blue-50 to-white">
                <h2 class="pb-2 mb-4 text-2xl font-bold text-gray-900 border-b-2 border-gray-300">
                    {{ __('Action Required') }}
                </h2>
                <div class="flex flex-col items-center mb-8 text-center">
                    <h1 class="mb-4 text-2xl font-extrabold text-gray-800">You need to be logged in to register.</h1>
                    <p class="text-lg text-gray-600">Please log in to register. If you don't have an
                        account, you can register as well.</p>
                </div>
                <div class="flex justify-between mt-6 space-x-4">
                    <x-secondary-button x-on:click="$dispatch('close-modal', 'login-modal')"
                        class="text-gray-800 transition-transform transform bg-gray-200 rounded-lg shadow-sm hover:bg-gray-300 hover:scale-105"
                        type="button">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}">
                            <x-green-button
                                class="text-white transition-transform transform bg-green-500 rounded-lg shadow-md hover:bg-green-600 hover:scale-105"
                                type="button">
                                {{ __('Log In') }}
                            </x-green-button>
                        </a>

                        <a href="{{ route('register') }}">
                            <x-primary-button x-on:click="$dispatch('register-modal')"
                                class="text-white transition-transform transform bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 hover:scale-105"
                                type="button">
                                {{ __('Register') }}
                            </x-primary-button>
                        </a>

                    </div>
                </div>
            </div>
        </x-modal>





    </div>
</div>
