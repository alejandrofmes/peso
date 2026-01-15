<x-mail::message>
# Job Application Status Update

Dear {{ $applicantName }},

We hope this message finds you well. We regret to inform you that the job posting for **"{{ $jobTitle }}"** has been cancelled, and as a result, your application has also been canceled.

## Important Information:
- **Job Post Title:** {{ $jobTitle }}
- **Application Status:** Canceled
- **Cancellation Date:** {{ $closingDate }}

We appreciate the time and effort you invested in applying for this position. Unfortunately, due to the cancellation of the job posting, we are unable to move forward with your application.

We encourage you to explore other opportunities that may align with your skills and interests. If you have any questions or need further information, please feel free to contact us.

Thank you for considering opportunities with us.

Best regards,<br>
{{ config('app.name') }} 
</x-mail::message>
