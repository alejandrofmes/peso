<x-mail::message>
# Job Application Canceled: {{ $jobTitle }}

Dear {{ $applicantName }},

This is to inform you that your application for the job posting titled **"{{ $jobTitle }}"**, which was listed by **{{ $companyName }}**, has been officially cancelled. The reason for this cancellation is the deactivation of the company's account on our platform.

## Important Information:
- **Job Post Title:** {{ $jobTitle }}
- **Company:** {{ $companyName }}
- **Status:** Application Canceled

As the company's account is no longer active, the job posting and all related applications have been canceled. We appreciate your interest in this position and encourage you to continue exploring other opportunities available on our platform.

If you have any questions or require further assistance, please contact us.

Thank you for your attention to this matter.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
