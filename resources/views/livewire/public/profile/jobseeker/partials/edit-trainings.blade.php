<div>
    <div x-show="profileTab === 'editTrainings'" class="container" x-transition:enter="transition ease-out duration-300"
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
                    <h2 class="text-xl font-bold">Trainings</h2>

                </div>

                <div class="flex flex-row items-center gap-4">
                    <div x-data="{ tooltip: 'Add Training Record' }">
                        <div x-tooltip="tooltip"
                            class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300"
                            wire:click.prevent='addModal()'>
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                    </div>
                </div>

            </div>
            @if ($trainings->isEmpty())

                <div class="flex flex-col items-center justify-center mt-20 mb-20">
                    <div class="flex p-1 bg-blue-200 rounded-full">

                        <svg class="w-24 h-24 text-black" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                        </svg>

                    </div>

                    <div class="mt-5 text-xl font-semibold text-center text-black">
                        Training Record is empty.
                    </div>
                </div>
            @else
                {{-- <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 "> --}}
                @foreach ($trainings as $trainings)
                    <div wire:key="{{ $trainings->training_id }}" class="container p-3">

                        <div class="flex flex-row items-center h-full">

                            <div class="flex flex-col">
                                <svg class="w-10 h-10 text-gray-800 lg:w-20 lg:h-20" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="m10.076 8.64-2.201-2.2V4.874a.75.75 0 0 0-.364-.643l-3.75-2.25a.75.75 0 0 0-.916.113l-.75.75a.75.75 0 0 0-.113.916l2.25 3.75a.75.75 0 0 0 .643.364h1.564l2.062 2.062 1.575-1.297Z" />
                                    <path fill-rule="evenodd"
                                        d="m12.556 17.329 4.183 4.182a3.375 3.375 0 0 0 4.773-4.773l-3.306-3.305a6.803 6.803 0 0 1-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 0 0-.167.063l-3.086 3.748Zm3.414-1.36a.75.75 0 0 1 1.06 0l1.875 1.876a.75.75 0 1 1-1.06 1.06L15.97 17.03a.75.75 0 0 1 0-1.06Z"
                                        clip-rule="evenodd" />
                                </svg>

                            </div>

                            <div class="flex flex-col w-full ml-4">
                                <span
                                    class="text-3xl font-black text-black uppercase">{{ $trainings->training_Name }}</span>
                                <span class="text-xl font-semibold text-black uppercase">{{ $trainings->training_Cert }}
                                </span>
                                <span
                                    class="font-medium text-gray-700 uppercase text-md">{{ $trainings->training_From }}</span>
                                <span class="font-medium text-gray-700 uppercase text-md">
                                    {{ $trainings->training_Start->format('F Y') }} -
                                    @if ($trainings->training_End)
                                        {{ $trainings->training_End->format('F Y') }}
                                    @else
                                        Present
                                    @endif
                                </span>
                            </div>

                            <div class="flex flex-row items-center justify-center h-full gap-2">
                                <div x-data="{ tooltip: 'Remove Training Record' }">
                                    <div x-tooltip="tooltip"
                                        wire:click.prevent='deleteData({{ $trainings->training_id }})'
                                        class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-red-300">
                                        <svg class="w-10 h-10 text-red-700" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>


                                    </div>
                                </div>
                                <div x-tooltip="tooltip" x-data="{ tooltip: 'Add Training Record' }">
                                    <div wire:click.prevent='editModal({{ $trainings->training_id }})'
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


    {{-- TRAINING MODAL --}}
    <x-modal name="training-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Training Record') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">

                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="trainingName" :value="__('Training Name')" />
                    <x-text-input wire:model="trainName" id="trainingName" class="block w-full mt-1" type="text" />
                    <x-input-error :messages="$errors->get('trainName')" class="mt-2" />
                </div>
                <div class="flex flex-row w-full mt-2">
                    <div class="flex flex-col w-full">
                        <x-input-label for="trainingStart" :value="__('Started')" />
                        <x-text-input wire:model="trainStart" id="trainingStart" class="block w-full mt-1"
                            type="date" />
                        <x-input-error :messages="$errors->get('trainStart')" class="mt-2" />
                    </div>
                    <div class="flex flex-col w-full ml-4">
                        <x-input-label for="trainingEnd" :value="__('Ended')" />
                        <x-text-input wire:model="trainEnd" id="trainingEnd" class="block w-full mt-1"
                            type="date" />
                        <x-input-error :messages="$errors->get('trainEnd')" class="mt-2" />
                    </div>
                </div>
                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="trainingInsti" :value="__('Training Institution')" />
                    <x-text-input wire:model="trainInstitution" id="trainingInsti" class="block w-full mt-1"
                        type="text" />
                    <x-input-error :messages="$errors->get('trainInstitution')" class="mt-2" />
                </div>

                <div class="flex flex-col w-full mt-2">
                    <x-input-label for="trainingCert" :value="__('Certificate Recieved')" />
                    <x-text-input wire:model="trainCert" id="trainingCert" class="block w-full mt-1"
                        type="text" />
                    <x-input-error :messages="$errors->get('trainCert')" class="mt-2" />
                </div>
                <div class="mt-2">
                    <x-input-label for="trainingComplete" :value="__('Completed')" />
                    <div class="flex items-center">
                        <label for="completeCheckBoxYes" class="mr-2">
                            <input wire:model="trainStat" id="completeCheckBoxYes" type="radio"
                                name="completeCheckBox" value="1" autocomplete="off">
                            <span class="ml-1">{{ __('Yes') }}</span>
                        </label>
                        <label for="completeCheckBoxNo" class="ml-4 mr-2">
                            <input wire:model="trainStat" id="completeCheckBoxNo" type="radio"
                                name="completeCheckBox" value="2" autocomplete="off">
                            <span class="ml-1">{{ __('No') }}</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('trainStat')" class="mt-2" />
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button wire:click.prevent='close' type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button wire:click.prevent='save' class="ms-3" type="button" id="trainingAdd">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    <x-modal name="delete-training-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center my-12">

                <h1 class="text-2xl font-bold">Are you sure you want to delete this training record?</h1>


            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-training-modal')">
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
