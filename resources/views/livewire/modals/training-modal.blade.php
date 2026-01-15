<x-modal name="training-modal" focusable>
    <div class="items-center w-full max-w-4xl px-6 py-6">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Training Record') }}
        </h2>
        <hr>
        <div class="flex flex-col mt-2">

            <div class="flex flex-col w-full mt-2">
                <x-input-label for="trainingName" :value="__('Training Name*')" />
                <x-text-input wire:model="trainName" class="block w-full mt-1" type="text" />
                <x-input-error :messages="$errors->get('trainName')" class="mt-2" />
            </div>
            <div class="flex flex-row w-full mt-2">
                <div class="flex flex-col w-full">
                    <x-input-label for="trainingStart" :value="__('Started*')" />
                    <x-text-input wire:model="trainStart" class="block w-full mt-1" type="date" />
                    <x-input-error :messages="$errors->get('trainStart')" class="mt-2" />
                </div>
                <div class="flex flex-col w-full ml-4">
                    <x-input-label for="trainingEnd" :value="__('Ended')" />
                    <x-text-input wire:model="trainEnd" class="block w-full mt-1" type="date" />
                    <x-input-error :messages="$errors->get('trainEnd')" class="mt-2" />
                </div>
            </div>
            <div class="flex flex-col w-full mt-2">
                <x-input-label for="trainingInsti" :value="__('Training Institution*')" />
                <x-text-input wire:model="trainInstitution" class="block w-full mt-1" type="text" />
                <x-input-error :messages="$errors->get('trainInstitution')" class="mt-2" />
            </div>

            <div class="flex flex-col w-full mt-2">
                <x-input-label for="trainingCert" :value="__('Certificate Recieved*')" />
                <x-text-input wire:model="trainCert" class="block w-full mt-1" type="text" />
                <x-input-error :messages="$errors->get('trainCert')" class="mt-2" />
            </div>
            <div class="mt-2">
                <x-input-label for="trainingComplete" :value="__('Completed*')" />
                <div class="flex items-center">
                    <label for="completeCheckBoxYes" class="mr-2">
                        <input wire:model="trainStat" type="radio" name="completeCheckBox" value="1">
                        <span class="ml-1">{{ __('Yes') }}</span>
                    </label>
                    <label for="completeCheckBoxNo" class="ml-4 mr-2">
                        <input wire:model="trainStat" type="radio" name="completeCheckBox" value="2">
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

            <x-primary-button wire:loading.attr="disabled" wire:click.prevent='save' class="ms-3" type="button">
                {{ __('Save') }}
            </x-primary-button>
        </div>
    </div>
</x-modal>
