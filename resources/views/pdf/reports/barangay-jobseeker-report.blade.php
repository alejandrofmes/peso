<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<style>
    @media print {
        body {
            -webkit-print-color-adjust: exact !important;
            /* Chrome, Safari 6 – 15.3, Edge */
            color-adjust: exact !important;
            /* Firefox 48 – 96 */
            print-color-adjust: exact !important;
            /* Firefox 97+, Safari 15.4+ */
        }

        div.paper[data-size="A4"] {
            margin: 0;
            box-shadow: 0;
            -webkit-column-break-inside: avoid;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        div.pagebreak {
            break-after: page;
        }

        header,
        .header-space {
            height: 3cm;
        }

        footer,
        .footer-space {
            height: 3cm;
        }

        header {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translate(-50%, 0);

            width: 100%;

            margin: 0 auto;
            display: flex;
            justify-content: center;

        }

        footer {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translate(-50%, 0);

            display: flex;
            justify-content: center;
            width: 100%;


        }
    }
</style>

<body>



    <table class="m-6">
        <thead>
            <tr>
                <td>
                    <div class="header-space">&nbsp;</div>
                </td>
            </tr>
        </thead>
        <thead>
            <tr>
                <td colspan="5">
                    <div class="flex flex-col mx-2 gap-2 pb-0 mb-4">
                        <div
                            class="flex flex-col h-1/3 w-full bg-stone-300 border border-solid rounded-sm border-gray-500  shadow-md p-5">

                            <div class="flex flex-row w-full justify-between">
                                <span class="text-blue-500 text-xl font-bold">
                                    {{ $peso['barangay'] }} JOBSEEKERS
                                </span>
                                <span class="text-md font-medium">
                                    {{ now()->format('F j, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </thead>
        <thead>
            <tr class="bg-blue-300 text-gray-600 text-left font-semibold text-sm">
                <th class="py-3 px-4 border-b w-1/3">Full Name</th>
                <th class="py-3 px-4 border-b w-1/6 text-center">Gender</th>
                <th class="py-3 px-4 border-b w-1/6 text-center">Status</th>
                <th class="py-3 px-4 border-b w-1/12 text-center">Applications</th>
                <th class="py-3 px-4 border-b w-1/12 text-center">Trainings</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $data)
                <tr class="border-b">
                    <td class="px-6 py-4 text-start font-normal text-gray-700 text-sm uppercase">
                        {{ $data['name'] }}
                    </td>
                    <td class="px-4 py-4 text-center font-normal text-gray-500 text-sm uppercase">
                        @if ($data['gender'] == '2')
                            Female
                        @elseif ($data['gender'] == '1')
                            Male
                        @endif
                    </td>
                    <td class="px-4 py-4 text-center font-normal text-gray-500 text-sm uppercase">
                        @if ($data['empStat'] == '2')
                            Unemployed
                        @elseif ($data['empStat'] == '1')
                            Employed
                        @endif
                    </td>
                    <td class="px-4 py-4 text-center font-normal text-gray-500 text-sm">
                        {{ $data['activeApplicationsCount'] }}
                    </td>
                    <td class="px-4 py-4 text-center font-normal text-gray-500 text-sm">
                        {{ $data['programRegCount'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="footer-space ">&nbsp;</div>
                </td>
            </tr>
        </tfoot>
    </table>




    <header>
        <div class="flex flex-col h-14 w-full">
            <!-- Container with border, background color, and fixed height -->
            <div class="flex flex-row gap-4 w-full border-solid border-b-2 border-gray-300">
                <div class="h-20 flex w-20 mr-3 ml-6 justify-center pt-2 rounded-full">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/PESO-Logo.png'))) }}"
                        alt="Logo" class="mb-2 object-cover" style="opacity: 0.5;">
                </div>

                <div
                    class="h-full flex flex-grow gap-y-1 flex-col border-solid border-l-2 border-gray-300 p-4 pb-2 pt-2">
                    <div class="text-lg font-bold tracking-widest uppercase text-gray-400">
                        PUBLIC EMPLOYMENT SERVICES OFFICE
                    </div>

                    @if ($peso['pesoMunicipality'])
                        <div class="text-sm font-semibold uppercase tracking-wider text-gray-400">
                            MUNICIPALITY OF {{ $peso['pesoMunicipality'] ?? 'Municipality Name' }}

                        </div>
                    @endif

                    <div class="text-sm font-semibold tracking-widest capitalize text-gray-400">
                        PROVINCE OF {{ $peso['pesoProvince'] ?? 'Province Name' }}
                    </div>
                </div>
            </div>
        </div>
    </header>

    <footer>
        <div class="flex flex-col w-full h-20">
            <div class="flex flex-row gap-x-3 w-full border-solid border-t-2 border-gray-300">
                <!-- Left Column for Municipality Name -->
                <div class="h-full flex flex-col w-3/5 gap-y-3 p-2 pb-1 border-solid border-r-2 border-gray-300">
                    @if ($peso['pesoMunicipality'])
                        <div class="text-sm font-bold uppercase tracking-wide text-gray-400">
                            Municipality of {{ $peso['pesoMunicipality'] ?? 'Municipality Name' }}
                        </div>
                    @elseif($peso['pesoProvince'])
                        <div class="text-sm font-bold uppercase tracking-wide text-gray-400">
                            PROVINCE OF {{ $peso['pesoProvince'] ?? 'Province Name' }}
                        </div>
                    @endif
                    <div class="flex flex-col text-sm font-medium text-gray-400">
                        <div class="w-full uppercase">
                            PUBLIC EMPLOYMENT SERVICES OFFICE
                        </div>

                        @if ($peso['pesoEmail'])
                            <div class="w-full mt-2">
                                Email Address: {{ $peso['pesoEmail'] }}
                            </div>
                        @endif

                    </div>
                </div>

                <!-- Right Column for Contact Info -->
                <div class="h-full flex flex-row p-2 pb-1 justify-start">
                    <div class="flex flex-col gap-y-2 mb-1 mt-auto text-sm font-medium text-gray-400">
                        @if ($peso['pesoPhone'])
                            <div class="w-full">
                                Phone Number: {{ $peso['pesoPhone'] }}
                            </div>
                        @endif
                        @if ($peso['pesoTel'])
                            <div class="w-full">
                                Telephone Number: {{ $peso['pesoTel'] }}
                            </div>
                        @endif
                        @if ($peso['pesoFax'])
                            <div class="w-full">
                                FAX Number: {{ $peso['pesoFax'] }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </footer>





</body>

</html>
