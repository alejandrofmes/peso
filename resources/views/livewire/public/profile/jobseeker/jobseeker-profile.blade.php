<div wire:poll.10s>
    <div class="container flex flex-col w-full h-full gap-4 p-4 mx-auto md:flex-row md:p-0 md:py-8">

        <div class="flex flex-col md:w-1/4 h-full md:sticky top-5 truncate ...">
            <div class="p-6 bg-white rounded-lg shadow-xl text-wrap ">
                <div class="flex flex-col items-center">
                    {{-- <img src="https://randomuser.me/api/portraits/men/94.jpg" --}}
                    <img src="{{ $jobseeker->pimg ? asset('storage/' . $jobseeker->pimg) : asset('https://pixabay.com/vectors/blank-profile-picture-mystery-man-973460/') }}"
                        alt="user-{{ $jobseeker->employee_id }}"
                        class="object-cover w-32 h-32 mb-4 bg-gray-300 rounded-full shadow-xl select-none shrink-0">
                    </img>
                    <h1 class="text-xl font-bold text-center uppercase">{{ $jobseeker->fname }} {{ $jobseeker->lname }}
                    </h1>



                    <p class="text-gray-700 select-none">
                        {{ $jobseeker->empstatus == 1 ? 'EMPLOYED' : 'UNEMPLOYED' }}
                    </p>


                    @if ($isOwner)
                        <div class="flex flex-wrap justify-center gap-4 mt-6">
                            <div x-data="{ tooltip: 'View Auto-Generated Resume' }">
                                <button wire:click.prevent="viewFile({{ $jobseeker->employee_id }}, 2)"
                                    x-tooltip="tooltip" type="button"
                                    class="inline-flex items-center p-1 text-sm font-medium text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <hr class="my-6 border-t border-gray-300">
                <div class="flex flex-col w-full px-5 mt-5 select-none">

                    <ul>
                        <li class="mb-4">
                            <div class="flex flex-row w-full gap-4">
                                <div class="flex flex-col">
                                    <svg class="text-blue-500 w-7 h-7" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="2"
                                            d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                </div>
                                <div class="flex flex-col gap-1">
                                    <div class="text-lg font-bold text-black">
                                        Gender
                                    </div>
                                    <div class="font-medium break-all text-md">

                                        {{ $jobseeker->gender == 1 ? 'MALE' : 'FEMALE' }}

                                    </div>


                                </div>
                            </div>
                        </li>

                        <li class="mb-4">
                            <div class="flex flex-row w-full gap-4">
                                <div class="flex flex-col">
                                    <svg class="text-blue-500 w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                    </svg>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <div class="text-lg font-bold text-black">
                                        Qualification
                                    </div>
                                    <div class="font-medium break-all text-md">
                                        {{ $highestEduTitle }}
                                    </div>


                                </div>
                            </div>
                        </li>

                        {{-- <li class="mb-4">
                            <div class="flex flex-row w-full gap-4">
                                <div class="flex flex-col">
                                    <svg class="text-blue-500 w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>

                                </div>
                                <div class="flex flex-col gap-1">
                                    <div class="text-lg font-bold text-black">
                                        Email
                                    </div>
                                    <div class="font-medium uppercase break-all text-md">
                                        {{ $jobseeker->user->email }}

                                    </div>


                                </div>
                            </div>
                        </li> --}}

                        {{-- <li class="mb-4">
                            <div class="flex flex-row w-full gap-4">
                                <div class="flex flex-col">
                                    <svg class="text-blue-500 w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                    </svg>



                                </div>
                                <div class="flex flex-col gap-1">
                                    <div class="text-lg font-bold text-black">
                                        Phone Number
                                    </div>
                                    <div class="font-medium break-all text-md">
                                        {{ $jobseeker->pnumber }}
                                    </div>


                                </div>
                            </div>
                        </li> --}}



                    </ul>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:w-3/4 " x-data="{
            profileTab: 'profileOverview',
        }">

            <div x-show="profileTab === 'profileOverview'" class="flex flex-col space-y-5"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100">

                <div class="container">
                    <div class="p-6 bg-white rounded-lg shadow-lg text-wrap">
                        <div class="flex flex-row items-center justify-between w-full">
                            <h2 class="text-xl font-bold">About me</h2>


                            @if ($isOwner)
                                <div x-data="{ tooltip: 'Edit Description' }">
                                    <div x-tooltip="tooltip"
                                        class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300">
                                        <svg wire:click.prevent='editModal()' class="w-8 h-8"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </div>
                                </div>
                            @endif
                        </div>


                        <p class="px-1 text-justify text-gray-700 break-words text-wrap">
                            {{ $jobseeker->empDesc ?: 'No Description' }}

                        </p>

                    </div>
                </div>




                <div class="container">
                    <div class="p-6 bg-white rounded-lg shadow" x-data="{
                        openTab: 1,
                        activeTab: 'text-blue-600 border-blue-600 active',
                        inactiveTab: 'border-transparent hover:text-gray-600 hover:border-gray-300',
                        activeIcon: 'text-blue-600',
                        inactiveIcon: 'text-gray-400 group-hover:text-gray-500'
                    }">


                        <div class ="border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 "
                                role="tablist" aria-label="tabs">
                                <li class="me-2">
                                    <button @click="openTab = 1" :class="openTab === 1 ? activeTab : inactiveTab"
                                        class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group tab">

                                        <svg :class="openTab === 1 ? activeIcon : inactiveIcon"
                                            class="w-4 h-4 me-2 groupIcon" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z"
                                                clip-rule="evenodd" />
                                        </svg>



                                        Details
                                    </button>
                                </li>
                                <li class="me-2">
                                    <button @click="openTab = 2" :class="openTab === 2 ? activeTab : inactiveTab"
                                        class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group tab">
                                        <i :class="openTab === 2 ? activeIcon : inactiveIcon"
                                            class="w-4 h-4 me-2 groupIcon fa-solid fa-school" id="panel-1"></i>

                                        Education
                                    </button>
                                </li>
                                <li class="me-2">
                                    <button @click="openTab = 3" :class="openTab === 3 ? activeTab : inactiveTab"
                                        class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group tab">
                                        <i :class="openTab === 3 ? activeIcon : inactiveIcon"
                                            class="w-4 h-4 me-2 groupIcon fas fa-briefcase" id="panel-2"></i>
                                        Work Experience
                                    </button>
                                </li>
                                <li class="me-2">
                                    <button @click="openTab = 4" :class="openTab === 4 ? activeTab : inactiveTab"
                                        class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group tab">
                                        <svg :class="openTab === 4 ? activeIcon : inactiveIcon"
                                            class="w-4 h-4 me-2 groupIcon" id="panel-3" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 20 20">

                                            <path
                                                d="M5 11.424V1a1 1 0 1 0-2 0v10.424a3.228 3.228 0 0 0 0 6.152V19a1 1 0 1 0 2 0v-1.424a3.228 3.228 0 0 0 0-6.152ZM19.25 14.5A3.243 3.243 0 0 0 17 11.424V1a1 1 0 0 0-2 0v10.424a3.227 3.227 0 0 0 0 6.152V19a1 1 0 1 0 2 0v-1.424a3.243 3.243 0 0 0 2.25-3.076Zm-6-9A3.243 3.243 0 0 0 11 2.424V1a1 1 0 0 0-2 0v1.424a3.228 3.228 0 0 0 0 6.152V19a1 1 0 1 0 2 0V8.576A3.243 3.243 0 0 0 13.25 5.5Z" />
                                        </svg>Trainings
                                    </button>
                                </li>
                                <li class="me-2">
                                    <button @click="openTab = 5" :class="openTab === 5 ? activeTab : inactiveTab"
                                        class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group tab">

                                        <svg :class="openTab === 5 ? activeIcon : inactiveIcon"
                                            class="w-4 h-4 me-2 groupIcon" id="panel-4" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 18 20">
                                            <path
                                                d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                        </svg>Certificates
                                    </button>
                                </li>

                            </ul>
                        </div>

                        <div class="select-none" x-show="openTab === 1"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100" x-cloak>

                            <div class="flex flex-row items-center justify-between w-full mt-4 mb-4">
                                <h2 class="text-3xl font-black">Jobseeker Details</h2>

                                {{-- eto sa edit deets --}}
                                @if ($isOwner)
                                    <div x-data="{ tooltip: 'Edit Details' }">
                                        <a x-tooltip="tooltip" wire:navigate href="{{ route('edit.details') }}">
                                            <div
                                                class="flex items-center p-1 transition-transform rounded-full hover:bg-gray-300">
                                                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- <div class="flex items-center justify-center h-10 bg-blue-500 rounded-r-lg w-60">
                                <h2 class="text-lg font-medium text-white">Job Preference</h2>
                            </div> --}}

                            @if ($jobseeker->job_preference->count() >= 1)
                                <h2 class="mt-4 text-xl font-medium">Job Preference</h2>
                                <div class="flex flex-col w-full">
                                    {{-- BADGE CONTAINER --}}
                                    <div id= "otherSkillRow" class="p-1 flex-inline">
                                        {{-- BADGE --}}
                                        @foreach ($jobseeker->job_preference as $preferences)
                                            <span wire:key='jobPref-{{ $preferences->job_preference_id }}'
                                                class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-2 ps-3 pe-3 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $preferences->job_positions->position_Title }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($jobseeker->industry_preference->count() >= 1)
                                <h2 class="mt-4 text-xl font-medium">Industry Preference</h2>
                                <div class="flex flex-col w-full">
                                    {{-- BADGE CONTAINER --}}
                                    <div id= "otherSkillRow" class="p-1 flex-inline">
                                        {{-- BADGE --}}
                                        @foreach ($jobseeker->industry_preference as $preferences)
                                            <span wire:key='jobPref-{{ $preferences->industry_preference_id }}'
                                                class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-2 ps-3 pe-3 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $preferences->job_industry->industry_Title }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif




                            @if ($jobseeker->skills->count() >= 1)
                                <h2 class="mt-4 text-xl font-medium">Skills</h2>
                                <div class="flex flex-col w-full">
                                    {{-- BADGE CONTAINER --}}
                                    <div id= "otherSkillRow" class="p-1 flex-inline">
                                        {{-- BADGE --}}

                                        @foreach ($jobseeker->skills as $empSkills)
                                            <span wire:key='skills-{{ $empSkills->skills_id }}'
                                                class="inline-flex items-center mr-1 my-1 gap-x-1.5 py-2 ps-3 pe-3 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $empSkills->skill_Type }}
                                            </span>
                                        @endforeach

                                    </div>
                                </div>
                            @endif

                            @if ($jobseeker->language->count() >= 1)
                                <div class="flex flex-col w-full gap-4 md:flex-row md:gap-10">
                                    <div class="flex flex-col md:w-1/2 ">
                                        <h2 class="mt-4 text-xl font-medium">Language</h2>
                                        <div class="flex flex-col gap-2 mt-2 ml-2">
                                            @foreach ($jobseeker->language as $empLanguage)
                                                <div x-data="{
                                                    skills: [],
                                                    percentage: 0,
                                                    init() {
                                                        this.skills = [];
                                                        this.percentage = 0;
                                                
                                                        if ({{ $empLanguage->language_Read }} == 1) {
                                                            this.skills.push('Read');
                                                            this.percentage += 25;
                                                        }
                                                        if ({{ $empLanguage->language_Write }} == 1) {
                                                            this.skills.push('Write');
                                                            this.percentage += 25;
                                                        }
                                                        if ({{ $empLanguage->language_Speak }} == 1) {
                                                            this.skills.push('Speak');
                                                            this.percentage += 25;
                                                        }
                                                        if ({{ $empLanguage->language_Understand }} == 1) {
                                                            this.skills.push('Understand');
                                                            this.percentage += 25;
                                                        }
                                                
                                                    }
                                                }" x-init="init">
                                                    <span class="text-base font-medium text-blue-700">
                                                        {{ $empLanguage->language_Type }}
                                                    </span>

                                                    <div class="w-full bg-gray-200 rounded-full">
                                                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                                            :style="{ width: percentage + '%' }">
                                                            <span x-text="skills.join(' / ')"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                            @endif



                            @if ($jobseeker->disability->count() >= 1)
                                <div class="flex flex-col md:w-1/2">

                                    <h2 class="mt-4 text-xl font-medium">Disability</h2>
                                    <ul
                                        class="max-w-md mt-4 ml-2 space-y-1 text-base font-medium text-blue-700 list-disc list-inside">
                                        @foreach ($jobseeker->disability as $empDisability)
                                            <li class="uppercase"
                                                wire:key='disability-{{ $empDisability->disability_id }}'>
                                                {{ $empDisability->disability_Type }}
                                            </li>
                                        @endforeach

                                    </ul>



                                </div>
                            @endif
                        </div>





                    </div>



                    <div class="select-none" x-show="openTab === 2"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-cloak>

                        <div class="flex flex-row justify-between w-full mt-6 mb-4">
                            <h2 class="text-3xl font-black">Education</h2>

                            @if ($isOwner)
                                <div class="flex flex-row items-center gap-4">
                                    <div x-data="{ tooltip: 'Add Education Record' }">
                                        <div x-tooltip="tooltip" x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'education-modal')"
                                            class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300">
                                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>

                                        </div>
                                    </div>
                                    <div x-data="{ tooltip: 'Edit Education Record' }">
                                        <div x-tooltip="tooltip" @click="profileTab = 'editEducation'"
                                            class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300">
                                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        @if ($jobseeker->education->isEmpty())

                            <div class="flex flex-col items-center justify-center mt-20 mb-20">
                                <div class="flex p-1 bg-gray-100 rounded-full">

                                    <svg class="w-24 h-24 text-black" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                    </svg>

                                </div>

                                <div class="mt-5 text-xl font-semibold text-center text-black">
                                    Education is empty.
                                </div>
                            </div>
                        @else
                            {{-- <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 "> --}}

                            @foreach ($jobseeker->education as $educBackground)
                                <div wire:key="{{ $educBackground->education_id }}" class="container p-3">
                                    <div class="flex flex-row items-center h-full">
                                        <div class="flex flex-col">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-10 h-10 text-gray-800 lg:w-20 lg:h-20 ">
                                                <path
                                                    d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                                                <path
                                                    d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                                                <path
                                                    d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                                            </svg>
                                        </div>

                                        <div class="flex flex-col w-full ml-4">
                                            <span
                                                class="text-xl font-black text-black uppercase md:text-2xl">{{ $educBackground->edu_School }}</span>
                                            <div class="text-lg font-semibold text-black uppercase md:text-xl">
                                                <span>{{ $educBackground->edu_Course }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-700 uppercase md:text-md">
                                                {{ $educBackground->edu_Started->format('F Y') }} -
                                                {{ $educBackground->edu_Ongoing == 1 ? 'Present' : $educBackground->edu_Ended->format('F Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <hr class="h-0.5 my-2 mx-10 bg-blue-200 border-0">
                            @endforeach
                            {{-- </div> --}}
                        @endif

                    </div>



                    <div class="select-none" x-show="openTab === 3"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-cloak>


                        <div class="flex flex-row justify-between w-full mt-6 mb-4">
                            <h2 class="text-3xl font-black">Work Experience</h2>
                            @if ($isOwner)
                                <div class="flex flex-row items-center gap-4">
                                    <div x-data="{ tooltip: 'Add Work Experience' }">
                                        <div x-tooltip="tooltip" x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'workExp-modal')"
                                            class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300">
                                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>

                                        </div>
                                    </div>


                                    <div x-data="{ tooltip: 'Edit Work Experience' }">
                                        <div x-tooltip="tooltip" @click="profileTab = 'editWorkExperience'"
                                            class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300">
                                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        </div>

                        @if ($jobseeker->work_exp->isEmpty())

                            <div class="flex flex-col items-center justify-center mt-20 mb-20">
                                <div class="flex p-1 bg-gray-100 rounded-full">

                                    <svg class="w-24 h-24 text-black" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                    </svg>

                                </div>

                                <div class="mt-5 text-xl font-semibold text-center text-black">
                                    Work Experience is Empty.
                                </div>
                            </div>
                        @else
                            {{-- <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 "> --}}

                            @foreach ($jobseeker->work_exp as $work_experience)
                                <div wire:key="{{ $work_experience->workexp_id }}" class="container p-3">

                                    <div class="flex flex-row items-center h-full">

                                        <div class="flex flex-col">
                                            <svg class="w-10 h-10 text-gray-800 lg:w-20 lg:h-20" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M10 2a3 3 0 0 0-3 3v1H5a3 3 0 0 0-3 3v2.382l1.447.723.005.003.027.013.12.056c.108.05.272.123.486.212.429.177 1.056.416 1.834.655C7.481 13.524 9.63 14 12 14c2.372 0 4.52-.475 6.08-.956.78-.24 1.406-.478 1.835-.655a14.028 14.028 0 0 0 .606-.268l.027-.013.005-.002L22 11.381V9a3 3 0 0 0-3-3h-2V5a3 3 0 0 0-3-3h-4Zm5 4V5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1h6Zm6.447 7.894.553-.276V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-5.382l.553.276.002.002.004.002.013.006.041.02.151.07c.13.06.318.144.557.242.478.198 1.163.46 2.01.72C7.019 15.476 9.37 16 12 16c2.628 0 4.98-.525 6.67-1.044a22.95 22.95 0 0 0 2.01-.72 15.994 15.994 0 0 0 .707-.312l.041-.02.013-.006.004-.002.001-.001-.431-.866.432.865ZM12 10a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>

                                        <div class="flex flex-col w-full ml-4">
                                            <span
                                                class="text-xl font-black text-black uppercase md:text-2xl">{{ $work_experience->work_Name }}</span>
                                            <div class="text-lg font-semibold text-black uppercase md:text-xl">
                                                <span>{{ $work_experience->job_positions->position_Title }}</span>
                                                -
                                                <span>{{ $work_experience->work_Status }}</span>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700 uppercase md:text-md">
                                                {{ $work_experience->work_Start->format('F Y') }} -
                                                @if ($work_experience->work_End)
                                                    {{ $work_experience->work_End->format('F Y') }}
                                                @else
                                                    Present
                                                @endif
                                            </span>
                                            <span
                                                class="text-xs font-medium text-gray-700 uppercase md:text-sm">{{ $work_experience->work_Address }}</span>
                                        </div>

                                    </div>

                                </div>
                                <hr class="h-0.5 my-2 mx-10 bg-blue-200 border-0">
                            @endforeach

                            {{-- 
                                </div> --}}
                        @endif
                    </div>




                    <div class="select-none" x-show="openTab === 4"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-cloak>

                        <div class="flex flex-row justify-between w-full mt-6 mb-4">
                            <h2 class="text-3xl font-black">Trainings</h2>

                            @if ($isOwner)
                                <div class="flex flex-row items-center gap-4">
                                    <div x-data="{ tooltip: 'Add Training Record' }">
                                        <div x-tooltip="tooltip" x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'training-modal')"
                                            class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300">
                                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div x-data="{ tooltip: 'Edit Training Record' }">
                                        <div x-tooltip="tooltip" @click="profileTab = 'editTrainings'"
                                            class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300">
                                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if ($jobseeker->training->isEmpty())

                            <div class="flex flex-col items-center justify-center mt-20 mb-20">
                                <div class="flex p-1 bg-gray-100 rounded-full">

                                    <svg class="w-24 h-24 text-black" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                    </svg>

                                </div>

                                <div class="mt-5 text-xl font-semibold text-center text-black">
                                    Training Record is Empty.
                                </div>
                            </div>
                        @else
                            {{-- <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 "> --}}

                            @foreach ($jobseeker->training as $empTraining)
                                <div wire:key="{{ $empTraining->training_id }}" class="container p-3">

                                    <div class="flex flex-row items-center h-full">

                                        <div class="flex flex-col">
                                            <svg class="w-10 h-10 text-gray-800 lg:w-20 lg:h-20"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z"
                                                    clip-rule="evenodd" />
                                                <path
                                                    d="m10.076 8.64-2.201-2.2V4.874a.75.75 0 0 0-.364-.643l-3.75-2.25a.75.75 0 0 0-.916.113l-.75.75a.75.75 0 0 0-.113.916l2.25 3.75a.75.75 0 0 0 .643.364h1.564l2.062 2.062 1.575-1.297Z" />
                                                <path fill-rule="evenodd"
                                                    d="m12.556 17.329 4.183 4.182a3.375 3.375 0 0 0 4.773-4.773l-3.306-3.305a6.803 6.803 0 0 1-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 0 0-.167.063l-3.086 3.748Zm3.414-1.36a.75.75 0 0 1 1.06 0l1.875 1.876a.75.75 0 1 1-1.06 1.06L15.97 17.03a.75.75 0 0 1 0-1.06Z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                        </div>

                                        <div class="flex flex-col w-full ml-4">
                                            <span
                                                class="text-xl font-black text-black uppercase md:text-2xl">{{ $empTraining->training_Name }}</span>
                                            <div class="text-lg font-semibold text-black uppercase md:text-xl">
                                                <span>{{ $empTraining->training_Cert }}</span>
                                                -
                                                <span>{{ $empTraining->training_Status == 1 ? 'Completed' : 'Not Completed' }}</span>
                                            </div>
                                            <span
                                                class="text-sm font-medium text-gray-700 uppercase md:text-md">{{ $empTraining->training_From }}</span>
                                            <span class="text-sm font-medium text-gray-700 uppercase md:text-md">
                                                {{ $empTraining->training_Start->format('F Y') }} -

                                                @if ($empTraining->training_End)
                                                    {{ $empTraining->training_End->format('F Y') }}
                                                @else
                                                    Present
                                                @endif
                                            </span>
                                        </div>

                                    </div>

                                </div>
                                <hr class="h-0.5 my-2 mx-10 bg-blue-200 border-0">
                            @endforeach

                            {{-- </div> --}}
                        @endif
                    </div>


                    <div class="select-none" x-show="openTab === 5"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-cloak>

                        <div class="flex flex-row justify-between w-full mt-6 mb-4">
                            <h2 class="text-3xl font-black">Certificates</h2>

                            @if ($isOwner)
                                <div class="flex flex-row items-center gap-4">
                                    <div x-data="{ tooltip: 'Add Certificate Record' }">
                                        <div x-tooltip="tooltip" x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'certificate-modal')"
                                            class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300">
                                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div x-data="{ tooltip: 'Edit Certificate Record' }">
                                        <div x-tooltip="tooltip" @click="profileTab = 'editCertificates'"
                                            class="flex items-center p-1 transition-transform rounded-full cursor-pointer hover:bg-gray-300">
                                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        @if ($jobseeker->certificate->isEmpty())

                            <div class="flex flex-col items-center justify-center mt-20 mb-20">
                                <div class="flex p-1 bg-gray-100 rounded-full">

                                    <svg class="w-24 h-24 text-black" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                    </svg>

                                </div>

                                <div class="mt-5 text-xl font-semibold text-center text-black">
                                    Certificate Record is empty.
                                </div>
                            </div>
                        @else
                            {{-- <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 "> --}}

                            @foreach ($jobseeker->certificate as $certification)
                                <div wire:key="{{ $certification->certificate_id }}" class="container p-3">

                                    <div class="flex flex-row items-center h-full">
                                        <div class="flex flex-col">
                                            <svg class="w-10 h-10 text-gray-800 lg:w-20 lg:h-20"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path
                                                    d="M211 7.3C205 1 196-1.4 187.6 .8s-14.9 8.9-17.1 17.3L154.7 80.6l-62-17.5c-8.4-2.4-17.4 0-23.5 6.1s-8.5 15.1-6.1 23.5l17.5 62L18.1 170.6c-8.4 2.1-15 8.7-17.3 17.1S1 205 7.3 211l46.2 45L7.3 301C1 307-1.4 316 .8 324.4s8.9 14.9 17.3 17.1l62.5 15.8-17.5 62c-2.4 8.4 0 17.4 6.1 23.5s15.1 8.5 23.5 6.1l62-17.5 15.8 62.5c2.1 8.4 8.7 15 17.1 17.3s17.3-.2 23.4-6.4l45-46.2 45 46.2c6.1 6.2 15 8.7 23.4 6.4s14.9-8.9 17.1-17.3l15.8-62.5 62 17.5c8.4 2.4 17.4 0 23.5-6.1s8.5-15.1 6.1-23.5l-17.5-62 62.5-15.8c8.4-2.1 15-8.7 17.3-17.1s-.2-17.4-6.4-23.4l-46.2-45 46.2-45c6.2-6.1 8.7-15 6.4-23.4s-8.9-14.9-17.3-17.1l-62.5-15.8 17.5-62c2.4-8.4 0-17.4-6.1-23.5s-15.1-8.5-23.5-6.1l-62 17.5L341.4 18.1c-2.1-8.4-8.7-15-17.1-17.3S307 1 301 7.3L256 53.5 211 7.3z" />
                                            </svg>
                                        </div>

                                        <div class="flex flex-col w-full ml-4">
                                            <span
                                                class="text-xl font-black text-black uppercase md:text-2xl">{{ $certification->certificateType->cert_Name }}</span>
                                            <span class="text-lg font-semibold text-black uppercase md:text-xl">
                                                {{ $certification->cert_From }}
                                            </span>
                                            <span
                                                class="font-medium text-gray-700 uppercase text-md md:text-lg">{{ $certification->cert_Rating }}</span>
                                            <span class="font-medium text-gray-700 uppercase text-md">
                                                {{ $certification->cert_Date_Issued->format('F Y') }}
                                            </span>
                                        </div>

                                    </div>

                                </div>
                                <hr class="h-0.5 my-2 mx-10 bg-blue-200 border-0">
                            @endforeach


                            {{-- </div> --}}
                        @endif
                    </div>

                </div>

            </div>



        </div>






        @livewire('public.profile.jobseeker.partials.edit-education', ['userID' => $id])
        @livewire('public.profile.jobseeker.partials.edit-work-experience', ['userID' => $id])
        @livewire('public.profile.jobseeker.partials.edit-trainings', ['userID' => $id])
        @livewire('public.profile.jobseeker.partials.edit-certificates', ['userID' => $id])


    </div>

</div>



{{--    --}}


<x-modal name="aboutme-modal" focusable>
    <div class="items-center w-full max-w-4xl px-6 py-6">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Edit About Me') }}
        </h2>
        <hr>
        <div class="flex flex-col mt-2">
            <div class="flex flex-col w-full mt-2">
                <x-input-label :value="__('About Me')" />
                <textarea wire:model='description' id="message" rows="6" required
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 resize-none overflow-y-auto"
                    placeholder="Write something about yourself here..." maxlength="600"></textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

        </div>



        <div class="flex justify-end mt-6">
            <x-secondary-button wire:loading.attr="disabled" type="button" wire:click.prevent='close'>
                {{ __('Cancel') }}
                <div wire:loading.delay.long wire:target="close" role="status">
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

            <div wire:click.prevent='save'>
                <x-primary-button wire:loading.attr="disabled" class="ms-3" type="button">
                    {{ __('Save') }}

                    <div wire:loading.delay.long role="status">

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
                </x-primary-button>
            </div>

        </div>
</x-modal>

</div>

@push('scripts')
    @script
        <script>
            Livewire.on('viewFile', event => {
                // Check if the event is an array and has at least one element
                if (Array.isArray(event) && event.length > 0) {
                    // Access the first element and then its properties
                    const data = event[0]; // Assuming the data object is the first element


                    // Extract URL and handle dynamic keys
                    const url = data.url;
                    const formData = {
                        ...data
                    }; // Spread the data object to use for form inputs

                    // Check if URL is present
                    if (url) {
                        // Create and configure the form element
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;
                        form.target = '_blank';

                        // Add CSRF token as a hidden input
                        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;
                        form.appendChild(csrfInput);

                        // Add all data inputs dynamically
                        for (const [key, value] of Object.entries(formData)) {
                            // Skip the URL and CSRF token from being added as form inputs
                            if (key !== 'url') {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = key;
                                input.value = value;
                                form.appendChild(input);
                            }
                        }

                        // Append form to the body and submit
                        document.body.appendChild(form);
                        form.submit();

                        // Clean up by removing the form element
                        document.body.removeChild(form);
                    } else {
                        console.error('URL not found in event data');
                    }
                } else {
                    console.error('Event is not in the expected format');
                }
            });
        </script>
    @endscript
@endpush
