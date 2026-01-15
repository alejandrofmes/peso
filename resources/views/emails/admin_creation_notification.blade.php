j<x-mail::message>
# Hello, {{ $employeeName }}

We are pleased to inform you that your account has been created successfully.

## Your Account Details:
- **Email:** {{ $email }}
- **Password:** {{ $password }}

Please use the above password to log in to your account. We strongly recommend changing your password after your first login for security reasons.

## Verify Your Email Address
To complete the setup of your account, please verify your email address by clicking the button below:

<x-mail::button :url="$verificationUrl">
Verify Email Address
</x-mail::button>

If you encounter any issues or have any questions, please don't hesitate to contact our support team.

Thank you,<br>
{{ config('app.name') }}



</x-mail::message>
