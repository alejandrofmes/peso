<div wire:poll class="container mx-auto py-8">
    <div class="grid grid-cols-4 lg:grid-cols-12 gap-4 p-3 lg:p-0">

        {{-- TITLE --}}
        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Role Management \ PESO Overview</h1>
        </div>

        <div class="col-span-4 lg:col-span-12 mt-5">

            <div class="flex flex-row">

                <div class="flex flex-col">
                    <h1 class="text-xl font-medium">PESO ID: {{ $user->peso_accounts_id }}</h1>
                    <h1 class="text-md font-light text-gray-500">{{ $user->created_at->format('F j, Y, g:i A') }}
                    </h1>
                </div>

                {{-- DEACTIVATE BUTTON --}}
                <div class="flex flex-col ml-auto mr-0">
                    @if ($user->user->userstatus == 1)
                        <button type="button" x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'deactivate-modal')"
                            class="bg-red-500 text-white font-semibold rounded-lg text-md px-4 py-2 transition duration-300 ease-in-out transform hover:bg-red-600 hover:scale-105 focus:ring-4 focus:ring-red-300 focus:outline-none">
                            Deactivate Account
                        </button>
                    @elseif($user->user->userstatus == 2)
                        <button type="button" x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'reactivate-modal')"
                            class="bg-green-500 text-white font-semibold rounded-lg text-md px-4 py-2 transition duration-300 ease-in-out transform hover:bg-green-600 hover:scale-105 focus:ring-4 focus:ring-green-300 focus:outline-none">
                            Reactivate Account
                        </button>
                    @endif
                </div>

            </div>

        </div>

        {{-- PROFILE CONTAINER --}}
        <div class="col-span-4 lg:col-span-4">
            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex flex-col items-center">
                    {{-- IMAGE --}}
                    {{-- <img src="{{ asset('storage/' . $employer->company_img) }}"
                        class="w-32 h-32 bg-gray-300 rounded-md mb-4 shrink-0 grow-0 object-cover">

                    </img> --}}

                    <h1 class="text-xl font-bold uppercase"> {{ $user->peso_accounts_Fname }}
                        {{ $user->peso_accounts_Mname }}
                        {{ $user->peso_Lname }}
                    </h1>
                    <p class="text-gray-700">#{{ $user->peso_accounts_id }}</p>
                </div>

                <hr class="my-6 border-t border-gray-300">

                <div class="flex flex-col">

                    <span class="text-gray-700 uppercase font-black tracking-wider mb-2 text-xl">Contact Details</span>

                    <ul>
                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Email:</li>
                            <p class="ms-4 text-right">{{ $user->user->email }}</p>
                        </div>


                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Phone Number:</li>
                            <p class="ms-4 text-right">{{ $user->peso_accounts_Pnumber }}</p>
                        </div>




                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">Position:</li>
                            <p class="ms-4 text-right">{{ $user->user->usertype }}</p>
                        </div>

                        <div class="flex flex-row justify-between">
                            <li class="mb-2 font-bold">PESO Municipality:</li>
                            <p class="ms-4 uppercase text-right"> {{ $user->peso->municipality->municipality_Name }}</p>
                        </div>

                    </ul>

                </div>

            </div>
        </div>

        {{-- CONTAINER FOR TABS --}}
        <div class="col-span-4 lg:col-span-8 row" x-data="{
            selectedTab: 1,
            activeTab: 'text-white  bg-blue-700 active',
            inactiveTab: 'hover:text-white-300 bg-gray-300 hover:bg-gray-400',
            activeIcon: 'text-white',
            inactiveIcon: 'text-gray-500'
        }">

            {{-- TAB BUTTON --}}
            <ul class="flex flex-row space-x space-x-4 text-sm font-medium text-gray-500 md:me-4 mb-4 md:mb-2">
                <li>
                    <button @click="selectedTab = 1" :class="selectedTab === 1 ? activeTab : inactiveTab"
                        class="inline-flex items-center px-4 py-3 rounded-lg w-full" aria-current="page">

                        <svg :class="selectedTab === 1 ? activeIcon : inactiveIcon" class="w-4 h-4 me-2"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M15.988 3.012A2.25 2.25 0 0 1 18 5.25v6.5A2.25 2.25 0 0 1 15.75 14H13.5V7A2.5 2.5 0 0 0 11 4.5H8.128a2.252 2.252 0 0 1 1.884-1.488A2.25 2.25 0 0 1 12.25 1h1.5a2.25 2.25 0 0 1 2.238 2.012ZM11.5 3.25a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 .75.75v.25h-3v-.25Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M2 7a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7Zm2 3.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Zm0 3.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z"
                                clip-rule="evenodd" />
                        </svg>

                        Audits
                    </button>
                </li>

                <li>
                    <button @click="selectedTab = 2" :class="selectedTab === 2 ? activeTab : inactiveTab"
                        class="inline-flex items-center px-4 py-3 rounded-lg w-full">
                        <svg :class="selectedTab === 2 ? activeIcon : inactiveIcon" class="w-4 h-4 me-2"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z"
                                clip-rule="evenodd" />
                        </svg>

                        Security
                    </button>
                </li>
            </ul>

            {{-- 2ND TAB --}}
            <div x-show="selectedTab === 1" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-cloak>




                {{-- APPLICATION HISTORY CONTAINER --}}

                <div class="bg-white shadow rounded-lg p-6 h-full w-full overflow-auto">
                    <div class="mb-5">
                        <h1 class="text-2xl font-bold">Audit Logs</h1>
                        <hr class="h-px my-2 bg-gray-200 border-0">
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 mt-2">
                            <thead class="text-xs text-gray-700 uppercase bg-blue-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 ">
                                        <span class="text-black font-bold text-md">Model</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="text-black font-bold text-md">User</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="text-black font-bold text-md">Date</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($formattedAudits->isEmpty())
                                    <tr>
                                        <td colspan="5">
                                            <div class="flex flex-col items-center justify-center mt-24 mb-24">
                                                <div class="p-6 bg-gray-100 rounded-full">
                                                    <svg class="w-24 h-24 text-black" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-width="2"
                                                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                                    </svg>
                                                </div>
                                                <p class="text-xl font-bold text-black text-center mt-2">
                                                    No audit logs available!
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($formattedAudits as $audit)
                                        <tr wire:key='audit-{{ $loop->index }}'
                                            class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <ul class="list-disc pl-5">
                                                    @foreach ($audit['changes'] as $index => $change)
                                                        @if ($index == 0)
                                                            <b>{{ $change }}</b>
                                                        @else
                                                            <li>{{ $change }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $audit['changed_by'] }} (ID: {{ $audit['user_id'] }}, Type:
                                                {{ $audit['user_type'] }})<br>
                                                {{ $audit['ipaddress'] }}
                                            </td>
                                            <td class="px-6 py-4">

                                                {{ $audit['date'] }}
                                            </td>
                                        </tr>
                                    @endforeach

                                @endif
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $audits->links('vendor.livewire.tailwind') }}
                        </div>

                    </div>
                </div>




            </div>
            <div x-show="selectedTab === 2" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-cloak>

                <div class="bg-white shadow rounded-lg p-6 mt-4">

                    <h1 class="text-2xl font-bold ">Details</h1>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                    <div class="flex flex-col lg:flex-row gap-2 lg:gap-4 mt-4 w-full">
                        <div class="flex flex-col w-full">
                            <x-input-label for="fname" :value="__('First Name')" />
                            <x-text-input wire:model="fname" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('fname')" class="mt-2" />

                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="mname" :value="__('Middle Name')" />
                            <x-text-input wire:model="mname" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('mname')" class="mt-2" />
                        </div>
                        <div class="flex flex-col w-full">
                            <x-input-label for="lname" :value="__('Last Name')" />
                            <x-text-input wire:model="lname" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('lname')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-2 lg:gap-4 mt-4 w-full">
                        <div class="flex flex-col w-full">
                            <x-input-label for="phone" :value="__('Phone Number')" />
                            <x-text-input wire:model="phone" class="block mt-1 w-full" type="tel" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div class="flex flex-col w-full">
                            <x-input-label for="role" :value="__('PESO Role')" />
                            <select wire:model="role" class="block mt-1 w-full rounded-md">
                                <option value="" disabled selected>Select Location Type</option>
                                {{-- <option value="8">PESO Consultant</option> --}}
                                <option value="9">PESO Officer</option>

                                <option value="10">PESO Manager</option>

                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                    </div>

                    <div class="flex w-full justify-end mt-4">
                        <x-blue-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-modal')">Save Profile</x-blue-button>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6 mt-4">
                    <h1 class="text-2xl font-bold ">Reset Password</h1>
                    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                    <div class="bg-yellow-100 shadow rounded-lg p-6 mt-4 mb-5">
                        <p class="text-yellow-700 font-semibold">Admin side password reset</p>
                        <p class="text-yellow-700 font-normal">New password will be sent through the user's email</p>
                    </div>

                    <x-blue-button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'reset-password-modal')">Reset
                        Password</x-blue-button>
                </div>

            </div>






        </div>
    </div>



    <x-modal name="confirm-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col my-4">
                <div class="flex flex-col mt-4 mb-4 w-full justify-center items-center px-4">
                    <span class="text-xl font-semibold">Are you sure you want to update this account's
                        details?</span>

                </div>
            </div>
            <div class="mt-6 flex justify-between">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled" wire:target='saveDetails'
                    wire:click.prevent="saveDetails" class="ms-3" type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="saveDetails" role="status">
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


    <x-modal name="reset-password-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center" x-data="{ agreeBox: @entangle('agreeBox') }">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Action Confirmation') }}
            </h2>
            <hr>
            <div class="flex flex-col my-4">
                <div class="flex flex-col mt-4 mb-4 w-full justify-center items-center px-4">
                    <span class="text-xl font-semibold">Are you sure you want to reset this user's password?</span>

                </div>


                <div class="inline-flex justify-center items-center mt-4 w-full">
                    <label class="relative flex items-center p-3 rounded-full cursor-pointer" for="agreeBox">
                        <input wire:model="agreeBox" type="checkbox" id="agreeBox"
                            class="h-5 w-5 cursor-pointer appearance-none rounded-md border border-blue-gray-200 transition-all checked:border-blue-900 checked:bg-blue-600" />
                        <span
                            class="absolute text-white top-2/4 left-2/4 transform -translate-x-2/4 -translate-y-2/4 opacity-0 peer-checked:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                fill="currentColor" stroke="currentColor" stroke-width="1">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </label>
                    <label class="mt-px font-light text-gray-700 cursor-pointer select-none" for="agreeBox">
                        Confirm the transaction
                    </label>
                </div>
            </div>
            <div class="mt-6 flex justify-between">
                <x-secondary-button x-on:click="agreeBox = false; $dispatch('close-modal', 'reset-password-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>



                <x-danger-button x-bind:disabled="!agreeBox" wire:loading.attr="disabled" wire:target='resetPassword'
                    wire:click.prevent="resetPassword" class="ms-3" type="button">
                    {{ __('Confirm') }}
                    <div wire:loading.delay.long wire:target="resetPassword" role="status">
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

    <x-modal name="reactivate-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center border-b">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to reactivate this account?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">

                <div class="flex flex-col mt-2 w-full">
                    <x-input-label for="remarks" :value="__('Remarks')" />
                    <textarea wire:model='reactRemarks' rows="6"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                        placeholder="Write your thoughts here..."></textarea>
                    <x-input-error :messages="$errors->get('reactRemarks')" class="mt-2" />
                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click.prevent="closeModal('reactivate')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-green-button wire:loading.attr="disabled" wire:click.prevent="statusUser(1)" class="ms-3"
                    type="button">
                    {{ __('Activate') }}
                    <div wire:loading.delay.long wire:target="statusUser(1)" role="status">
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

    <x-modal name="deactivate-modal" focusable>
        <div class="w-full max-w-4xl px-6 py-6 items-center border-b">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to deactivate this account?') }}
            </h2>
            <hr>
            <div class="flex flex-col mt-2">

                <div class="flex flex-col mt-2 w-full">
                    <x-input-label for="remarks" :value="__('Remarks')" />
                    <textarea wire:model='deactRemarks' rows="6"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                        placeholder="Write your thoughts here..."></textarea>
                    <x-input-error :messages="$errors->get('deactRemarks')" class="mt-2" />
                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click.prevent="closeModal('deactivate')" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:loading.attr="disabled" wire:click.prevent="statusUser(2)" class="ms-3"
                    type="button">
                    {{ __('Deactivate') }}
                    <div wire:loading.delay.long wire:target="statusUser(2)" role="status">
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
