<x-mail::message>
# Job Post Closed: {{ $jobTitle }}

Dear {{ $companyName }},

We hope this message finds you well. We are writing to inform you that your job post titled **"{{ $jobTitle }}"**, which was listed in **{{ $PESO }}**, has reached its application deadline and has now been automatically closed.

## Important Information:
- **Job Post Title:** {{ $jobTitle }}
- **Application Deadline:** {{ $jobDeadline }}
- **Municipality:** {{ $PESO }}
- **Current Status:** Closed

Please be reminded that you have **three weeks** from the date of this email to finalize and complete any remaining transactions, such as interviews or hiring decisions, related to this job post. After this period, the job post will be marked as **completed**.

We encourage you to ensure that all necessary actions are taken within this timeframe to avoid any inconvenience. If you have any questions or need further assistance, please contact us.

Thank you for choosing our platform, and we look forward to supporting your future job postings.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
