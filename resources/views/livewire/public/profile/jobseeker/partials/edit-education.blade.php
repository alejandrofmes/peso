<div>
    <div x-show="profileTab === 'editEducation'" class="container" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-cloak>
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <div class="flex flex-row items-center justify-between w-full mb-4">
                <div class="flex flex-row items-center gap-4">
                    <div class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300"
                        @click="profileTab = 'profileOverview'">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold">Education</h2>

                </div>

                <div class="flex flex-row items-center gap-4">
                    <div x-data="{ tooltip: 'Add Education Record' }">
                        <div x-tooltip="tooltip"
                            class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300"
                            x-data="" {{-- x-on:click.prevent="$dispatch('open-modal', 'education-modal')" --}} wire:click.prevent='addModal()'>
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>

                        </div>
                    </div>
                </div>

            </div>

            @if ($educ->isEmpty())

                <div class="flex flex-col items-center justify-center mt-20 mb-20">
                    <div class="flex p-1 bg-blue-200 rounded-full">

                        <svg class="w-24 h-24 text-black" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                        </svg>

                    </div>

                    <div class="mt-5 text-xl font-semibold text-center text-black">
                        Education is empty.
                    </div>
                </div>
            @else
                {{-- <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 "> --}}

                @foreach ($educ as $education)
                    <div wire:key="{{ $education->education_id }}" class="container p-3">

                        <div class="flex flex-row items-center h-full">

                            <div class="flex flex-col">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-10 h-10 text-gray-800 lg:w-20 lg:h-20 ">
                                    <path
                                        d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                                    <path
                                        d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                                    <path
                                        d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                                </svg>
                            </div>

                            <div class="flex flex-col w-full ml-4">
                                <span class="text-3xl font-black text-black uppercase">{{ $education->edu_School }}</span>
                                <div class="text-xl font-semibold text-black uppercase">{{ $education->edu_Course }}</div>
                                <span class="font-medium text-gray-700 uppercase text-md">
                                    {{ $education->edu_Started->format('F Y') }} -
                                    {{ $education->edu_Ongoing == 1 ? 'Present' : $education->edu_Ended->format('F Y') }}
                                </span>
                            </div>


                            <div class="flex flex-row items-center justify-center h-full gap-2">
                                <div x-data="{ tooltip: 'Remove Education Record' }">
                                    <div x-tooltip="tooltip"
                                        wire:click.prevent='deleteData({{ $education->education_id }})'
                                        class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-red-300">
                                        <svg class="w-10 h-10 text-red-700" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>


                                    </div>
                                </div>
                                <div x-data="{ tooltip: 'Edit Education Record' }">
                                    <div x-tooltip="tooltip"
                                        wire:click.prevent='editModal({{ $education->education_id }})'
                                        class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-blue-300">
                                        <svg class="w-10 h-10 text-blue-700" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                    <hr class="h-0.5 my-2 mx-10 bg-blue-200 border-0">
                @endforeach




                {{-- </div> --}}
            @endif

        </div>
    </div>



    <x-modal name="education-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Education Record') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">

                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="eduSchool" :value="__('School')" />
                    <x-text-input wire:model="eduSchool" class="block w-full mt-1" type="text" />
                    <x-input-error :messages="$errors->get('eduSchool')" class="mt-2" />
                </div>
                <div class="flex flex-row w-full mt-2">
                    <div class="flex flex-col w-full">
                        <x-input-label for="eduLevel" :value="__('Level')" />
                        <select wire:model='eduLevel' class="block w-full mt-1 rounded"
                            x-on:change="$wire.eduLevel <= 18 ? $wire.eduCourse = '' : ''">
                            <option value="" disabled>Select Level</option>
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
                            <option value="22">4TH YEAR COLLEG LEVEL</option>
                            <option value="23">5TH YEAR COLLEGE LEVEL</option>
                            <option value="24">COLLEGE GRADUATE</option>
                            <option value="25">MASTERAL/POST GRADUATE LEVEL</option>
                            <option value="26">MASTERAL/POST GRADUATE</option>
                        </select>
                        <x-input-error :messages="$errors->get('eduLevel')" class="mt-2" />
                    </div>
                    <div class="flex flex-col w-full ml-4">
                        <x-input-label for="eduCourse" :value="__('Course')" />
                        <x-text-input wire:model="eduCourse" x-bind:disabled="$wire.eduLevel <= 18"
                            class="block w-full mt-1" type="text" />
                        <x-input-error :messages="$errors->get('eduCourse')" class="mt-2" />
                    </div>
                </div>
                <div class="flex flex-col w-full gap-4 mt-2 lg:flex-row" x-data="{ eduOngoing: @entangle('eduOngoing'), eduEnd: @entangle('eduEnd') }">
                    <div class="flex flex-col w-full">
                        <x-input-label for="eduStart" :value="__('Started')" />
                        <x-text-input wire:model="eduStart" class="block w-full mt-1" type="date" />
                        <x-input-error :messages="$errors->get('eduStart')" class="mt-2" />
                    </div>
                    <div class="flex flex-col w-full ml-4">
                        <x-input-label for="eduEnd" :value="__('Ended')" />
                        <x-text-input wire:model="eduEnd" class="block w-full mt-1" type="date"
                            x-bind:disabled='eduOngoing' />

                        <x-input-error :messages="$errors->get('eduEnd')" class="mt-2" />
                    </div>

                    <div class="flex flex-row items-center justify-center w-full h-full lg:mt-8">
                        <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                            <input @click="eduEnd = eduOngoing ? eduEnd: ''" wire:model='eduOngoing'
                                x-model="eduOngoing"
                                class="relative float-left -ml-[1.5rem] mr-[6px] mt-[0.15rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0 checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem] checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent "
                                type="checkbox" id="education-completed" />
                            <x-input-label class="font-bold ml-2 inline-block pl-[0.15rem] hover:cursor-pointer"
                                for="education-completed" :value="__('ON GOING')" />
                        </div>
                    </div>
                </div>

            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button wire:click.prevent='close' type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent='save' class="ms-3" type="button">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>


    <x-modal name="delete-education-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center my-12">

                <h1 class="text-2xl font-bold">Are you sure you want to delete this education record?</h1>


            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-education-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled" wire:click.prevent="deleteRecord()" class="ms-3"
                    type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="deleteRecord()" role="status">
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
