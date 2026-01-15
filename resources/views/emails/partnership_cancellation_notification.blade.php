<x-mail::message>
# Hello {{ $companyName }},

We regret to inform you that your partnership with PESO {{ $PESO }} has been canceled. This decision has been made after careful consideration, and we want to ensure you are informed about the reasons behind this action.

## Cancellation Details

**Status:** Canceled

Below are the remarks from PESO {{ $PESO }} regarding the cancellation of your partnership:

<div style="border-left: 4px solid #FFC107; padding-left: 20px; margin-top: 20px; background-color: #FFF8E1; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
<p style="font-size: 16px; color: #333; line-height: 1.5;">
{{ $pesoRemarks }}
</p>
</div>

**Important Notice:**

As a result of this cancellation, all active job postings associated with PESO {{ $PESO }} in the current municipality will also be marked as cancelled. Additionally, any job applications submitted for these postings will be cancelled.

We understand that this news may be disappointing. If you have any questions or require further clarification regarding this decision, please feel free to contact us.

We appreciate your interest in collaborating with PESO and thank you for your understanding.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
