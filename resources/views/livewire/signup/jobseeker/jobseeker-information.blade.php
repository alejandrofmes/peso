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
                        <!-- Navigation Links -->
                        @if (auth()->user()->usertype == 2)
                            <x-nav-link wire:navigate :href="route('fill_profile')" :active="request()->routeIs('fill_profile')">
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
                        {{ $this->currentStep }}</span> / 12</h1>
            </div>

            <div class="flex flex-row h-full w-full">

                <ul class="hidden lg:block border border-gray-200 rounded-l overflow-hidden shadow-md">
                    <li :class="currentStep === 1 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Applicant Name</li>
                    <li :class="currentStep === 2 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Personal Information</li>
                    <li :class="currentStep === 3 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Employment Status</li>
                    <li :class="currentStep === 4 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Job Preferences</li>
                    <li :class="currentStep === 5 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Language/Dialects</li>
                    <li :class="currentStep === 6 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Educational Background</li>
                    <li :class="currentStep === 7 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Certification/Training</li>
                    <li :class="currentStep === 8 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Eligibility/License</li>
                    <li :class="currentStep === 9 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Work Experience</li>
                    <li :class="currentStep === 10 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Other Skills</li>
                    <li :class="currentStep === 11 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Profile Privacy</li>
                    <li :class="currentStep === 12 ? activeTab : inactiveTab"
                        class="section-item px-4 py-2 hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                        Certification And Authorization</li>
                </ul>

                <div class="w-full px-6 py-6 bg-white shadow-md  lg:rounded-r-lg">


                    {{-- APPLICANT NAME --}}
                    <div x-show="currentStep === 1" class="applicant-name-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0">
                        <livewire:signup.jobseeker.partials.applicant-name />


                    </div>

                    {{-- personal information --}}
                    <div x-show="currentStep === 2" class="personal-information-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        <livewire:signup.jobseeker.partials.personal-information />



                    </div>

                    {{-- employment status --}}
                    <div x-show="currentStep === 3" class="employment-status-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        <livewire:signup.jobseeker.partials.employment-status />


                    </div>

                    {{-- JOB PREFERENCES --}}
                    <div x-show="currentStep === 4" class="job-preference-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        <livewire:signup.jobseeker.partials.job-preference />

                    </div>

                    {{-- LANGUAGE/DIALECTS --}}
                    <div x-show="currentStep === 5" class="language-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        <livewire:signup.jobseeker.partials.language />

                    </div>

                    {{-- EDUCATIONAL BACKGROUND --}}
                    <div x-show="currentStep === 6" class="education-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        <livewire:signup.jobseeker.partials.education />

                    </div>

                    {{-- CERTIFICATION AND TRAININGS --}}
                    <div x-show="currentStep === 7" class="certiciation-training-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        <livewire:signup.jobseeker.partials.certification-training />

                    </div>

                    {{-- ELIGIBILITY/LICENSE --}}
                    <div x-show="currentStep === 8" class="eligibility-license-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        <livewire:signup.jobseeker.partials.eligibility-license />

                    </div>

                    {{-- WORK EXPERIENCE --}}
                    <div x-show="currentStep === 9" class="work-experience-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        <livewire:signup.jobseeker.partials.work-experience />

                    </div>

                    {{-- OTHER SKILLS --}}
                    <div x-show="currentStep === 10" class="other-skills-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        <livewire:signup.jobseeker.partials.other-skills />

                    </div>

                    <div x-show="currentStep === 11" class="confirmation-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        <livewire:signup.jobseeker.partials.profile-privacy />


                    </div>

                    <div x-show="currentStep === 12" class="confirmation-section h-full w-full"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                        <livewire:signup.jobseeker.partials.confirmation />

                    </div>




                </div>

            </div>
        </div>
        {{-- dont delete --}}
    </div>
</div>
