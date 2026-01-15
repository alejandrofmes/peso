<div class="container mx-auto py-8">

    {{-- GRID --}}
    <div class="grid grid-cols-4 lg:grid-cols-12 gap-4 p-3 lg:p-0">

        {{-- TITLE --}}
        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Announcements / Create an Announcement</h1>
        </div>





        <div class="col-span-4 lg:col-span-4">

            <div class="bg-white shadow rounded-lg p-6 w-full">
                <div class="flex flex-col items-center mt-4 w-full h-full">
                    <x-input-label class="" for="fname" :value="__('Announcement Image')" />
                    <div class="flex flex-col items-center mt-4">
                        <div
                            class="lg:w-[400px] lg:h-[500px] bg-gray-200 border border-gray-300 rounded-lg overflow-hidden flex items-center justify-center shrink-0">

                            <img id="uploadedImage"
                                class="flex w-full-h-full uploaded-image object-cover shrink-0 grow-0"
                                src="{{ isset($announcementImage) && $announcementImage->temporaryUrl() ? $announcementImage->temporaryUrl() : asset('assets/img/PESO-Logo.png') }}"
                                alt="Uploaded Image" />



                        </div>
                    </div>


                    <x-input-error :messages="$errors->get('announcementImage')" class="mt-2" />
                    <div class="flex h-full justify-center items-center mt-4">
                        <label for="imageUpload" wire:loading.attr="disabled"
                            class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Upload Image
                            <div wire:loading.delay.long wire:target="progImg" role="status">
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
                        </label>
                        <input wire:model="announcementImage" type="file" id="imageUpload" class="hidden"
                            accept="image/*">
                    </div>
                </div>
            </div>

        </div>

        <div class="col-span-4 lg:col-span-8">
            <div class="bg-white shadow rounded-lg p-6 ">
                <div class="flex flex-col w-full h-full gap-4">

                    <div class="flex flex-col w-full">
                        <x-input-label for="title" :value="__('Announcement Title')" />
                        <x-text-input wire:model='title' class="block mt-1 w-full" type="text" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="flex flex-col ">
                        <x-input-label for="descText">Announcement Content
                        </x-input-label>
                        <div wire:ignore class="flex h-full w-full">
                            <textarea id="descText"></textarea>
                        </div>


                        @if ($errors->has('contentPost'))
                            <x-input-error :messages="$errors->get('contentPost')" class="mt-2" />
                        @endif
                    </div>


                    <div class="flex flex-row justify-end mt-4">
                        <x-green-button wire:loading.attr="disabled" wire:click.prevent='validateInput'
                            type="button"><span class="text-lg mx-4">Post</span></x-green-button>
                    </div>
                </div>

            </div>
        </div>










    </div>

    <x-modal name="confirm-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Posting Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col justify-center items-center my-12">

                <h1 class="text-2xl font-bold">Are you sure you want to post this announcement?</h1>

            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-green-button wire:loading.attr="disabled" wire:click.prevent="saveAnnouncement" class="ms-3"
                    type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="saveAnnouncement" role="status">
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

            // Initialize the description editor
            $('#descText').summernote({
                placeholder: 'Write training description here...',
                tabsize: 4,
                height: 600,
                disableResizeEditor: true, // Optional to remove resize
                disableDragAndDrop: true, // Prevent drag-and-drop for images
                toolbar: [
                    ['fontsize', ['fontsize', 'fontname']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                ],
                callbacks: {
                    onInit: function() {
                        // Set initial content from Livewire when the editor is initialized
                        $('#descText').summernote('code', @this.get('contentPost') || '');
                    },
                    onChange: function(contents) {
                        // Only update Livewire if the content has changed
                        if (contents !== @this.get('contentPost')) {
                            if (contents.replace(/\s/g, '').toLowerCase() === '<br>' ||
                                contents.replace(/\s/g, '').toLowerCase() === '<br/>' ||
                                contents.replace(/\s/g, '').toLowerCase() === '<br />') {
                                @this.set('contentPost', '');
                            } else {
                                @this.set('contentPost', contents);
                            }
                        }
                    }
                }
            });
        }
    </script>
@endpush
