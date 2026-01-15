<x-modal name="education-modal" focusable>
    <div class="w-full max-w-4xl px-6 py-6 items-center">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add Education Record') }}
        </h2>
        <hr>
        <div class="flex flex-col mt-2">

            <div class="flex flex-col mt-2 w-full">
                <x-input-label for="eduSchool" :value="__('School*')" />
                <x-text-input wire:model='eduSchool' class="block mt-1 w-full" type="text" />
                <x-input-error :messages="$errors->get('eduSchool')" class="mt-2" />
            </div>
            <div class="flex flex-col lg:flex-row gap-4 mt-2 w-full">
                <div class="flex flex-col w-full">
                    <x-input-label for="eduLevel" :value="__('Level*')" />
                    <select wire:model='eduLevel' class="block mt-1 w-full rounded"
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
                <div class="flex flex-col w-full">
                    <x-input-label for="eduCourse" :value="__('Course')" />
                    <x-text-input wire:model="eduCourse" x-bind:disabled="$wire.eduLevel <= 18"
                        class="block mt-1 w-full" type="text" />
                    <x-input-error :messages="$errors->get('eduCourse')" class="mt-2" />
                </div>

            </div>
            <div class="flex flex-col lg:flex-row  mt-2 w-full gap-4" x-data="{ eduOngoing: @entangle('eduOngoing'), eduEnd: @entangle('eduEnd') }">
                <div class="flex flex-col w-full">
                    <x-input-label for="eduStart" :value="__('Started*')" />
                    <x-text-input wire:model='eduStart' class="block mt-1 w-full" type="date" />
                    <x-input-error :messages="$errors->get('eduStart')" class="mt-2" />
                </div>
                <div class="flex flex-col w-full">
                    <x-input-label for="eduEnd" :value="__('Ended')" />
                    <x-text-input wire:model='eduEnd' class="block mt-1 w-full" type="date"
                        x-bind:disabled='eduOngoing' />
                    <x-input-error :messages="$errors->get('eduEnd')" class="mt-2" />
                </div>
                <div class="flex flex-row h-full w-full items-center justify-center lg:mt-8">
                    <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                        <input x-on:click="eduEnd = eduOngoing ? null : eduEnd" wire:model='eduOngoing'
                            x-model="eduOngoing"
                            class="relative float-left -ml-[1.5rem] mr-[6px] mt-[0.15rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0 checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem] checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent "
                            type="checkbox" id="education-completed" />
                        <x-input-label class="font-bold ml-2 inline-block pl-[0.15rem] hover:cursor-pointer"
                            for="education-completed" :value="__('ON GOING')" />
                    </div>
                </div>
            </div>


        </div>
        <div class="mt-6 flex justify-end">
            <x-secondary-button wire:loading.attr="disabled" wire:click.prevent='close' type="button">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button wire:loading.attr="disabled" wire:click.prevent='addEducation' class="ms-3"
                type="button">
                {{ __('Add Education Record') }}
            </x-primary-button>
        </div>
    </div>
</x-modal>
