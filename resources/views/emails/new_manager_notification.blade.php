<x-mail::message>
# Hello, {{ $employeeName }},

We are pleased to inform you that you have been assigned as the PESO Manager for the municipality of **{{ $municipality }}**.

@if ($type == 1)
## Your Account Details:
- **Email:** {{ $email }}
- **Password:** {{ $password }}

Please use the above credentials to log in to your account. We strongly recommend changing your password after your first login for enhanced security.

## Verify Your Email Address
To complete the setup of your account, please verify your email address by clicking the button below:

<x-mail::button :url="$verificationUrl">
Verify Email Address
</x-mail::button>

@else
You are already registered on the platform. You can now log in using your existing credentials and manage your PESO branch.

@endif

If you have any questions or need assistance, please do not hesitate to contact our support team.

Thank you,<br>
{{ config('app.name') }}
</x-mail::message>
