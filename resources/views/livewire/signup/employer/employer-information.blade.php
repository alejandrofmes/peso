<div>
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-9xl mx-auto px-4 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('welcome') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        </a>
                    </div>
                    <div class="hidden space-x-8 lg:-my-px lg:ms-10 lg:flex">

                        @if (auth()->user()->usertype == 3)
                            <x-nav-link wire:navigate :href="route('fill_employer')" :active="request()->routeIs('fill_employer')">
                                {{ __('Complete Details') }}
                            </x-nav-link>
                        @endif
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-nav-link>
                    </form>
                </div>



            </div>
        </div>

    </nav>


    <div class="grid grid-cols-4 lg:grid-cols-12 mt-4 mx-8 p-0 lg:p-6 gap-5">

        <div class="col-span-4 lg:col-span-12">

            <div class="flex flex-col items-center gap-3 text-center">
                <x-application-logo class="w-[150px] h-[150px] text-gray-500" />
                <h1 class="text-3xl lg:text-4xl  font-bold">Complete your Details</h1>
            </div>

        </div>

        <div class="col-span-4 lg:col-start-2 lg:col-end-12" x-data="{
            currentStep: @entangle('currentStep'),
            activeTab: 'bg-blue-400',
            inactiveTab: 'bg-white',
        }">

            <div class="flex flex-col items-center  text-center">
                <h1 class="lg:hidden  text-2xl font-bold mb-2"><span class="text-blue-500">Step
                        {{ $this->currentStep }}</span> / 5</h1>
            </div>

            <div class="flex flex-row h-full w-full">
                <ul class="hidden lg:block border border-gray-200 rounded overflow-hidden shadow-md">
                    <li :class="currentStep === 1 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Employer Details</li>
                    <li :class="currentStep === 2 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Contact Details</li>
                    <li :class="currentStep === 3 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Partnerships</li>
                    <li :class="currentStep === 4 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Requirements</li>
                    <li :class="currentStep === 5 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Certification And Authorization</li>
                </ul>
                <div class="w-full px-6 py-6 bg-white shadow-md lg:rounded-r-lg">

                    {{-- APPLICANT NAME --}}
                    <div x-show="currentStep === 1" class="section employerDetails-section  h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0">
                        <livewire:signup.employer.partials.company-information />
                    </div>


                    {{-- //PERSONAL INFORMATION --}}
                    <div x-show="currentStep === 2" class="section comapnyContact-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        <livewire:signup.employer.partials.contact-information />

                    </div>

                    <div x-show="currentStep === 3" class="section comapnyContact-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        <livewire:signup.employer.partials.partnerships />

                    </div>

                    <div x-show="currentStep === 4" class="section comapnyContact-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        @if ($formData)
                            <livewire:signup.employer.partials.requirements :reqType="$formData[1]['empType']" />
                        @endif
                    </div>

                    {{-- employment status --}}
                    <div x-show="currentStep === 5" class="section employmentStatus-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>

                        <livewire:signup.employer.partials.confirmation />

                    </div>



                </div>

            </div>
        </div>
    </div>
</div>
