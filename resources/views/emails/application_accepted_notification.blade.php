<x-mail::message>
# Hello {{ $employerName }},

We are pleased to inform you that **{{ $jobseekerName }}** has officially accepted the job offer for the position of **{{ $jobTitle }}**.

**Acceptance Details:**

- **Jobseeker Name:** {{ $jobseekerName }}
- **Position:** {{ $jobTitle }}
- **Jobseeker Email:** {{ $jobseekerEmail }}

We are confident that **{{ $jobseekerName }}** will be a great addition to your team and contribute positively to your organization. 

Thank you for using the PESO platform to manage your hiring process. Should you have any further questions or need additional assistance, please feel free to reach out.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
