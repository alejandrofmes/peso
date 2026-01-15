<div class="container py-8 mx-auto">

    {{-- GRID --}}
    <div class="grid grid-cols-4 gap-4 p-3 lg:grid-cols-12 lg:p-0">

        {{-- TITLE --}}
        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Trainings / Create a program</h1>
        </div>



        <div class="col-span-4 lg:col-span-6">

            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex flex-col w-full h-full">
                    <div class="flex flex-col w-full gap-2 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="progTitle" :value="__('Program Title')" />
                            <x-text-input wire:model='progTitle' class="block w-full mt-1" type="text" />
                            <x-input-error :messages="$errors->get('progTitle')" class="mt-2" />
                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="progHost" :value="__('Program Host')" />

                            <div class="relative" x-data="{ open: false }">
                                <x-text-input x-on:focus='open = true' x-on:blur='setTimeout(() => open = false, 100)'
                                    wire:model.live='progHost' class="block w-full mt-1" type="text" />

                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute z-50 mt-1 w-full rounded shadow-lg " x-ref="dropdownContent"
                                    style="display: none;">
                                    <div class="rounded ring-1 ring-black ring-opacity-5">
                                        <div class="max-h-[120px] bg-white overflow-y-auto rounded-lg">
                                            @foreach ($hostssssssssss as $host)
                                                <div wire:click.prevent="selectHost('{{ $host->name }}')"
                                                    class="cursor-pointer block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                    {{ $host->name }}
                                                </div>
                                            @endforeach


                                        </div>

                                    </div>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('progHost')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex flex-col w-full h-full">
                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="regDeadline" :value="__('Registration Deadline')" />
                            <x-text-input wire:model='regDeadline' class="block w-full mt-1" type="date" />
                            <x-input-error :messages="$errors->get('regDeadline')" class="mt-2" />
                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="progSlots" :value="__('Program Slots')" />
                            <x-text-input wire:model='progSlots' class="block w-full mt-1" type="number" />
                            <x-input-error :messages="$errors->get('progSlots')" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="flex flex-col w-full h-full" x-data="{
                    progType: @entangle('progType'),
                    progDate: @entangle('progDate'),
                    progTime: @entangle('progTime'),
                    updateFields() {
                        if (this.progType === 'TESDA Scholarship') {
                            this.progDate = ''; // Clear the program date
                            this.progTime = ''; // Clear the program time
                        }
                    }
                }">
                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="progType" :value="__('Program Type')" />
                            <select name="progType" wire:model="progType" class="block w-full mt-1 rounded-md"
                                x-on:change="updateFields()">
                                <option value="" disabled selected>Select Program Type</option>
                                <option value="PESO Hosted">PESO Hosted</option>
                                <option value="TESDA Scholarship">TESDA Scholarship</option>
                            </select>
                            <x-input-error :messages="$errors->get('progType')" class="mt-2" />
                        </div>
                        <div class="flex flex-col w-full gap-2 lg:flex-row lg:gap-4">
                            <div class="flex flex-col w-full">
                                <x-input-label for="progDate" :value="__('Program Date')" />
                                <x-text-input wire:model="progDate" class="block w-full mt-1" type="date"
                                    x-bind:disabled="progType !== 'PESO Hosted'" />
                                <x-input-error :messages="$errors->get('progDate')" class="mt-2" />
                            </div>
                            <div class="flex flex-col w-full">
                                <x-input-label for="progTime" :value="__('Program Time')" />
                                <x-text-input wire:model="progTime" class="block w-full mt-1" type="time"
                                    x-bind:disabled="progType !== 'PESO Hosted'" />
                                <x-input-error :messages="$errors->get('progTime')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col w-full h-full">
                    <div class="flex flex-col w-full gap-2 mt-4 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="progLoc" :value="__('Program Location')" />
                            <x-text-input wire:model='progLoc' class="block w-full mt-1" type="text" />
                            <x-input-error :messages="$errors->get('progLoc')" class="mt-2" />
                        </div>
                        <div class="flex flex-col w-full lg:w-1/3">
                            <x-input-label for="progModality" :value="__('Modality Type')" />
                            <select wire:model='progModality' name="progModality" class="block w-full mt-1 rounded-md">
                                <option value="" disabled selected>Select Modality Type</option>
                                <option value="Face to Face">Face to Face</option>
                                <option value="Online">Online</option>
                                <option value="F2F / Online">F2F / Online</option>
                            </select>
                            <x-input-error :messages="$errors->get('progModality')" class="mt-2" />

                        </div>
                    </div>

                </div>


            </div>






            <div class="p-6 mt-4 bg-white rounded-lg shadow">
                <div class="flex flex-col w-full h-full">
                    <div class="flex flex-col w-full gap-2 lg:flex-row lg:gap-4">
                        <div class="flex flex-col w-full">
                            <x-input-label for="industry_tag" :value="__('Industry Tag')" />
                            <x-text-input wire:model='jobIndustryPost' class="block w-full mt-1" type="text"
                                readonly x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'industry-modal')"
                                x-on:focus="$dispatch('open-modal', 'industry-modal')" />
                            <x-input-error :messages="$errors->get('jobIndustryPost')" class="mt-2" />
                        </div>

                    </div>
                    <div class="flex flex-row w-full gap-4 my-4">
                        <div class="flex flex-col w-full">

                            <div class="flex flex-row items-center w-full">

                                <x-input-label for="job_tags">Job Position
                                    Tags
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
                                        <button wire:click.prevent='removeTag( {{ $jobData['position_id'] }})'
                                            type="button"
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


        </div>

        <div class="col-span-4 lg:col-span-6">

            <div class="w-full h-full p-6 bg-white rounded-lg shadow">
                <div class="flex flex-col items-center w-full h-full mt-4">
                    <x-input-label class="" for="fname" :value="__('Program Image')" />
                    <div class="flex flex-col items-center mt-4">
                        <div
                            class="w-[400px] h-[400px] bg-gray-200 border border-gray-300 rounded-lg overflow-hidden flex items-center justify-center shrink-0">

                            <img id="uploadedImage"
                                class="flex object-cover w-full-h-full uploaded-image shrink-0 grow-0"
                                src="{{ isset($progImg) && $progImg->temporaryUrl() ? $progImg->temporaryUrl() : asset('assets/img/PESO-Logo.png') }}"
                                alt="Uploaded Image" />



                        </div>
                    </div>


                    <x-input-error :messages="$errors->get('progImg')" class="mt-2" />
                    <div class="flex items-center justify-center h-full">
                        <label for="imageUpload" wire:loading.attr="disabled"
                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md cursor-pointer hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Upload Image
                            <div wire:loading.delay.long wire:target="progImg" role="status">
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
                        </label>
                        <input wire:model="progImg" type="file" id="imageUpload" class="hidden"
                            accept="image/*">
                    </div>
                </div>
            </div>

        </div>

        <div class="col-span-4 lg:col-span-12">
            <div class="p-6 bg-white rounded-lg shadow">

                <div class="flex flex-col w-full gap-2 lg:flex-row lg:gap-4 ">

                    <div class="flex flex-col w-full lg:w-1/2">
                        <x-input-label for="descPost">Program Description
                        </x-input-label>
                        <div wire:ignore>
                            <textarea id="descText"></textarea>
                        </div>

                        @if ($errors->has('descPost'))
                            <x-input-error :messages="$errors->get('descPost')" class="mt-2" />
                        @endif
                    </div>

                    <div class="flex flex-col w-full lg:w-1/2">
                        <x-input-label for="qualPost">Program Qualification
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
                    <x-input-label for="remPost">Program Remarks
                    </x-input-label>
                    <div wire:ignore>
                        <textarea id="remText"></textarea>
                    </div>
                    @if ($errors->has('remPost'))
                        <x-input-error :messages="$errors->get('remPost')" class="mt-2" />
                    @endif
                </div>

                <div class="flex flex-row justify-end mt-4 mb-2 ">
                    <x-green-button wire:loading.attr="disabled" wire:click.prevent='validateInput'
                        type="button"><span class="mx-4 text-lg">Post</span></x-green-button>
                </div>


            </div>
        </div>










    </div>

    <x-modal name="confirm-modal" focusable>
        <div class="items-center w-full max-w-4xl px-6 py-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Posting Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col items-center justify-center my-12">

                <h1 class="text-2xl font-bold">Are you sure you want to create this training?</h1>

            </div>
            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-green-button wire:loading.attr="disabled" wire:click.prevent="saveProgram" class="ms-3"
                    type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="saveProgram" role="status">
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


    <livewire:modals.job-position-modal />
    <livewire:modals.industry-modal />

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
                height: 120,
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
                height: 120,
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
                height: 120,
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
