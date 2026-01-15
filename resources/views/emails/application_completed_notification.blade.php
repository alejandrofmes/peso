<x-mail::message>
# Hello {{ $jobseekerName }},

We wanted to inform you that the job application process for the position of **{{ $jobTitle }}** at **{{ $companyName }}** has been marked as completed.

**Application Status:** Completed

**Details:**
- **Position Applied For:** {{ $jobTitle }}
- **Company:** {{ $companyName }}


We appreciate your interest in this position and the time you took to apply. While your application process has concluded, we encourage you to continue exploring other opportunities available on our platform that match your skills and career goals.

Thank you for considering the PESO platform for your job search. If you have any questions or need further assistance, please do not hesitate to reach out.

Wishing you the best of luck in your job search and future endeavors.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
