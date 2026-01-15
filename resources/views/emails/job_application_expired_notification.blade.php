<x-mail::message>
# Job Application Status Update

Dear {{ $applicantName }},

We hope this message finds you well. We regret to inform you that the job posting for **"{{ $jobTitle }}"** has been closed, and your application has been marked as **rejected**.

## Important Information:
- **Job Post Title:** {{ $jobTitle }}
- **Application Status:** Rejected
- **Closing Date:** {{ $closingDate }}

We appreciate the time and effort you invested in applying for this position. Unfortunately, the job posting is no longer active, and we are unable to proceed with your application.

We encourage you to keep an eye on future job opportunities that may align with your skills and interests. If you have any questions or need further information, please feel free to contact us.

Thank you for considering opportunities with us.

Best regards,<br>
{{ config('app.name') }}
</x-mail::message>
