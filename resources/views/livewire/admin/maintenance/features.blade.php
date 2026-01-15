<div class="container mx-auto py-8">
    <div class="grid grid-cols-4 lg:grid-cols-12 gap-4 p-3 lg:p-0">

        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Maintenance / Experimental Features</h1>
        </div>
        <div class="col-span-4 lg:col-span-12">
            <div class="p-4 lg:p-8 bg-white shadow-xl rounded-lg">
                <div class="w-full">
                    <div>

                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Cross Municipality Job Application') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Enable the Cross Municipality Job Application feature to allow job applicants to apply for job postings across different PESO offices. By enabling this option, applicants will have the flexibility to submit applications for job opportunities posted in municipalities other than their own.') }}
                            </p>
                        </header>
                        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                        <div class="mt-3">

                            <div x-data="{ isChecked: @entangle('crossJob') }">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input wire:click.prevent='validateAction(1)' wire:model='crossJob'
                                        x-model="isChecked" type="checkbox" class="sr-only peer">
                                    <div
                                        class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        <span x-text="isChecked ? 'Enabled' : 'Disabled'"></span>
                                    </span>
                                </label>
                            </div>


                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="col-span-4 lg:col-span-12">
            <div class="p-4 lg:p-8 bg-white shadow-xl rounded-lg">
                <div class="w-full">
                    <div>

                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Cross Municipality Program/Training Registration') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Enable the Cross Municipality Program/Training Registration feature to allow participants to register for programs and training opportunities across different PESO offices. By enabling this option, participants will have the flexibility to enroll in programs offered in municipalities other than their own.') }}
                            </p>

                        </header>
                        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                        <div class="mt-3">

                            <div x-data="{ isChecked: @entangle('crossProgram') }">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input wire:click.prevent='validateAction(2)' wire:model='crossProgram'
                                        x-model="isChecked" type="checkbox" class="sr-only peer">
                                    <div
                                        class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        <span x-text="isChecked ? 'Enabled' : 'Disabled'"></span>
                                    </span>
                                </label>
                            </div>


                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <x-modal name="crossjob-enable" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to enable the cross-municipality job application setting?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-6">
                <h1 class="text-md font-medium">
                    {{ __('Please note that changing this setting will allow applicants to apply for job postings across different municipalities. Ensure that you have reviewed the implications of this change and that it aligns with your administrative policies.') }}
                </h1>

                <div class="mt-4">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                    <x-text-input wire:model="password" name="password" type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Password') }}" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click.prevent="closeModal('crossjob-enable')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-green-button wire:loading.attr="disabled"
                    wire:click.prevent="confirmResponse(1, 'enabled', 'crossjob-enable')" class="ms-3" type="button">
                    {{ __('Enable') }}
                    <div wire:loading.delay.long wire:target="confirmResponse(1, 'enabled', 'crossjob-enable')"
                        role="status">
                        <svg aria-hidden="true" class="w-4 h-4 text-gray-200 animate-spin fill-blue-600 ml-4"
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
    <x-modal name="crossjob-disable" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to disable the cross-municipality job application setting?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-6">
                <h1 class="text-md font-medium">
                    {{ __('Please note that disabling this setting will prevent applicants from applying for job postings across different municipalities. Ensure that you have reviewed the implications of this change and that it aligns with your administrative policies.') }}
                </h1>

                <div class="mt-4">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                    <x-text-input wire:model="password" name="password" type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Password') }}" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click.prevent="closeModal('crossjob-disable')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled"
                    wire:click.prevent="confirmResponse(1, 'disabled', 'crossjob-disable')" class="ms-3"
                    type="button">
                    {{ __('Disable') }}
                    <div wire:loading.delay.long wire:target="confirmResponse(1, 'disabled', 'crossjob-disable')"
                        role="status">
                        <svg aria-hidden="true" class="w-4 h-4 text-gray-200 animate-spin fill-blue-600 ml-4"
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



    <x-modal name="crossprogram-enable" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to enable the cross-municipality program/training registration setting?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-6">
                <h1 class="text-md font-medium">
                    {{ __('Please note that enabling this setting will allow participants to register for programs and training opportunities across different municipalities. Ensure that you have reviewed the implications of this change and that it aligns with your administrative policies.') }}
                </h1>

                <div class="mt-4">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                    <x-text-input wire:model="password" name="password" type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Password') }}" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click.prevent="closeModal('crossprogram-enable')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-green-button wire:loading.attr="disabled"
                    wire:click.prevent="confirmResponse(2, 'enabled', 'crossprogram-enable')" class="ms-3"
                    type="button">
                    {{ __('Enable') }}
                    <div wire:loading.delay.long wire:target="confirmResponse(2, 'enabled', 'crossprogram-enable')"
                        role="status">
                        <svg aria-hidden="true" class="w-4 h-4 text-gray-200 animate-spin fill-blue-600 ml-4"
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
    <x-modal name="crossprogram-disable" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to disable the cross-municipality program/training registration setting?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-6">
                <h1 class="text-md font-medium">
                    {{ __('Please note that disabling this setting will prevent participants from registering for programs and training opportunities across different municipalities. Ensure that you have reviewed the implications of this change and that it aligns with your administrative policies.') }}
                </h1>

                <div class="mt-4">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                    <x-text-input wire:model="password" name="password" type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Password') }}" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click.prevent="closeModal('crossprogram-disable')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled"
                    wire:click.prevent="confirmResponse(2, 'disabled', 'crossprogram-disable')" class="ms-3"
                    type="button">
                    {{ __('Disable') }}
                    <div wire:loading.delay.long wire:target="confirmResponse(2, 'disabled', 'crossprogram-disable')"
                        role="status">
                        <svg aria-hidden="true" class="w-4 h-4 text-gray-200 animate-spin fill-blue-600 ml-4"
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
