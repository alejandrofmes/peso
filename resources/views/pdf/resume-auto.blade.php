<x-empty-layout>
    <div class="flex justify-center items-center mt-2 print:hidden">
        <button onclick="window.print()"
            class="bg-blue-200 text-blue-900 py-2 px-4 rounded shadow hover:shadow-xl hover:bg-blue-300 duration-300">Download
            This Resume</button>
    </div>

    <main class="font-jost hyphens-manual">
        <!-- Page -------------------------------------------------------------------------------------------------------->
        <section
            class="mb-4 p-3 my-auto mx-auto max-w-3xl bg-gray-100 rounded-2xl border-4 border-gray-700 sm:p-9 md:p-16 lg:mt-6 print:border-0 page print:max-w-letter print:max-h-letter print:mx-0 print:my-o xsm:p-8 print:bg-black md:max-w-letter md:h-letter lg:h-letter">
            <!-- Name ---------------------------------------------------------------------------------------------------->
            <header class="pb-2 inline-flex justify-between  mb-2 w-full align-top border-b-4 border-black">
                <section class="p-3 text-white  rounded-3xl print:bg-black">
                    <img src="{{ $employee->pimg ? asset('storage/' . $employee->pimg) : asset('https://randomuser.me/api/portraits/men/94.jpg') }}"
                        class="w-[260px] h-[180px] rounded-3xl object-cover">
                </section>

                <section class="flex flex-col w-full ml-2 justify-center ">
                    <h1 class="mt-3 mb-0 text-5xl font-bold text-gray-700">
                        {{ $employee->fname }} {{ $employee->lname }}
                    </h1>
                    <!--Location --------------------------------------------------------------------------------------------------------->

                    <h3 class="m-0 mt-2 ml-2 text-xl font-semibold text-gray-500 leading-snugish">
                        {{ $employee->barangay->municipality->municipality_Name }},
                        {{ $employee->barangay->municipality->province->province_Name }}
                    </h3>
                </section>
                <!--   Initials Block         -->

            </header>

            <!-- Column -------------------------------------------------------------------------------------------------->
            <section
                class="col-gap-8 print:col-count-2 print:h-letter-col-full col-fill-balance md:col-count-2 md:h-letter-col-full">
                <section class="flex-col">
                    <!-- Contact Information ------------------------------------------------------------------------------------->
                    <section class="pb-2 mt-4 mb-0 first:mt-0">
                        <!-- To keep in the same column -------------------------------------------------------------------------->
                        <section class="print:bg-gray-800">
                            <section class="pb-4 mb-2 border-b-4 border-black print:bg-gray-800">
                                <ul class="pr-7 list-inside">
                                    <li
                                        class="mt-1 leading-normal text-gray-500 transition duration-100 ease-in hover:text-gray-700 text-md">
                                        <a href="mailto: {{ $employee->user->email }}" class="group">
                                            <span class="mr-8 text-lg font-semibold text-gray-700 leading-snugish">
                                                Email:
                                            </span>
                                            {{ $employee->user->email }}

                                            <span
                                                class="print:hidden inline-block font-normal text-gray-500 transition duration-100 ease-in group-hover:text-gray-700 print:text-black">
                                                ↗
                                            </span>
                                        </a>
                                    </li>
                                    <li
                                        class="mt-1 leading-normal text-gray-500 transition duration-100 ease-in hover:text-gray-700 text-md">
                                        <a href="tel:+15109070654">
                                            <span class="mr-5 text-lg font-semibold text-gray-700 leading-snugish">
                                                Phone:
                                            </span>
                                            {{ $employee->pnumber }}

                                            <span
                                                class="print:hidden inline-block font-normal text-gray-500 transition duration-100 ease-in group-hover:text-gray-700 print:text-black">

                                                <svg class="w-3 h-3 font-normal text-gray-500 transition duration-100 ease-in group-hover:text-gray-700 print:text-black"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5a1.5 1.5 0 0 1-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 0 1 2.43 8.326 13.019 13.019 0 0 1 2 5V3.5Z"
                                                        clip-rule="evenodd" />
                                                </svg>

                                            </span>


                                        </a>
                                    </li>
                                </ul>
                            </section>
                        </section>
                    </section>
                    <!--Summary ---------------------------------------------------------------------------------------------------------->
                    <section class="pb-2 pb-4 mt-0 border-b-4 border-black first:mt-0">
                        <!-- To keep in the same column -->
                        <section class="print:bg-gray-800">
                            <h2 class="mb-2 text-2xl font-bold tracking-widest text-gray-700 print:font-normal">
                                SUMMARY
                            </h2>
                            @if ($employee->empDesc)
                                <section class="mb-2 print:bg-gray-800">
                                    <p class="mt-2 leading-normal text-gray-700 text-md">
                                        {{ $employee->empDesc }}
                                    </p>
                                </section>
                            @endif
                        </section>
                    </section>
                    @if ($employee->education)
                        <!--Education -------------------------------------------------------------------------------------------------------->
                        <section class="pb-0 mt-2 border-b-4 border-black first:mt-0 print:bg-gray-800">
                            <!-- To keep in the same column -->
                            <section class="print:bg-gray-800">
                                <h2 class="mb-2 text-2xl font-bold tracking-widest text-gray-700 print:font-normal">
                                    EDUCATION
                                </h2>
                                @foreach ($employee->education as $data)
                                    <!-- school --------------------------------------------------------------------------->
                                    <section class="mt-2 border-b-2 print:bg-gray-800 ">
                                        <header class="space-y-1">
                                            <h3 class="text-xl font-semibold text-gray-700 leading-snugish uppercase">
                                                {{ $data->edu_School }}

                                            </h3>
                                            <p class="font-medium text-gray-600 text-md uppercase">
                                                {{ $eduLevels[$data->edu_Level] }} |
                                                {{ $data->edu_Course }}

                                            </p>
                                            <p class="leading-normal text-gray-500 text-md uppercase">
                                                {{ $data->edu_Started->format('F Y') }} &ndash;
                                                {{ $data->edu_Ongoing == 1 ? 'Present' : $data->edu_Ended->format('F Y') }}

                                            </p>
                                        </header>

                                    </section>
                                @endforeach
                                <!--school 2--------------------------------------------------------------------------------------------->

                            </section>
                        </section>
                    @endif

                    <!--Begin Skills ----------------------------------------------------------------------------------------------------->
                    @if (!empty($employee->work_exp) && count($employee->work_exp) > 0)

                        <!--Experience ------------------------------------------------------------------------------------------------------>
                        <section class="pb-2 pb-4 mt-4 border-b-4 border-black first:mt-0">
                            <!-- To keep in the same column ------------------------------------------------------------------------->
                            <section class="print:bg-gray-800">
                                <h2 class="mb-2 text-2xl font-black tracking-widest text-gray-800 print:font-normal">
                                    EXPERIENCE
                                </h2>
                                <!--Job 1-->
                                @foreach ($employee->work_exp as $data)
                                    <section class="mb-4 border-b-2 border-gray-300 print:bg-gray-800">
                                        <header class="space-y-1">
                                            <h3 class="font-semibold text-gray-800 text-xl leading-snugish uppercase">
                                                {{ $data->work_Name }}

                                            </h3>
                                            <p class="font-medium text-gray-600 text-md uppercase">
                                                {{ $data->job_positions->position_Title }}
                                            </p>
                                            <p class="text-md leading-normal text-gray-500 uppercase">
                                                {{ $data->work_Start->format('F Y') }} -
                                                @if ($data->work_End)
                                                    {{ $data->work_End->format('F Y') }}
                                                @else
                                                    Present
                                                @endif
                                            </p>
                                        </header>

                                    </section>
                                @endforeach

                            </section>
                        </section>
                    @endif

                    @if (!empty($employee->training) && count($employee->training) > 0)
                        <!--TRAININGS ------------------------------------------------------------------------------------------------------>
                        <section class="pb-2 pb-4 mt-4 border-b-4 border-black first:mt-0">
                            <!-- To keep in the same column ------------------------------------------------------------------------->
                            <section class="print:bg-gray-800">
                                <h2 class="mb-2 text-2xl font-black tracking-widest text-gray-800 print:font-normal">
                                    TRAININGS
                                </h2>
                                <!--Job 1-->
                                @foreach ($employee->training as $data)
                                    <section class="mb-4 border-b-2 border-gray-300 print:bg-gray-800">
                                        <header class="space-y-1">
                                            <h3 class="font-semibold text-gray-800 text-xl leading-snugish uppercase">
                                                {{ $data->training_Name }}

                                            </h3>
                                            <p class="font-medium text-gray-600 text-md uppercase">
                                                {{ $data->training_From }}
                                            </p>
                                            <p class="text-md leading-normal text-gray-500 uppercase">
                                                {{ $data->training_Start->format('F Y') }} -
                                                @if ($data->training_End)
                                                    {{ $data->training_End->format('F Y') }}
                                                @else
                                                    Present
                                                @endif
                                            </p>
                                        </header>

                                    </section>
                                @endforeach

                            </section>
                        </section>
                    @endif

                    @if (!empty($employee->certificate) && count($employee->certificate) > 0)
                        <!--CERTIFICATES ------------------------------------------------------------------------------------------------------>
                        <section class="pb-2 pb-4 mt-4 border-b-4 border-black first:mt-0">
                            <!-- To keep in the same column ------------------------------------------------------------------------->
                            <section class="print:bg-gray-800">
                                <h2 class="mb-2 text-2xl font-black tracking-widest text-gray-800 print:font-normal">
                                    CERTIFICATES
                                </h2>
                                <!--Job 1-->
                                @foreach ($employee->certificate as $data)
                                    <section class="mb-4 border-b-2 border-gray-300 print:bg-gray-800">
                                        <header class="space-y-1">
                                            <h3 class="font-semibold text-gray-800 text-xl leading-snugish uppercase">
                                                {{ $data->certificateType->cert_Name }}
                                            </h3>
                                            <p class="font-medium text-gray-600 text-md uppercase">
                                                {{ $data->cert_From }}
                                            </p>
                                            <p class="text-md leading-normal text-gray-500 uppercase">
                                                {{ $data->cert_Date_Issued->format('F Y') }}
                                                | {{ $data->cert_Rating }} Rating
                                            </p>
                                        </header>

                                    </section>
                                @endforeach

                            </section>
                        </section>
                    @endif

                    @if (!empty($employee->skills) && count($employee->skills) > 0)
                        <section class="pb-6 mt-0 mb-4 border-b-4 border-black first:mt-0">
                            <!-- To keep in the same column -->
                            <section class="">
                                <h2 class="mb-2 text-2xl font-bold tracking-widest text-gray-700 print:font-normal">
                                    SKILLS
                                </h2>
                                <section class="mb-0">
                                    <section class="mt-1 last:pb-1 print:bg-black">
                                        <ul
                                            class="flex flex-wrap -mb-1 font-bold leading-relaxed text-md -mr-1.6 uppercase">
                                            @foreach ($employee->skills as $data)
                                                <li
                                                    class="p-1.5 mb-1 leading-relaxed text-white bg-gray-800 mr-1.6 print:bg-black print:border-inset">
                                                    {{ $data->skill_Type }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </section>
                                </section>
                            </section>
                        </section>
                    @endif

                    <!-- end Column -->
                </section>
                <!-- end Page -->
    </main>

</x-empty-layout>
<div class="flex justify-center items-center mt-4 print:hidden border border-gray-300 p-2 bg-gray-100 w-full">
    <h1 class="text-sm font-medium text-gray-700">This is an auto-generated resume.</h1>
</div>
