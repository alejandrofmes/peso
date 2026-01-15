<x-mail::message>
# Job Posting Canceled: {{ $jobTitle }}

Dear {{ $employerName }},

We are writing to inform you that your job posting for the position of **"{{ $jobTitle }}"** at PESO {{ $PESO }} has been **canceled**.

## Status: Canceled

Below are the remarks from PESO {{ $PESO }} regarding the cancellation of your job posting:

<div style="border-left: 4px solid #FFC107; padding-left: 20px; margin-top: 20px; background-color: #FFF8E1; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
<p style="font-size: 16px; color: #333; line-height: 1.5;">
{{ $pesoRemarks }}
</p>
</div>

Additionally, please be advised that all **pending applicants** for this job posting will also have their applications **marked as cancelled**.

We understand that this news may be disappointing. If you have any questions or would like further clarification regarding this cancellation, please do not hesitate to reach out to us.

Thank you for your understanding and for using the PESO platform. We hope to continue assisting you with future job postings.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
