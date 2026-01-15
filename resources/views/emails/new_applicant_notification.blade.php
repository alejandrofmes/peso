<x-mail::message>
# Hello {{ $employerName }},

We are excited to inform you that a new applicant has applied to your job posting for the position of **{{ $jobTitle }}**.

**Applicant Details:**
- **Name:** {{ $applicantName }}
- **Email:** {{ $applicantEmail }}
- **Phone:** {{ $applicantPhone }}

You can review the applicant's details and their application by logging into your dashboard. Please make sure to check their resume and qualifications to proceed with the next steps in the hiring process.

Thank you for using the PESO platform. If you have any questions or need further assistance, please do not hesitate to reach out to us.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
