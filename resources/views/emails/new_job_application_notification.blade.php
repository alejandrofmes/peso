<x-mail::message>
# Hello {{ $employeeName }},

We are pleased to inform you that your application for the position of **{{ $jobTitle }}** at **{{ $companyName }}** has been successfully submitted.

Your application is now being reviewed by the PESO team. We will carefully evaluate your application and provide a recommendation to the employer.

You will be notified of any updates or next steps as soon as they become available.

Thank you for your interest in this opportunity. If you have any questions or need further assistance, please feel free to contact us.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>