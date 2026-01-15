<aside id="default-sidebar"
    class="hidden sm:block sticky top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50" x-data="{ activeNav: 'bg-gray-300', inactiveNav: 'hover:bg-gray-100' }">
        <h5 id="drawer-navigation-label" class="text-base font-semibold text-gray-500 uppercase">Menu</h5>
        <ul class="space-y-2 font-medium">
            @if (Auth::check() && Auth::user()->usertype != 11)
                <li>
                    <a wire:navigate href="{{ route('admin') }}"
                        :class="{{ request()->routeIs('admin') }} ? activeNav : inactiveNav"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-300 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 "
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>

                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
            @endif

            @if (Auth::check() && Auth::user()->usertype == 11)
                <li>
                    <a wire:navigate href="{{ route('super-dashboard') }}"
                        :class="{{ request()->routeIs('super-dashboard') }} ? activeNav : inactiveNav"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-300 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 "
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>

                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
            @endif
            @if (Auth::check() && Auth::user()->usertype != 11)
                <li>
                    <a wire:navigate href="{{ route('admin-joblist') }}" {{-- href="{{ route('admin-joblist', 'admin.jobpost', 'admin.jobpost.applicants', 'admin.jobpost.applicants.overview') }} --}}
                        :class="{{ request()->routeIs('admin-joblist') || request()->routeIs('admin.jobpost') || request()->routeIs('admin.jobpost.applicants') || request()->routeIs('admin.jobpost.applicants.overview') }}
                            ?
                            activeNav : inactiveNav"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-300 ">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 "
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 18 18">
                            <path
                                d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Job Posting</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('admin-partnership') }}"
                        :class="{{ request()->routeIs('admin-partnership', 'admin-partnership-details') }}
                            ?
                            activeNav : inactiveNav"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-300 ">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 "
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Partnerships</span>
                    </a>
                </li>
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-300"
                        data-collapse-toggle="dropdown-1">

                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Role Management</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-1"
                        class="py-2 space-y-2 {{ request()->routeIs('admin-users-peso', 'admin-users-jobseeker', 'admin-users-employer', 'admin-users-jobseeker-overview', 'admin-users-employer-overview') ? 'block' : 'hidden' }}">
                        <li>
                            <a wire:navigate href="{{ route('admin-users-jobseeker') }}"
                                :class="{{ request()->routeIs('admin-users-jobseeker') || request()->routeIs('admin-users-jobseeker-overview') }}
                                    ?
                                    activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300">Jobseekers
                                Management</a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('admin-users-employer') }}"
                                :class="{{ request()->routeIs('admin-users-employer') || request()->routeIs('admin-users-employer-overview') }}
                                    ?
                                    activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300">Employers
                                Management</a>
                        </li>
                        @if (Auth::check() && Auth::user()->usertype == 10)
                            <li>
                                <a wire:navigate href="{{ route('admin-users-peso') }}"
                                    :class="{{ request()->routeIs('admin-users-peso') }} ? activeNav : inactiveNav"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300">PESO
                                    Accounts</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (Auth::check() && Auth::user()->usertype == 11)
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-300 "
                        data-collapse-toggle="dropdown-2">

                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 7.205c4.418 0 8-1.165 8-2.602C20 3.165 16.418 2 12 2S4 3.165 4 4.603c0 1.437 3.582 2.602 8 2.602ZM12 22c4.963 0 8-1.686 8-2.603v-4.404c-.052.032-.112.06-.165.09a7.75 7.75 0 0 1-.745.387c-.193.088-.394.173-.6.253-.063.024-.124.05-.189.073a18.934 18.934 0 0 1-6.3.998c-2.135.027-4.26-.31-6.3-.998-.065-.024-.126-.05-.189-.073a10.143 10.143 0 0 1-.852-.373 7.75 7.75 0 0 1-.493-.267c-.053-.03-.113-.058-.165-.09v4.404C4 20.315 7.037 22 12 22Zm7.09-13.928a9.91 9.91 0 0 1-.6.253c-.063.025-.124.05-.189.074a18.935 18.935 0 0 1-6.3.998c-2.135.027-4.26-.31-6.3-.998-.065-.024-.126-.05-.189-.074a10.163 10.163 0 0 1-.852-.372 7.816 7.816 0 0 1-.493-.268c-.055-.03-.115-.058-.167-.09V12c0 .917 3.037 2.603 8 2.603s8-1.686 8-2.603V7.596c-.052.031-.112.059-.165.09a7.816 7.816 0 0 1-.745.386Z" />
                        </svg>


                        {{-- <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                        <path
                            d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                    </svg> --}}
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Data management</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-2"
                        class="py-2 space-y-2 {{ request()->routeIs('admin-certificate', 'admin-eligibility', 'admin-location', 'admin-industry') ? 'block' : 'hidden' }}">

                        <li>
                            <a wire:navigate href="{{ route('admin-certificate') }}"
                                :class="{{ request()->routeIs('admin-certificate') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300 ">Certificates</a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('admin-eligibility') }}"
                                :class="{{ request()->routeIs('admin-eligibility') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300">Eligibility
                                and License</a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('admin-location') }}"
                                :class="{{ request()->routeIs('admin-location') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300">Locations</a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('admin-industry') }}"
                                :class="{{ request()->routeIs('admin-industry') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300">Positions
                                and Industry</a>
                        </li>


                    </ul>
                </li>
                <li>
                    <a wire:navigate href="{{ route('admin-req') }}"
                        :class="{{ request()->routeIs('admin-req') }} ? activeNav : inactiveNav"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-300 ">


                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 "
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM9.75 17.25a.75.75 0 0 0-1.5 0V18a.75.75 0 0 0 1.5 0v-.75Zm2.25-3a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3a.75.75 0 0 1 .75-.75Zm3.75-1.5a.75.75 0 0 0-1.5 0V18a.75.75 0 0 0 1.5 0v-5.25Z"
                                clip-rule="evenodd" />
                            <path
                                d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap">Requirements</span>
                    </a>
                </li>
            @endif
            @if (Auth::check() && Auth::user()->usertype != 11)
                <li>
                    <a wire:navigate href="{{ route('admin-announcement') }}"
                        :class="{{ request()->routeIs('admin-announcement') }} ? activeNav : inactiveNav"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-300 ">

                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 "
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M16.881 4.345A23.112 23.112 0 0 1 8.25 6H7.5a5.25 5.25 0 0 0-.88 10.427 21.593 21.593 0 0 0 1.378 3.94c.464 1.004 1.674 1.32 2.582.796l.657-.379c.88-.508 1.165-1.593.772-2.468a17.116 17.116 0 0 1-.628-1.607c1.918.258 3.76.75 5.5 1.446A21.727 21.727 0 0 0 18 11.25c0-2.414-.393-4.735-1.119-6.905ZM18.26 3.74a23.22 23.22 0 0 1 1.24 7.51 23.22 23.22 0 0 1-1.41 7.992.75.75 0 1 0 1.409.516 24.555 24.555 0 0 0 1.415-6.43 2.992 2.992 0 0 0 .836-2.078c0-.807-.319-1.54-.836-2.078a24.65 24.65 0 0 0-1.415-6.43.75.75 0 1 0-1.409.516c.059.16.116.321.17.483Z" />
                        </svg>


                        <span class="flex-1 ms-3 whitespace-nowrap">Announcements</span>
                    </a>
                </li>
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-300"
                        data-collapse-toggle="dropdown-3">

                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 "
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            className="w-6 h-6">
                            <path
                                d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                            <path
                                d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                            <path
                                d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                        </svg>

                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Trainings</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-3"
                        class="py-2 space-y-2 {{ request()->routeIs('admin-training', 'admin-create-training', 'admin-view-training', 'admin-registrants-training') ? 'block' : 'hidden' }}">

                        <li>
                            <a wire:navigate href="{{ route('admin-training') }}"
                                :class="{{ request()->routeIs('admin-training', 'admin-view-training', 'admin-registrants-training', 'admin-registrants-training') }}
                                    ?
                                    activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300 ">Training
                                List</a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('admin-create-training') }}"
                                :class="{{ request()->routeIs('admin-create-training') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300">Create
                                a Training</a>
                        </li>

                    </ul>
                </li>
            @endif
            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-300"
                    data-collapse-toggle="dropdown-4">

                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M2.25 2.25a.75.75 0 0 0 0 1.5H3v10.5a3 3 0 0 0 3 3h1.21l-1.172 3.513a.75.75 0 0 0 1.424.474l.329-.987h8.418l.33.987a.75.75 0 0 0 1.422-.474l-1.17-3.513H18a3 3 0 0 0 3-3V3.75h.75a.75.75 0 0 0 0-1.5H2.25Zm6.04 16.5.5-1.5h6.42l.5 1.5H8.29Zm7.46-12a.75.75 0 0 0-1.5 0v6a.75.75 0 0 0 1.5 0v-6Zm-3 2.25a.75.75 0 0 0-1.5 0v3.75a.75.75 0 0 0 1.5 0V9Zm-3 2.25a.75.75 0 0 0-1.5 0v1.5a.75.75 0 0 0 1.5 0v-1.5Z"
                            clip-rule="evenodd" />
                    </svg>

                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Reports</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="dropdown-4"
                    class="py-2 space-y-2 {{ request()->routeIs('admin-reports-barangay', 'admin-reports-municipality', 'super-municipality', 'super-province') ? 'block' : 'hidden' }}">
                    @if (Auth::check() && Auth::user()->usertype != 11)
                        <li>
                            <a wire:navigate href="{{ route('admin-reports-barangay') }}"
                                :class="{{ request()->routeIs('admin-reports-barangay') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300 ">Barangay</a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('admin-reports-municipality') }}"
                                :class="{{ request()->routeIs('admin-reports-municipality') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300">Municipality</a>
                        </li>
                    @endif
                    @if (Auth::check() && Auth::user()->usertype == 11)
                        <li>
                            <a wire:navigate href="{{ route('super-municipality') }}"
                                :class="{{ request()->routeIs('super-municipality') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300">Municipality</a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('super-province') }}"
                                :class="{{ request()->routeIs('super-province') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300">Province</a>
                        </li>
                    @endif

                </ul>
            </li>


            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-300"
                    data-collapse-toggle="dropdown-5">

                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z"
                            clip-rule="evenodd" />
                        <path
                            d="m10.076 8.64-2.201-2.2V4.874a.75.75 0 0 0-.364-.643l-3.75-2.25a.75.75 0 0 0-.916.113l-.75.75a.75.75 0 0 0-.113.916l2.25 3.75a.75.75 0 0 0 .643.364h1.564l2.062 2.062 1.575-1.297Z" />
                        <path fill-rule="evenodd"
                            d="m12.556 17.329 4.183 4.182a3.375 3.375 0 0 0 4.773-4.773l-3.306-3.305a6.803 6.803 0 0 1-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 0 0-.167.063l-3.086 3.748Zm3.414-1.36a.75.75 0 0 1 1.06 0l1.875 1.876a.75.75 0 1 1-1.06 1.06L15.97 17.03a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" />
                    </svg>

                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Maintenance</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>


                </button>
                <ul id="dropdown-5"
                    class="py-2 space-y-2 {{ request()->routeIs('admin-audits', 'admin-peso', 'admin-backups', 'admin-municipality-audits', 'admin-features') ? 'block' : 'hidden' }}">
                    @if (Auth::check() && Auth::user()->usertype == 11)
                        <li>
                            <a wire:navigate href="{{ route('admin-peso') }}"
                                :class="{{ request()->routeIs('admin-peso') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300 ">PESO
                                Branch</a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('admin-audits') }}"
                                :class="{{ request()->routeIs('admin-audits') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300 ">Audit
                                Log</a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('admin-backups') }}"
                                :class="{{ request()->routeIs('admin-backups') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300 ">Backups</a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('admin-features') }}"
                                :class="{{ request()->routeIs('admin-features') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300 ">Experimental Features</a>
                        </li>
                    @endif
                    @if (Auth::check() && Auth::user()->usertype != 11)
                        <li>
                            <a wire:navigate href="{{ route('admin-municipality-audits') }}"
                                :class="{{ request()->routeIs('admin-municipality-audits') }} ? activeNav : inactiveNav"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-300 ">Audit
                                Log</a>
                        </li>
                    @endif



                </ul>
            </li>

        </ul>
    </div>
</aside>
