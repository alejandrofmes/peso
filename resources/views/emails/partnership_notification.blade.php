<x-mail::message>
# Hello {{ $companyName }},

We are pleased to inform you about the current status of your partnership application with PESO {{ $PESO }}.

**Status:** {{ $applicationStatus }}

@if($applicationStatus === 'APPROVED')
Congratulations! Your partnership application with PESO {{ $PESO }} has been approved. We are excited to collaborate with you to enhance job opportunities in our community. Below are the remarks from PESO {{ $PESO }} regarding your application:

## PESO Remarks
<div style="border-left: 4px solid #28A745; padding-left: 20px; margin-top: 20px; background-color: #E9F7EF; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
<p style="font-size: 16px; color: #333; line-height: 1.5;">
{{ $pesoRemarks }}
</p>
</div>

We look forward to a successful partnership with your esteemed company. Together, we can create meaningful employment opportunities for the community.

@endif

@if($applicationStatus === 'REJECTED')
We regret to inform you that your partnership application with PESO {{ $PESO }} has been declined. Please see the remarks from PESO {{ $PESO }} below for more details:

## PESO Remarks
<div style="border-left: 4px solid #DC3545; padding-left: 20px; margin-top: 20px; background-color: #FDECEA; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
<p style="font-size: 16px; color: #555; line-height: 1.5;">
{{ $pesoRemarks }}
</p>
</div>

We encourage you to review the remarks and consider re-applying in the future with any necessary adjustments to your application.

@endif

Thank you for your interest in partnering with PESO. If you have any questions or require further assistance, please do not hesitate to contact us.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
