<div class="w-full h-full">
    <div class="w-full h-full">
        <!-- Livewire Component -->
        <div x-data="employmentStatusHandler()" @change-status.window="updateEmpDesc" class="flex flex-col w-full h-full">
            <h1 class="text-2xl font-bold">Employment Status</h1>
            <span class="text-sm text-gray-600">Fields with * are required.</span>
            <div class="flex flex-col gap-4 mt-5 lg:flex-row">
                <div class="flex flex-col w-full">
                    <x-input-label for="empStatus" :value="__('Employment Status*')" />
                    <select wire:model='empStatus' x-model="empStatus" @change="updateEmpDesc"
                        class="block w-full mt-1 rounded">
                        <option value="" disabled selected>Select Employment Status</option>
                        <option value="1">Employed</option>
                        <option value="2">Unemployed</option>
                    </select>
                    <x-input-error :messages="$errors->get('empStatus')" class="mt-2" />
                    </h1>
                </div>
                <div class="flex flex-col w-full">
                    <x-input-label for="empDesc" :value="__('Description*')" />
                    <select wire:model='empDescription' x-model="empDesc" class="block w-full mt-1 rounded">
                        <option value="" disabled selected>Select Description</option>
                        <template x-for="desc in empDescriptions" :key="desc.value">
                            <option :value="desc.value" x-text="desc.text"></option>
                        </template>
                    </select>
                    <x-input-error :messages="$errors->get('empDescription')" class="mt-2" />
                    </h1>
                </div>
            </div>
            <div class="flex flex-row justify-between mt-4 space-x-4 lg:mt-auto lg:mb-4">
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

        </div>

    </div>

    <script>
        function employmentStatusHandler() {
            return {
                empStatus: '',
                empDesc: '',
                empDescriptions: [],

                updateEmpDesc() {
                    this.empDesc = ''; // Reset the empDesc value
                    this.empDescriptions = [];
                    if (this.empStatus === '1') { // '1' corresponds to 'employed'
                        this.empDescriptions = [{
                                text: 'Wage employed',
                                value: 1
                            },
                            {
                                text: 'Self-employed',
                                value: 2
                            },
                            {
                                text: 'Others',
                                value: 3
                            }
                        ];
                    } else if (this.empStatus === '2') { // '2' corresponds to 'unemployed'
                        this.empDescriptions = [{
                                text: 'New entrant/fresh graduate',
                                value: 4
                            },
                            {
                                text: 'Finished contract',
                                value: 5
                            },
                            {
                                text: 'Resigned',
                                value: 6
                            },
                            {
                                text: 'Retired',
                                value: 7
                            },
                            {
                                text: 'Terminated/Laid off due to calamity',
                                value: 8
                            },
                            {
                                text: 'Terminated/Laid off (local)',
                                value: 9
                            },
                            {
                                text: 'Terminated/Laid off (abroad)',
                                value: 10
                            },
                            {
                                text: 'Others',
                                value: 3
                            }
                        ];
                    }
                }
            }
        }
    </script>


</div>
