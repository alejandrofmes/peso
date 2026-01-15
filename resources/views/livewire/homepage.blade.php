<div class="box-border justify-items-center p-6 space-y-10" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" x-show="show"
    x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-10"
    x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-500"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-10">



    {{-- <div class="grid grid-cols-4">
        <aside class="self-start sticky top-0 col-span-1">
        </aside>
        <main class="col-span-3">
            <div>

        </main>
    </div> --}}

    <div class="w-full overflow-x-auto lg:overflow-visiblepy-12">
        <div
            class="flex flex-nowrap gap-x-6 p-6 min-w-min lg:grid lg:grid-flow-row lg:grid-cols-3 lg:w-11/12 lg:mx-auto">
            <!-- Career Profile Card -->
            <div
                class="card flex-shrink-0 w-80 sm:card-side sm:w-96 lg:w-auto bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6 flex justify-center items-center">
                    <img class="w-full h-32 lg:h-auto object-contain rounded-t-xl"
                        src="{{ asset('assets/img/profile-brand.png') }}" alt="Build Professional Profile" />
                </div>
                <div class="card-body p-6">
                    <h5 class="card-title text-xl font-bold mb-3">
                        Create Your <span class="text-blue-600">Professional Brand</span>
                    </h5>
                    <p class="text-gray-600 leading-relaxed text-justify">
                        Stand out in the competitive job market with a compelling professional profile.
                        <span class="text-blue-600 font-medium">Showcase your achievements</span>, highlight key
                        expertise,
                        and craft a narrative that resonates with top employers.
                    </p>
                </div>
            </div>

            <!-- Skills Development Card -->
            <div
                class="card flex-shrink-0 w-80 sm:card-side sm:w-96 lg:w-auto bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6 flex justify-center items-center">
                    <img class="w-full h-32 lg:h-auto object-contain rounded-t-xl"
                        src="{{ asset('assets/img/puzzle.png') }}" alt="Skills Development" />
                </div>
                <div class="card-body p-6">
                    <h5 class="card-title text-xl font-bold mb-3">
                        Elevate Your Skills with <span class="text-blue-600">Training Opportunities</span>
                    </h5>
                    <p class="text-gray-600 leading-relaxed text-justify">
                        Discover skills training programs offered by PESO to enhance your qualifications.
                        Join us in <span class="text-blue-600 font-medium">targeted training initiatives</span>
                        that equip you with essential skills for career success.
                    </p>
                </div>

            </div>

            <!-- Job Opportunities Card -->
            <div
                class="card flex-shrink-0 w-80 sm:card-side sm:w-96 lg:w-auto bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6 flex justify-center items-center">
                    <img class="w-full h-32 lg:h-auto object-contain rounded-t-xl"
                        src="{{ asset('assets/img/job-op.png') }}" alt="Career Opportunities" />
                </div>
                <div class="card-body p-6">
                    <h5 class="card-title text-xl font-bold mb-3">
                        Explore Exciting <span class="text-blue-600">Job Opportunities</span>
                    </h5>
                    <p class="text-gray-600 leading-relaxed text-justify">
                        Explore job postings from various companies that align with your skills and preferences.
                        Find roles that suit your career aspirations and connect with opportunities
                        <span class="text-blue-600 font-medium">tailored to match you</span>.
                    </p>
                </div>


            </div>
        </div>
    </div>




    <div
        class="flex flex-col p-3 w-full mx-auto md:w-11/12 md:p-6 lg:h-5/6 lg:p-8 sm:gap-y-6 lg:gap-y-0 lg:gap-x-6 lg:flex-row bg-white rounded-lg shadow-sm">

        {{-- jobseeker chart --}}
        <div
            class="flex flex-col w-full justify-evenly space-y-4 sm:space-y-6 md:space-y-8 lg:space-y-0 lg:space-x-6 lg:flex-row">
            {{-- chart ng jobseeker na most tag/industry na na-hire --}}
            <div
                class="flex flex-col justify-start h-[400px] sm:h-[450px] md:h-[500px] lg:h-full w-full lg:w-1/2 bg-gray-50/50 rounded-xl p-4 sm:p-5 md:p-6">
                <div class="mb-4">
                    <h3 class="text-lg sm:text-xl font-semibold lg:text-2xl text-gray-800">Employer Job Trends</h3>
                    <p class="text-gray-500 text-xs sm:text-sm mt-1">Monthly hiring patterns across industries</p>
                </div>
                <div class="flex-1 w-full min-h-[300px]">
                    <livewire:livewire-column-chart key="{{ $employmentTrend->reactiveKey() }}" :column-chart-model="$employmentTrend" />
                </div>
            </div>

            {{-- chart ng matched? or narecommend na jobseeker,, top industry/tag --}}
            <div
                class="flex flex-col justify-start h-[400px] sm:h-[450px] md:h-[500px] lg:h-full w-full lg:w-1/2 bg-gray-50/50 rounded-xl p-4 sm:p-5 md:p-6">
                <div class="mb-4">
                    <h3 class="text-lg sm:text-xl font-semibold lg:text-2xl text-gray-800">Popular Job Openings</h3>
                    <p class="text-gray-500 text-xs sm:text-sm mt-1">Most in-demand positions</p>
                </div>
                <div class="flex-1 w-full min-h-[300px]">
                    <livewire:livewire-column-chart key="{{ $chartn->reactiveKey() }}" :column-chart-model="$chartn" />
                </div>
            </div>
        </div>

        {{-- short job stat --}}
        <div
            class="flex flex-col sm:flex-row lg:flex-col gap-3 sm:gap-4 lg:gap-5 py-4 sm:py-5 lg:py-6 justify-center lg:items-center w-full lg:w-3/12">
            {{-- Job Opportunities Card --}}
            <div
                class="group flex h-24 sm:h-28 w-full sm:flex-1 lg:w-52 flex-col items-center justify-center rounded-xl bg-white border border-gray-200 shadow-sm transition-all duration-200 hover:border-blue-200 hover:shadow-md hover:scale-[1.02]">
                <div class="flex flex-row items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-6 sm:size-8 mr-2 sm:mr-3 text-blue-500 group-hover:text-blue-600">
                        <path fill-rule="evenodd"
                            d="M7.5 5.25a3 3 0 0 1 3-3h3a3 3 0 0 1 3 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0 1 12 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 0 1 7.5 5.455V5.25Zm7.5 0v.09a49.488 49.488 0 0 0-6 0v-.09a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5Zm-3 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                            clip-rule="evenodd" />
                        <path
                            d="M3 18.4v-2.796a4.3 4.3 0 0 0 .713.31A26.226 26.226 0 0 0 12 17.25c2.892 0 5.68-.468 8.287-1.335.252-.084.49-.189.713-.311V18.4c0 1.452-1.047 2.728-2.523 2.923-2.12.282-4.282.427-6.477.427a49.19 49.19 0 0 1-6.477-.427C4.047 21.128 3 19.852 3 18.4Z" />
                    </svg>
                    <span class="font-bold text-gray-700 text-lg sm:text-xl">{{ $openjobs }}</span>
                </div>
                <div class="mt-2 text-gray-600 text-sm sm:text-base">Job Opportunities</div>
            </div>

            {{-- Development Trainings Card --}}
            <div
                class="group flex h-24 sm:h-28 w-full sm:flex-1 lg:w-52 flex-col items-center justify-center rounded-xl bg-white border border-gray-200 shadow-sm transition-all duration-200 hover:border-purple-200 hover:shadow-md hover:scale-[1.02]">
                <div class="flex flex-row items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-6 sm:size-8 mr-2 sm:mr-3 text-purple-500 group-hover:text-purple-600">
                        <path
                            d="M6 3a3 3 0 0 0-3 3v2.25a3 3 0 0 0 3 3h2.25a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H6ZM15.75 3a3 3 0 0 0-3 3v2.25a3 3 0 0 0 3 3H18a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3h-2.25ZM6 12.75a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h2.25a3 3 0 0 0 3-3v-2.25a3 3 0 0 0-3-3H6ZM17.625 13.5a.75.75 0 0 0-1.5 0v2.625H13.5a.75.75 0 0 0 0 1.5h2.625v2.625a.75.75 0 0 0 1.5 0v-2.625h2.625a.75.75 0 0 0 0-1.5h-2.625V13.5Z" />
                    </svg>
                    <span class="font-bold text-gray-700 text-lg sm:text-xl">{{ $opentrainings }}</span>
                </div>
                <div class="mt-2 text-gray-600 text-sm sm:text-base">Development Trainings</div>
            </div>

            {{-- Partner Companies Card --}}
            <div
                class="group flex h-24 sm:h-28 w-full sm:flex-1 lg:w-52 flex-col items-center justify-center rounded-xl bg-white border border-gray-200 shadow-sm transition-all duration-200 hover:border-green-200 hover:shadow-md hover:scale-[1.02]">
                <div class="flex flex-row items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-6 sm:size-8 mr-2 sm:mr-3 text-green-500 group-hover:text-green-600">
                        <path fill-rule="evenodd"
                            d="M3 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5H15v-18a.75.75 0 0 0 0-1.5H3ZM6.75 19.5v-2.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1-.75-.75ZM6 6.75A.75.75 0 0 1 6.75 6h.75a.75.75 0 0 1 0 1.5h-.75A.75.75 0 0 1 6 6.75ZM6.75 9a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM6 12.75a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 6a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75Zm-.75 3.75A.75.75 0 0 1 10.5 9h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 12a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM16.5 6.75v15h5.25a.75.75 0 0 0 0-1.5H21v-12a.75.75 0 0 0 0-1.5h-4.5Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-bold text-gray-700 text-lg sm:text-xl">{{ $partners }}</span>
                </div>
                <div class="mt-2 text-gray-600 text-sm sm:text-base">Partner Companies</div>
            </div>
        </div>
    </div>


    {{-- section 4 - employer --}}
    <div class="w-full md:w-11/12 mt-26">
        <div class="text-center py-2 lg:p-9">
            <h2 class="font-bold text-2xl lg:text-4xl text-blue-500">
                Support Candidate Sourcing for Employers
            </h2>

            <div class="flex flex-wrap justify-center mt-14 text-left">
                <div class="w-full px-6 lg:w-1/2 lg:text-center text-left">
                    <h3 class="font-bold mt-6 text-xl lg:text-3xl md:mt-4 sm:text-left">
                        Boost <span class="text-blue-500 font-extrabold">Company Reputation</span>
                    </h3>
                    <p class="text-justify lg:text-2xl mt-4 text-lg">
                        Become a <span class="text-blue-500">PESO Partner</span> and increase industry presence.
                        Get verified and expand connections on municipalities and their locals.
                        Enhance company visibility among top talent and foster employee growth.
                        Attract skilled professionals and build a strong, engaged workforce.
                    </p>
                </div>
                <div class="w-full px-6 lg:w-1/2 lg:text-center text-left">
                    <h3 class="font-bold mt-6 text-xl lg:text-3xl md:mt-4 sm:text-left">
                        Advertise <span class="text-blue-500 font-extrabold">Job Opportunities</span>
                    </h3>
                    <p class="text-justify lg:text-2xl mt-4 text-lg">
                        Source out candidates to support the company. Manage opportunity offers and
                        <span class="text-blue-500"> be known among skilled Jobseekers</span>.
                        Highlight company’s career advancement opportunities.
                        Foster connections through networking and outreach, ensuring that potential
                        candidates view your organization as a desirable workplace.
                    </p>
                </div>
            </div>

            <div class="flex flex-col-reverse lg:flex-wrap lg:flex-row lg:justify-between mt-6 text-center ">
                <div class="flex grow-0 w-full pt-2 lg:py-0 lg:w-5/12 lg:h-80 lg:ms-11">
                    <img src="{{ asset('assets/img/bg-peso-3.jpeg') }}" alt="peso-3"
                        class="flex grow object-cover rounded shadow-lg border border-merino-400 ">
                </div>
                <div class="w-full px-6 lg:w-1/2 lg:text-center text-left">
                    <h3 class="font-bold mt-6 text-xl lg:text-3xl md:mt-4 sm:text-left">
                        Recruit <span class="text-blue-500 font-extrabold">Matched</span> Candidates
                    </h3>
                    <p class="text-justify lg:text-2xl mt-4 text-lg">
                        With <span class="text-blue-500">PESO-aided candidate-to-job matching</span>,
                        identify better-suited candidates among applicants.
                        Enhance team dynamics and drive organizational success by focusing on the right fit.
                        Improve retention rates and a more engaged workforce by emphasizing compatibility in skills and
                        values.
                    </p>
                </div>
            </div>

        </div>
    </div>





    {{-- section  - announcements --}}
    <div class="bg-stone-200 rounded-3xl  lg:mx-10 shadow-lg">
        <div class="mx-0 lg:mx-auto py-5 sm:px-2 lg:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 lg:items-center gap-4">
                <div class="grid-cols-1 max-w-xl text-start mx-7 lg:me-0">
                    <h2 class="font-bold tracking-tight text-gray-900 text-3xl lg:text-5xl">
                        Public Notices from
                        <span class="text-blue-500"> PESO</span>.
                    </h2>

                    <p class="mt-4 text-md lg:text-lg text-justify">
                        Keep up with matters concerning public interest by checking in for the latest announcements.
                        Stay informed about your municipality's updates by signing up.
                    </p>

                    <div class="hidden lg:flex lg:mt-8 lg:gap-4">
                        <button aria-label="Previous slide" id="keen-slider-previous-desktop"
                            class="rounded-full border border-blue-500 p-3 text-blue-500 transition hover:bg-blue-500 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5 rtl:rotate-180">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </button>

                        <button aria-label="Next slide" id="keen-slider-next-desktop"
                            class="rounded-full border border-blue-500 p-3 text-blue-500 transition hover:bg-blue-500 hover:text-white">
                            <svg class="size-5 rtl:rotate-180" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" />
                            </svg>
                        </button>
                    </div>
                </div>

                @if ($announ->isEmpty())
                    <h2
                        class="sm:text-3xl font-bold tracking-tight text-center md:text-start lg:text-start text-stone-500 md:text-4xl lg:text-5xl">
                        No new announcement.
                    </h2>
                @else
                    <div class="mx-6 lg:col-span-2">
                        <div id="keen-slider" class="keen-slider">
                            @foreach ($announ as $ann)
                                <div class="keen-slider__slide">
                                    <div
                                        class="flex h-full flex-col justify-start  p-2 lg:p-4 lg:pb-2
                                card glass text-gray-700 sm:max-w-sm">
                                        <figure><img src="{{ asset('storage/' . $ann->announcement_pubmat) }}"
                                                alt="prog-{{ $ann->announcement_id }}"
                                                class="object-cover w-full h-36 lg:h-64 rounded" /></figure>
                                        <div class="card-bod ">
                                            <h2 class="card-title mt-0.5 mb-2.5 text-gray-900 text-lg lg:text-2xl">
                                                {{ $ann->announcement_Title }}
                                            </h2>
                                            <p class="mb-4 text-sm lg:text-lg text-justify">
                                                {!! \Illuminate\Support\Str::limit(strip_tags($ann->announcement_Content), 150, '...') !!}
                                            </p>
                                            <a wire:navigate
                                                href="{{ route('announcement.show', ['id' => $ann->announcement_id]) }}"
                                                class="underline text-blue-500 decoration-transparent transition duration-300 ease-in-out hover:decoration-inherit">
                                                Read More</a>
                                        </div>

                                        <div class="mt-auto mb-4 py-4 pe-6 md:pe-0 lg:pe-0 flex flex-col items-end">
                                            <div class="text-gray-700 text-sm">
                                                PESO {{ $ann->peso->municipality->municipality_Name }}
                                            </div>
                                            <div class="flex items-center">

                                                <span
                                                    class="bg-neutral-300 text-gray-800 text-sm font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                                    Posted at: {{ $ann->created_at->format('M j, Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                        </div>

                    </div>
                @endif
            </div>

            <div class="mt-8 flex justify-center gap-4 lg:hidden">
                <button aria-label="Previous slide" id="keen-slider-previous"
                    class="rounded-full border border-blue-500 p-4 text-blue-500 transition hover:bg-blue-500 hover:text-white">
                    <svg class="size-5 -rotate-180 transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </button>

                <button aria-label="Next slide" id="keen-slider-next"
                    class="rounded-full border border-blue-500 p-4 text-blue-500 transition hover:bg-blue-500 hover:text-white">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

</div>
