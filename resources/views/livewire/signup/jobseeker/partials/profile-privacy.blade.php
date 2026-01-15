<div class="flex flex-col my-4 gap-4 mt-4 w-full">
    <h1 class="text-2xl font-bold">Profile Privacy</h1>
    <div class="text-center mb-4">

        <p class="mt-2 text-gray-600 text-sm lg:text-md text-justify">
            The information you provide during profile creation will be used to craft a detailed profile showcasing your
            qualifications, skills, and preferences. This profile not only determines how you're visible on our platform
            but also serves as the foundation for an automatically generated resume. You have full control
            over the visibility of your profile and resume—whether it's accessible only to you, to verified employers,
            or to the general public. However, please note that PESO administrators will always retain access to your
            profile for administrative purposes. Choose the visibility option that aligns with your privacy needs and
            career goals.
        </p>


    </div>

    <!-- Privacy Options -->
    <div class="flex flex-col">
        <div class="flex flex-col gap-6 justify-center">

            <!-- Private Option -->
            <label for="bordered-radio-1"
                class="flex flex-row items-start p-4 border border-gray-400 rounded-lg bg-white shadow-sm hover:border-blue-500 focus:border-blue-500 transition-all duration-200 cursor-pointer">
                <input wire:model='privacy' id="bordered-radio-1" type="radio" value="1" name="bordered-radio"
                    class="w-5 h-5 mt-1 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                <div class="ml-3">
                    <span class="text-lg font-medium text-gray-800">Private</span>
                    <p class="text-xs lg:text-sm text-gray-600 mt-1">
                        Only you will be able to view your profile. Your information will be completely hidden from all
                        employers and the public.
                        This option provides the highest level of privacy for your personal details.
                    </p>
                </div>
            </label>

            <!-- Employers Option -->
            <label for="bordered-radio-2"
                class="flex flex-row items-start p-4 border border-gray-400 rounded-lg bg-white shadow-sm hover:border-blue-500 focus:border-blue-500 transition-all duration-200 cursor-pointer">
                <input wire:model='privacy' id="bordered-radio-2" type="radio" value="2" name="bordered-radio"
                    class="w-5 h-5 mt-1 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                <div class="ml-3">
                    <span class="text-lg font-medium text-gray-800">Employers</span>
                    <p class="text-xs lg:text-sm text-gray-600 mt-1">
                        Your profile will be visible only to verified employers. This option allows potential employers
                        to view your qualifications
                        and reach out to you for opportunities, while keeping your profile hidden from the general
                        public.
                    </p>
                </div>
            </label>

            <!-- Public Option -->
            <label for="bordered-radio-3"
                class="flex flex-row items-start p-4 border border-gray-400 rounded-lg bg-white shadow-sm hover:border-blue-500 focus:border-blue-500 transition-all duration-200 cursor-pointer">
                <input wire:model='privacy' id="bordered-radio-3" type="radio" value="3" name="bordered-radio"
                    class="w-5 h-5 mt-1 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                <div class="ml-3">
                    <span class="text-lg font-medium text-gray-800">Public</span>
                    <p class="text-xs lg:text-sm text-gray-600 mt-1">
                        Your profile will be publicly available to everyone. This option maximizes visibility, allowing
                        both employers and
                        the general public to access your information. Choose this if you want to reach the widest
                        audience.
                    </p>
                </div>
            </label>
        </div>

        <!-- Error Message -->
        <x-input-error :messages="$errors->get('privacy')" class="mt-4" />
    </div>

    <!-- Error Message -->
    <div class="flex flex-row justify-between space-x-4 mt-4">
        <x-secondary-button wire:loading.attr='disabled' wire:click.prevent='prev' type="button">
            Previous
            <div wire:loading.delay.long wire:target="prev" role="status">
                <svg aria-hidden="true" class="w-6 h-6 text-gray-200 animate-spin fill-blue-600 ml-4"
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
                <svg aria-hidden="true" class="w-6 h-6 text-gray-200 animate-spin fill-blue-600 ml-4"
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
