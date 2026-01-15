<x-mail::message>
Dear {{ $companyName }},

We are writing to inform you that your job posting titled **"{{ $jobTitle }}"** has been successfully marked as **completed**.

## Important Information:
- **Job Post Title:** {{ $jobTitle }}
- **Completion Date:** {{ $completionDate }}
- **Municipality:** {{ $PESO }}

Please note that, as part of the completion process, all remaining job applicants for this position have been automatically marked as **rejected**.

If you need any further assistance or have any questions regarding this update, please do not hesitate to reach out to our support team.

Thank you for using our platform for your hiring needs.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
