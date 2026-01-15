<x-mail::message>
# Dear User,

@if ($emailType === 'deactivation')
We want to inform you that your account has been deactivated by an administrator. As a result, you currently do not have access to our services.

## 🚨 Important Information
**Reason for Deactivation:** Admin Deactivation

Please be aware that all your active transactions have also been cancelled as part of this deactivation process.

If you have any questions regarding this deactivation or if you believe this action was taken in error, please contact your local PESO office or our support team for assistance.

We understand that there may be concerns or questions, and we are here to assist you. Please do not hesitate to reach out to us for further support.
@elseif ($emailType === 'reactivation')
We are pleased to inform you that your account has been reactivated by an administrator. You now have access to our services.

## 🚀 Important Information
**Reason for Reactivation:** Admin Reactivation

If you have any questions or need further assistance, please contact your local PESO office or our support team.

We’re happy to have you back and are here to support you in any way we can. Please do not hesitate to reach out to us for any further assistance.
@endif

Thank you for your attention to this matter.

Best regards,  
{{ config('app.name') }}
</x-mail::message>
