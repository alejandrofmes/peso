<x-mail::message>
# Hello, {{ $userName }}

Your account password has been successfully reset by an administrator.

## 🔒 Your New Password
**Password:** `{{ $newPassword }}`

Please use the above password to log in to your account. For security reasons, we strongly recommend that you change your password immediately after your first login.

If you did not request this change, please contact our support team **immediately**.

Thank you for your attention to this matter.

Best regards,  
{{ config('app.name') }}
</x-mail::message>
