<div wire:poll.5s class="container mx-auto py-8">
    <div class="grid grid-cols-4 lg:grid-cols-12 gap-4 p-3 lg:p-0">

        <div class="col-span-4 lg:col-span-12">
            <h1 class="text-2xl font-bold">Maintenance / Audit Logs</h1>
        </div>

        <div class="col-span-4 lg:col-span-12">
            <div class="bg-white shadow rounded-lg p-6 overflow-visible" x-data="{
                openTab: '',
                activeClasses: 'text-gray-900 bg-gray-400 active',
                inactiveClasses: 'bg-gray-100 hover:text-gray-700 hover:bg-gray-50',
                changeFilter(value) {
                    this.openTab = value;
                    this.$wire.call('updateFilter', value); // Call Livewire method to update filter
                },
                ainit() {
                    this.$watch('openTab', value => {
                        this.changeFilter(value); // Ensure Livewire is updated when openTab changes
                    });
                }
            }" x-init="init()">

                <div class="relative overflow-x-auto p-1">
                    <!-- Mobile Dropdown -->
                    <div class="lg:hidden">
                        <label for="tabs" class="sr-only">Select your category</label>
                        <select id="tabs"
                            class="mb-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            x-model="openTab" @change="changeFilter($event.target.value)">
                            <option value="">All</option>
                            <option value="1">System</option>
                            <option value="2">Job Posting</option>
                            <option value="3">Job Applicants</option>
                            <option value="4">Trainings</option>
                            <option value="5">Training Registrants</option>
                            <option value="6">Announcements</option>
                            <option value="7">Jobseekers</option>

                        </select>
                    </div>

                    <!-- Desktop Tabs -->
                    <ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow lg:flex mb-3">
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('')"
                                :class="openTab === '' ? activeClasses : inactiveClasses"
                                class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none rounded-s-lg"
                                aria-current="page">All</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('1')"
                                :class="openTab === '1' ? activeClasses : inactiveClasses"
                                class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none">System</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('2')"
                                :class="openTab === '2' ? activeClasses : inactiveClasses"
                                class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none">Job
                                Posting</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('3')"
                                :class="openTab === '3' ? activeClasses : inactiveClasses"
                                class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none">Job
                                Applicants</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('4')"
                                :class="openTab === '4' ? activeClasses : inactiveClasses"
                                class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none">Trainings</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('5')"
                                :class="openTab === '5' ? activeClasses : inactiveClasses"
                                class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none">Training
                                Registrants</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('6')"
                                :class="openTab === '6' ? activeClasses : inactiveClasses"
                                class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none">Announcements</button>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <button @click="changeFilter('7')"
                                :class="openTab === '7' ? activeClasses : inactiveClasses"
                                class="inline-block w-full p-4 border-r border-gray-200 focus:ring-1 focus:ring-gray-300 focus:outline-none rounded-e-lg">Jobseekers</button>
                        </li>
                    </ul>


                    <div id="tooltip-top" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Tooltip on top
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    {{-- TABLE --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 ">
                                        Model
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        User
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Date
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
                    </div>
                </div>

                {{-- PAGINATION --}}
                <div class="mt-4">
                    {{ $audits->links('vendor.livewire.tailwind') }}
                </div>

            </div>



        </div>

    </div>
</div>
