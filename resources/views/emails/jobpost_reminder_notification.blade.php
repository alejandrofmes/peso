<x-mail::message>
# Action Required: Pending Applications for Closed Job Post - {{ $jobTitle }}

Dear {{ $companyName }},

We hope this message finds you well. We are reaching out to inform you that your job post titled **"{{ $jobTitle }}"**, which has been closed, still has pending applications that require your attention.

## Important Details:
- **Job Post Title:** {{ $jobTitle }}
- **Application Deadline:** {{ $jobDeadline }}
- **Municipality:** {{ $PESO }}
- **Current Status:** Closed

### Action Required:

You have **18 days** from the date of this email to review and finalize all pending job applications for this closed job posting. Please take the necessary steps to either hire or reject the pending applicants.

**After 18 days:**
- The job post will be marked as **completed**.
- All pending applications that have not been addressed will be automatically marked as **rejected**.

We urge you to complete the necessary actions within this timeframe to ensure all applicants are properly processed. If you have any questions or need assistance, please do not hesitate to reach out.

Thank you for your attention to this matter, and for using our platform.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
