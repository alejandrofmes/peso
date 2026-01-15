<x-mail::message>
# Hello {{ $employerName }},

We are pleased to inform you about the current status of your job posting request for the position of **{{ $jobTitle }}** at PESO {{ $PESO }}.

**Status:** {{ $applicationStatus }}

@if($applicationStatus === 'PENDING')
Thank you for submitting your job posting request to PESO. Your request has been successfully received and is currently under review. Please wait for our team to process your request. We will notify you once it has been reviewed.

@endif

@if($applicationStatus === 'ACTIVE')
Good news! Your job posting request has been approved and is now active on the PESO platform. Please see the remarks from PESO below for further information:

## PESO Remarks
<div style="border-left: 4px solid #28A745; padding-left: 20px; margin-top: 20px; background-color: #E9F7EF; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
<p style="font-size: 16px; color: #333; line-height: 1.5;">
{{ $pesoRemarks }}
</p>
</div>

Your job posting is now visible to job seekers. We wish you success in finding the right candidates!

@endif

@if($applicationStatus === 'REJECTED')
We regret to inform you that your job posting request has been rejected. Please see the remarks from PESO below for more details:

## PESO Remarks
<div style="border-left: 4px solid #DC3545; padding-left: 20px; margin-top: 20px; background-color: #FDECEA; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
<p style="font-size: 16px; color: #555; line-height: 1.5;">
{{ $pesoRemarks }}
</p>
</div>

We encourage you to review the remarks and consider re-submitting your job posting request with any necessary adjustments.

@endif

Thank you for using the PESO platform to connect with potential candidates. If you have any questions or require further assistance, please do not hesitate to contact us.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
