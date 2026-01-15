<div wire:poll>
    <div class="mt-12">
        <div class="max-w-3xl px-2 mx-auto lg:px-8">

            <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500 lg:text-base">
                <li
                    class="flex md:w-full items-center text-blue-600  lg:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden lg:after:inline-block after:mx-6 xl:after:mx-10 ">
                    <span class="flex items-center after:content-['/'] lg:after:hidden after:mx-2 after:text-gray-200 ">
                        <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        Job <span class="hidden lg:inline-flex lg:ms-2">Information</span>
                    </span>
                </li>


                @if ($currentSlide < 2)
                    <li class="flex items-center">
                        <span class="me-2">2</span>
                        Confirmation
                    </li>
                @else
                    <li class="flex items-center text-blue-600">
                        <span
                            class="flex items-center after:content-['/'] lg:after:hidden after:mx-2 after:text-gray-200">
                            <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 me-2.5" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            Confirmation
                        </span>
                    </li>
                @endif

            </ol>

        </div>
    </div>



    <div class=" {{ $currentSlide != 1 ? 'hidden' : '' }} post-section py-3" id="step1">
        <div class="max-w-6xl p-2 mx-auto lg:px-8">


            {{-- FIRST CONTAINER - JOB INFORMATION --}}
            <div class="px-6 overflow-hidden bg-white shadow-sm lg:rounded-lg">
                {{-- TITLE --}}
                <h1 class="mt-4 mb-4 text-5xl font-bold">Fill in the Details</h1>


                <div class="flex flex-col w-full gap-4 mt-4 lg:flex-row">

                    <div class="flex flex-col w-full">
                        <x-input-label for="jobTitlePost">Job Title*
                        </x-input-label>
                        <x-text-input wire:model='jobTitlePost' class="block w-full mt-1" type="text" />
                        <x-input-error :messages="$errors->get('jobTitlePost')" class="mt-2" />
                    </div>

                    <div class="flex flex-col w-full">
                        <x-input-label for="jobIndustryPost">Job Industry*
                        </x-input-label>
                        <x-text-input wire:model='jobIndustryPost' class="block w-full mt-1" type="text" readonly
                            x-data="" x-on:click.prevent="$dispatch('open-modal', 'industry-modal')"
                            x-on:focus="$dispatch('open-modal', 'industry-modal')" />
                        <x-input-error :messages="$errors->get('jobIndustryPost')" class="mt-2" />
                    </div>

                </div>

                <div class="flex flex-col w-full gap-4 mt-4 lg:flex-row">

                    <div class="flex flex-col w-full gap-4 lg:flex-row lg:w-1/2">

                        <div class="flex flex-col w-full">
                            <x-input-label for="minWagePost">Minimum Wage
                            </x-input-label>
                            <x-text-input wire:model='minWagePost' class="block w-full mt-1" type="text" />
                            <x-input-error :messages="$errors->get('minWagePost')" class="mt-2" />
                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="maxWagePost">Max Wage
                            </x-input-label>
                            <x-text-input wire:model='maxWagePost' class="block w-full mt-1" type="text" />
                            <x-input-error :messages="$errors->get('maxWagePost')" class="mt-2" />
                        </div>

                    </div>


                    <div class="flex flex-col lg:w-1/2">
                        <x-input-label for="eduPost">Educational Attainment*
                        </x-input-label>
                        <select wire:model='eduPost' class="block w-full mt-1 rounded">
                            <option value="" disabled selected>Select Type</option>
                            <option value="0">NONE</option>
                            <option value="1">GRADE I</option>
                            <option value="2">GRADE II</option>
                            <option value="3">GRADE III</option>
                            <option value="4">GRADE IV</option>
                            <option value="5">GRADE V</option>
                            <option value="6">GRADE VI</option>
                            <option value="7">GRADE VII</option>
                            <option value="8">GRADE VIII</option>
                            <option value="9">ELEMENTARY GRADUATE</option>
                            <option value="10">1ST YEAR HIGH SCHOOL/GRADE VII (FOR K TO 12)</option>
                            <option value="11">2ND YEAR HIGH SCHOOL/GRADE VIII (FOR K TO 12)</option>
                            <option value="12">3RD YEAR HIGH SCHOOL/GRADE IX (FOR K TO 12)</option>
                            <option value="13">4TH YEAR HIGH SCHOOL/GRADE X (FOR K TO 12)</option>
                            <option value="14">GRADE XI (FOR K TO 12)</option>
                            <option value="15">GRADE XII (FOR K TO 12)</option>
                            <option value="16">HIGH SCHOOL GRADUATE</option>
                            <option value="17">VOCATIONAL UNDERGRADUATE</option>
                            <option value="18">VOCATIONAL GRADUATE</option>
                            <option value="19">1ST YEAR COLLEGE LEVEL</option>
                            <option value="20">2ND YEAR COLLEGE LEVEL</option>
                            <option value="21">3RD YEAR COLLEGE LEVEL</option>
                            <option value="22">4TH YEAR COLLEGE LEVEL</option>
                            <option value="23">5TH YEAR COLLEGE LEVEL</option>
                            <option value="24">COLLEGE GRADUATE</option>
                            <option value="25">MASTERAL/POST GRADUATE LEVEL</option>
                            <option value="26">MASTERAL/POST GRADUATE</option>
                        </select>
                        <x-input-error :messages="$errors->get('eduPost')" class="mt-2" />
                    </div>

                    <div class="flex flex-col lg:w-1/2">
                        <x-input-label for="jtypePost">Job Type*
                        </x-input-label>
                        <select wire:model='jtypePost' class="block w-full mt-1 rounded">
                            <option value="" disabled selected>Select Type</option>
                            <option value="1">Full-Time</option>
                            <option value="2">Contractual</option>
                            <option value="3">Part-Time</option>
                            <option value="4">Project-Based</option>
                            <option value="5">Intership/OJT</option>
                            <option value="6">Work From Home</option>


                        </select>
                        <x-input-error :messages="$errors->get('jtypePost')" class="mt-2" />
                    </div>

                </div>

                <div class="flex flex-col w-full gap-4 mt-4 mb-4 lg:flex-row">

                    <div class="flex flex-row w-full gap-4 lg:w-1/3">
                        <div class="flex flex-col w-full">
                            <x-input-label for="wAddPost">Work Address*
                            </x-input-label>
                            <x-text-input wire:model='wAddPost' class="block w-full mt-1" type="text" />
                            <x-input-error :messages="$errors->get('wAddPost')" class="mt-2" />
                        </div>

                    </div>

                    <div class="flex flex-col w-full gap-4 lg:flex-row lg:w-2/3">
                        <div class="flex flex-col w-full">
                            <x-input-label for="barPost">Barangay*
                            </x-input-label>
                            <x-text-input wire:model='barPost' class="block w-full mt-1" type="text" readonly
                                x-data="" x-on:click.prevent="$dispatch('open-modal', 'barangay-modal')"
                                x-on:focus="$dispatch('open-modal', 'barangay-modal')" />
                            <x-input-error :messages="$errors->get('barPost')" class="mt-2" />
                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="mun">Province*
                            </x-input-label>
                            <x-text-input wire:model='mun' class="block w-full mt-1" type="text" readonly />
                            <x-input-error :messages="$errors->get('mun')" class="mt-2" />
                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="prov">Municipallity*
                            </x-input-label>
                            <x-text-input wire:model='prov' class="block w-full mt-1" type="text" readonly />
                            <x-input-error :messages="$errors->get('prov')" class="mt-2" />
                        </div>
                    </div>

                </div>


            </div>

        </div>

        <div class="max-w-6xl px-2 mx-auto mt-3 lg:px-8">
            <div class="px-6 overflow-hidden bg-white shadow-sm lg:rounded-lg">

                <div class="flex flex-col w-full gap-4 my-4 lg:flex-row">

                    <div class="flex flex-col w-full lg:w-1/2">
                        <x-input-label for="pesoPost">PESO Branch*
                        </x-input-label>
                        <select wire:model='pesoPost' class="block w-full mt-1 rounded">
                            <option value="" disabled selected>Select Branch</option>

                            @foreach ($pesoBranches as $pesoData)
                                <option value="{{ $pesoData->peso_id }}">
                                    {{ $pesoData->municipality->municipality_Name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('pesoPost')" class="mt-2" />
                    </div>
                    <div class="flex flex-col w-full lg:w-1/2">
                        <x-input-label for="disability" :value="__('Accept PWDs?*')" />
                        <div class="flex flex-row gap-4 mt-2">
                            <div class="flex items-center">
                                <input wire:model='disabilityPost' id="disability-yes" type="radio" value="1"
                                    name="disabilityAccept"
                                    class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                <label for="disability-yes" class="text-sm font-medium text-gray-900 ms-2">Yes</label>
                            </div>
                            <div class="flex items-center">
                                <input wire:model='disabilityPost' id="disability-no" type="radio" value="2"
                                    name="disabilityAccept"
                                    class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                <label for="disability-no" class="text-sm font-medium text-gray-900 ms-2">No</label>
                            </div>

                        </div>
                        <x-input-error :messages="$errors->get('disabilityPost')" class="mt-2" />

                    </div>



                </div>

                <div class="flex flex-col w-full gap-4 mt-4 lg:flex-row">

                    <div class="flex flex-col w-full lg:w-1/2">
                        <x-input-label for="durationPost">Job Posting Duration*
                        </x-input-label>
                        <x-text-input wire:model='durationPost' class="block w-full mt-1" type="date" />
                        <x-input-error :messages="$errors->get('durationPost')" class="mt-2" />
                    </div>

                    <div class="flex flex-col w-full mb-5 lg:w-1/3">
                        <x-input-label for="slotsPost">Job Slots*
                        </x-input-label>
                        <x-text-input wire:model='slotsPost' class="block w-full mt-1" type="text" />
                        <x-input-error :messages="$errors->get('slotsPost')" class="mt-2" />
                    </div>

                </div>


            </div>
        </div>



        <div class="max-w-6xl px-2 mx-auto mt-3 lg:px-8">
            <div class="px-6 overflow-hidden bg-white shadow-sm lg:rounded-lg">

                <div class="flex flex-row w-full gap-4 my-4">
                    <div class="flex flex-col w-full">

                        <div class="flex flex-row items-center w-full">

                            <x-input-label for="fname"> </i> Job Position
                                Tags*
                            </x-input-label>

                            <x-primary-button class="ml-auto mr-3" type="button" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'job-position-modal')">
                                Add Job Tag
                            </x-primary-button>

                        </div>

                        <div
                            class="flex-inline border border-gray-300 rounded-lg p-1 mt-2 @if (empty($jobTags)) h-[40px] @endif ">


                            @foreach ($jobTags as $jobData)
                                <span
                                    class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ">
                                    {{ $jobData['position_Title'] }}
                                    <button wire:loading.attr="disabled"
                                        wire:click.prevent='removeTag( {{ $jobData['position_id'] }})' type="button"
                                        class="inline-flex items-center justify-center flex-shrink-0 rounded-full size-4 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 focus:text-blue-500 ">
                                        <span class="sr-only">Remove badge</span>
                                        <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M18 6 6 18" />
                                            <path d="m6 6 12 12" />
                                        </svg>
                                    </button>
                                </span>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('jobTags')" class="mt-2" />

                    </div>
                </div>

            </div>
        </div>


        <div class="max-w-6xl px-2 mx-auto mt-3 lg:px-8">
            <div class="px-6 overflow-hidden bg-white shadow-sm lg:rounded-lg">

                <div class="flex flex-col w-full mt-4 space-y-5 lg:flex-row lg:lg:space-y-0 lg:space-x-5">

                    <div class="flex flex-col w-full lg:w-1/2 ">
                        <x-input-label for="descPost">Job Description*
                        </x-input-label>
                        <div wire:ignore>
                            <textarea id="descText"></textarea>
                        </div>


                        @if ($errors->has('descPost'))
                            <x-input-error :messages="$errors->get('descPost')" class="mt-2" />
                        @endif

                    </div>


                    <div class="flex flex-col w-full lg:w-1/2 ">
                        <x-input-label for="qualPost">Job Qualification*
                        </x-input-label>
                        <div wire:ignore>
                            <textarea id="qualText"></textarea>
                        </div>

                        @if ($errors->has('qualPost'))
                            <x-input-error :messages="$errors->get('qualPost')" class="mt-2" />
                        @endif
                    </div>

                </div>

                <div class="flex flex-col w-full mt-4">
                    <x-input-label for="remText">Remarks
                    </x-input-label>
                    <div wire:ignore>
                        <textarea id="remText"></textarea>
                    </div>

                    @if ($errors->has('remPost'))
                        <x-input-error :messages="$errors->get('remPost')" class="mt-2" />
                    @endif

                </div>

                <div class="flex flex-row justify-end mt-4 mb-4 ">
                    <x-blue-button wire:loading.attr="disabled" wire:click.prevent='nextSection(2)'
                        type="button">Next
                        <div wire:loading.delay.long wire:target="nextSection(2)" role="status">
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


            </div>
        </div>


    </div>


    <div class=" {{ $currentSlide != 2 ? 'hidden' : '' }} post-section py-3" id="step3" x-data="{ agreePost: @entangle('agreePost') }">

        <div class="max-w-6xl mx-auto lg:px-8">
            <div class="px-6 overflow-hidden bg-white shadow-sm lg:rounded-lg">
                <div class="flex flex-row items-center justify-center w-full mt-10">
                    <x-profile-logo class="h-36 w-36">

                    </x-profile-logo>
                </div>
                <div class="flex flex-col justify-center w-full px-2 mt-4 lg:px-20">
                    <div>
                        <p>By checking the box provided, you acknowledge that the information contained in this job
                            posting
                            is intended for the consideration of potential job seekers and is subject to approval by the
                            Public Employment Services Office (PESO). You agree that the details provided herein are for
                            informational purposes only and do not constitute any form of contractual agreement between
                            you
                            and the job seekers.</p>
                        <br>
                        <p>Please be aware that this job posting may undergo revisions or amendments by PESO to ensure
                            compliance with regulatory standards. While efforts are made to ensure the accuracy and
                            authenticity of the information presented, we cannot guarantee the completeness,
                            reliability, or
                            timeliness of the content.</p>
                        <p>You, as the employer, are solely responsible for reviewing and selecting suitable job seekers
                            for
                            your employment needs. PESO reserves the right to modify, update, or withdraw this posting
                            if it
                            does not adhere to established rules or guidelines.</p>
                        <br>
                        <p>By checking this box, you acknowledge and accept that your confirmation of this disclaimer
                            affirms your role as the employer, responsible for engaging with potential job seekers based
                            on
                            the information provided in this posting.</p>
                        <p>For any inquiries or clarifications regarding this job posting, please contact the Public
                            Employment Services Office or the designated employer representative.</p>
                        <br>
                        <p>Thank you for your understanding and cooperation.</p>
                    </div>
                    <div class="flex flex-col items-center justify-center w-full mt-12 ">
                        <div class="flex flex-row items-center justify-center w-full">
                            <input wire:model='agreePost' id="link-checkbox" type="checkbox" value="1"
                                class="justify-center px-3 py-3 text-sm font-medium rounded-lg lg:mr-2">
                            <label for="link-checkbox" class="text-sm font-medium text-gray-900 ms-2 ">I
                                agree with the <p class="hover:cursor-pointer text-blue-600 hover:underline" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'terms-modal')">terms and
                                    conditions.</p></label>
                        </div>

                        <x-input-error :messages="$errors->get('agreePost')" class="mt-2" />
                    </div>
                </div>




                <div class="flex flex-row justify-between w-full mt-24 mb-4 ">
                    <x-secondary-button wire:click.prevent='prevSection(1)' type="button"
                        wire:loading.attr="disabled">Previous</x-secondary-button>
                    <x-green-button wire:click.prevent='createApplication' type="button"
                        wire:loading.attr="disabled">Confirm
                        <div wire:loading.delay.long wire:target="createApplication" role="status">
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
                    </x-green-button>
                </div>

            </div>
        </div>

    </div>

    <livewire:modals.job-position-modal />
    <livewire:modals.industry-modal />
    <livewire:modals.barangay-modal />
    <x-modal name="terms-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <div class="flex flex-row justify-between">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Terms and Conditions for Job Posting') }}
                </h2>
                <svg class="size-6 cursor-pointer hover:text-gray-500"
                    x-on:click="$dispatch('close-modal', 'terms-modal')" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <hr>
            <div class="flex flex-col my-4">
                <div class="flex flex-col max-h-[600px] overflow-y-auto">
                    <div class="p-4 bg-white text-gray-800 space-y-6">
                        <h2 class="text-2xl font-bold">Terms and Conditions for Job Posting</h2>
    
                        <section>
                            <h3 class="text-lg font-semibold">1. Acceptance of Terms</h3>
                            <p>
                                By submitting a job posting through our platform, you, the employer, acknowledge and agree to abide by these Terms and Conditions. You affirm that all information provided in your job posting is accurate and complete.
                            </p>
                        </section>
    
                        <section>
                            <h3 class="text-lg font-semibold">2. Purpose of Posting</h3>
                            <p>
                                The information contained in your job posting is intended for the consideration of potential job seekers. This content is subject to approval by the Public Employment Services Office (PESO) and is for informational purposes only. It does not constitute any form of contractual agreement between you and the job seekers.
                            </p>
                        </section>
    
                        <section>
                            <h3 class="text-lg font-semibold">3. Responsibility of the Employer</h3>
                            <p>
                                As the employer, you are solely responsible for reviewing and selecting suitable job seekers for your employment needs. PESO is not liable for any decisions made based on the job postings or the candidates’ qualifications.
                            </p>
                        </section>
    
                        <section>
                            <h3 class="text-lg font-semibold">4. Compliance with Standards</h3>
                            <p>
                                You agree that your job posting must comply with all applicable laws and regulations. PESO reserves the right to modify, update, or withdraw your posting if it does not adhere to established rules or guidelines.
                            </p>
                        </section>
    
                        <section>
                            <h3 class="text-lg font-semibold">5. Accuracy and Authenticity</h3>
                            <p>
                                While efforts are made to ensure the accuracy and authenticity of the information presented, PESO cannot guarantee the completeness, reliability, or timeliness of the content. It is your responsibility to ensure that all details are accurate and up-to-date.
                            </p>
                        </section>
    
                        <section>
                            <h3 class="text-lg font-semibold">6. Amendments to Job Postings</h3>
                            <p>
                                Please be aware that your job posting may undergo revisions or amendments by PESO to ensure compliance with regulatory standards. Any changes will be communicated to you promptly.
                            </p>
                        </section>
    
                        <section>
                            <h3 class="text-lg font-semibold">7. Disclaimer of Liability</h3>
                            <p>
                                PESO shall not be held liable for any losses, damages, or issues arising from the job posting or the engagement with job seekers based on the information provided. You acknowledge that your confirmation of this disclaimer affirms your responsibility as the employer.
                            </p>
                        </section>
    
                        <section>
                            <h3 class="text-lg font-semibold">8. Contact Information</h3>
                            <p>
                                For any inquiries or clarifications regarding your job posting, please contact the Public Employment Services Office or your designated employer representative.
                            </p>
                        </section>
    
                        <section>
                            <h3 class="text-lg font-semibold">9. Agreement</h3>
                            <p>
                                By checking the box provided and submitting your job posting, you acknowledge that you have read, understood, and agree to these Terms and Conditions.
                            </p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </x-modal>
    
</div>



@push('scripts')
    <script data-navigate-once>
        document.addEventListener('livewire:load', () => {
            initializeSummernote();
        });

        document.addEventListener('livewire:navigated', () => {
            initializeSummernote();
        });

        function initializeSummernote() {
            // Ensure the Summernote editor is initialized only once
            if ($('#descText').hasClass('note-editor')) {
                return; // Exit if already initialized
            }
            if ($('#qualText').hasClass('note-editor')) {
                return; // Exit if already initialized
            }
            if ($('#remText').hasClass('note-editor')) {
                return; // Exit if already initialized
            }

            // Initialize the description editor
            $('#descText').summernote({
                placeholder: 'Write training description here...',
                tabsize: 2,
                height: 300,
                disableResizeEditor: true, // Optional to remove resize
                disableDragAndDrop: true, // Prevent drag-and-drop for images
                toolbar: [
                    ['font', ['bold', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ],
                callbacks: {
                    onInit: function() {
                        // Set initial content from Livewire when the editor is initialized
                        $('#descText').summernote('code', @this.get('descPost') || '');
                    },
                    onChange: function(contents) {
                        // Only update Livewire if the content has changed
                        if (contents !== @this.get('descPost')) {
                            if (contents.replace(/\s/g, '').toLowerCase() === '<br>' ||
                                contents.replace(/\s/g, '').toLowerCase() === '<br/>' ||
                                contents.replace(/\s/g, '').toLowerCase() === '<br />') {
                                @this.set('descPost', '');
                            } else {
                                @this.set('descPost', contents);
                            }
                        }
                    }
                }
            });

            // Initialize the qualifications editor
            $('#qualText').summernote({
                placeholder: 'Write training qualifications here...',
                tabsize: 2,
                height: 300,
                disableResizeEditor: true, // Optional to remove resize
                disableDragAndDrop: true, // Prevent drag-and-drop for images
                toolbar: [
                    ['font', ['bold', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ],
                callbacks: {
                    onInit: function() {
                        // Set initial content from Livewire when the editor is initialized
                        $('#qualText').summernote('code', @this.get('qualPost') || '');
                    },
                    onChange: function(contents) {
                        // Only update Livewire if the content has changed
                        if (contents !== @this.get('qualPost')) {
                            if (contents.replace(/\s/g, '').toLowerCase() === '<br>' ||
                                contents.replace(/\s/g, '').toLowerCase() === '<br/>' ||
                                contents.replace(/\s/g, '').toLowerCase() === '<br />') {
                                @this.set('qualPost', '');
                            } else {
                                @this.set('qualPost', contents);
                            }
                        }
                    }
                }
            });

            // Initialize the remarks editor
            $('#remText').summernote({
                placeholder: 'Write remarks here...',
                tabsize: 2,
                height: 200,
                disableResizeEditor: true, // Optional to remove resize
                disableDragAndDrop: true, // Prevent drag-and-drop for images
                toolbar: [
                    ['font', ['bold', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ],
                callbacks: {
                    onInit: function() {
                        // Set initial content from Livewire when the editor is initialized
                        $('#remText').summernote('code', @this.get('remPost') || '');
                    },
                    onChange: function(contents) {
                        // Only update Livewire if the content has changed
                        if (contents !== @this.get('remPost')) {
                            if (contents.replace(/\s/g, '').toLowerCase() === '<br>' ||
                                contents.replace(/\s/g, '').toLowerCase() === '<br/>' ||
                                contents.replace(/\s/g, '').toLowerCase() === '<br />') {
                                @this.set('remPost', '');
                            } else {
                                @this.set('remPost', contents);
                            }
                        }
                    }
                }
            });

            // Hide the status bar for all editors
            $('.note-statusbar').hide();
        }
    </script>
@endpush
