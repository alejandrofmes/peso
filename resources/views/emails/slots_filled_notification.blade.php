<x-mail::message>
# Hello {{ $employerName }},

We would like to inform you that all available slots for the job position of **{{ $jobTitle }}** have been filled.

**Status:** Job Posting Completed

Your job posting has now been completed. You can view an overview of the job posting and the applications received in your job post dashboard. 

Thank you for using the PESO platform to manage your job postings. We appreciate your prompt attention to this matter and wish you success in reviewing the applications.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
