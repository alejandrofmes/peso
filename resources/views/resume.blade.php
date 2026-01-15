<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PESO') }}</title>
</head>

<body>
    <style>
        body,
        main {
            font-family: Jost, sans-serif;
            hyphens: manual;
        }

        .section-container {
            padding: 3rem;
            /* max-width: 48rem; */
            /* background-color: #f3f4f6;
            border-radius: 1rem;
            border: 4px solid #374151; */
        }

        .header-section,
        .contact-section,
        .summary-section,
        .education-section,
        .skills-section,
        .experience-section,
        .trainings-section,
        .certifications-section {
            width: 100%;

            margin-bottom: 1rem;
            border-bottom: 4px solid #d1d5db;
        }

        .header-section {
            padding-bottom: 0.5rem;
            display: inline-flex;
            justify-content: space-between;
            align-items: top;
        }

        /* .header-section img {
            width: 220px;
            height: 150px;
            border-radius: 1rem;
        } */

        .header-section h1 {
            font-size: 3rem;
            font-weight: bold;
            color: #374151;
        }

        .header-section h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #6b7280;
            line-height: 1.5;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: bold;
            letter-spacing: 0.1em;
            color: #374151;
        }

        .section-content {
            font-size: 1rem;
            color: #4b5563;
        }

        .skills-section {
            display: inline-block;
            /* Change to inline-block */
        }

        .skills-list {
            display: inline-block;
            /* Change to inline-block */
            padding: 0;
            list-style-type: none;
            gap: 0.5rem;
        }

        .skills-list li {
            display: inline-block;
            /* Change to inline-block */
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #4b5563;
            border-radius: 0.375rem;
            background-color: #d1d5db;
            margin-right: 0.5rem;
            /* Add margin between list items */
            margin-bottom: 0.5rem;
            /* Add margin between rows */
        }


        @media print {
            .section-container {
                border: 0;
                max-width: 8.5in;
                max-height: 11in;
                background-color: #ffffff;
            }

            .header-section {
                page-break-after: avoid;
            }

            .contact-section,
            .summary-section,
            .education-section,
            .skills-section,
            .experience-section,
            .trainings-section,
            .certifications-section {
                page-break-inside: avoid;
            }

            .skills-list {
                column-count: 6;
                column-fill: balance;
            }

            .skills-list li {
                background-color: #e5e7eb;
                border: 1px solid #374151;
                color: #000000;
            }
        }
    </style>
    <main>
        <section class="section-container">
            {{-- <header class="header-section" style="display: flex; justify-content: center; align-items: center;">
                <section style="padding: 1rem; text-align: center;">
                    <img src="{{ public_path('storage/' . $employee->pimg) }}" alt="Employee Image"
                        style="margin-top: 0.5rem; width: 240px; height: 160px; object-fit: cover; border-radius: 8px;">
                </section>
                <section style="text-align: left; margin-left: 1rem;">
                    <h1 style="margin: 0; font-size: 2.5rem; font-weight: bold; color: #374151;">
                        {{ $employee->fname }} {{ $employee->lname }}
                    </h1>
                    <h3 style="margin: 0.5rem 0 0; font-size: 1.25rem; font-weight: 600; color: #6b7280;">
                        San {{ $employee->barangay->municipality->municipality_Name }},
                        {{ $employee->barangay->municipality->province->province_Name }}
                    </h3>
                </section>
            </header> --}}


            <header class="header-section" style="display: flex; align-items: center;">
                <section style="display: inline-flex;">
                    <img src="{{ public_path('storage/' . $employee->pimg) }}" alt="Employee Image"
                        style="width: 240px; height: 160px; object-fit: cover; border-radius: 8px;">
                </section>
                <section style="display: inline-flex; flex: 1; margin-left: 1rem;">
                    <h1 style="margin: 0.75rem 0 0; font-size: 2.5rem; font-weight: bold; color: #374151;">
                        {{ $employee->fname }} {{ $employee->lname }}
                    </h1>
                    <h3 style="margin: 0.5rem 0 0; font-size: 1.25rem; font-weight: 600; color: #6b7280;">{{ $employee->barangay->municipality->municipality_Name }},
                        {{ $employee->barangay->municipality->province->province_Name }}
                    </h3>
                </section>
            </header>


            <section class="contact-section">
                <ul style="padding-right: 1.75rem; list-style-type: none; padding-left: 0;">
                    <li style="margin-top: 0.25rem; line-height: 1.5;">
                        <a href="https://veilmail.io/e/J-td7W" style="text-decoration: none;">
                            <span style="font-size: 1.125rem; font-weight: 600; color: black;">Email:</span>
                            {{ $employee->user->email }}
                        </a>
                    </li>
                    <li style="margin-top: 0.25rem; line-height: 1.5;">
                        <a href="tel:+15109070654" style="text-decoration: none;">
                            <span style="font-size: 1.125rem; font-weight: 600; color: black;">Phone:</span>
                            {{ $employee->pnumber }}
                        </a>
                    </li>
                </ul>
            </section>

            @if ($employee->empDesc)
                <section class="summary-section">
                    <h2 class="section-title">About Me</h2>
                    <p class="section-content" style="text-align: justify;">{{ $employee->empDesc }}</p>
                </section>
            @endif

            <section class="education-section">
                <h2 class="section-title">EDUCATION</h2>
                @foreach ($employee->education as $data)
                    <section style="border-bottom: 1px solid #d1d5db;">

                        <p style="font-size: 1rem; margin-bottom: 0.25rem; line-height: 1.5;">
                            <span
                                style="margin-bottom: 50px; font-size: 1.125rem; font-weight: 600; color: black; margin-bottom: 0.25rem;">
                                {{ $data->edu_School }}
                            </span> <br>
                            <span style="font-size: 1rem; color: black; font-weight: 400;">
                                {{ $data->edu_Level }}<br>
                                {{ $data->edu_Course }} |
                                {{ $data->edu_Started->format('F j, Y') }} &ndash;
                                {{ $data->edu_Ongoing == 1 ? 'Present' : $data->edu_Ended->format('F j, Y') }}
                            </span>
                        </p>
                    </section>
                @endforeach
            </section>


            <section class="experience-section">
                <h2 class="section-title">EXPERIENCE</h2>
                @foreach ($employee->work_exp as $data)
                    <section style="border-bottom: 1px solid #d1d5db;">

                        <p style="font-size: 1rem; margin-bottom: 0; line-height: 1.5;">
                            <span style="font-size: 1.5rem; font-weight: 600; color: black;">
                                {{ $data->job_positions->position_Title }}
                            </span> <br>
                            {{ $data->work_Name }}
                            <span style="display: block; font-size: 1rem; font-weight: 400; color: black;">
                                {{ $data->work_Start->format('F j, Y') }} - {{ $data->work_End->format('F j, Y') }}
                            </span>
                            <span style="display: block; font-size: 1rem; font-weight: 400; color: black;">
                                {{ $data->work_Address }}
                            </span>
                        </p>
                    </section>
                @endforeach
            </section>

            <section class="trainings-section">
                <h2 class="section-title">TRAININGS</h2>
                @foreach ($employee->training as $data)
                    <section style="border-bottom: 1px solid #d1d5db;">

                        <p style="font-size: 1.25rem; margin-bottom: 0; line-height: 1.5;">
                            <span style="font-size: 1.5rem; font-weight: 600; color: black;">
                                {{ $data->training_Name }}
                            </span> <br>
                            {{ $data->training_From }}
                            <span style="display: block; font-size: 1rem; font-weight: 400; color: black;">
                                J{{ $data->training_Cert }}
                            </span>
                            <span style="display: block; font-size: 1rem; font-weight: 400; color: black;">
                                {{ $data->training_Start->format('F j, Y') }} -
                                {{ $data->training_End->format('F j, Y') }}
                            </span>
                        </p>
                    </section>
                @endforeach
            </section>

            <section class="certifications-section">
                <h2 class="section-title">CERTIFICATIONS</h2>
                @foreach ($employee->certificate as $data)
                    <section style="border-bottom: 1px solid #d1d5db;;">

                        <p style="font-size: 1.25rem; margin-bottom: 0;  line-height: 1.5">
                            <span style="font-size: 1.5rem; font-weight: 600; color: black;">
                                {{ $data->certificateType->cert_Name }}
                            </span>
                            <br>
                            {{ $data->cert_From }}
                            <span style="display: block; font-size: 1rem; font-weight: 400; color: black;">
                                {{ $data->cert_Date_Issued->format('F j, Y') }} | {{ $data->cert_Rating }}
                            </span>
                        </p>
                    </section>
                @endforeach
            </section>

            <section class="skills-section">
                <h2 class="section-title">SKILLS</h2>
                <ul class="skills-list">
                    @foreach ($employee->skills as $data)
                        <li>{{ $data->skill_Type }}</li>
                    @endforeach
                </ul>
            </section>

        </section>
    </main>
</body>

</html>
