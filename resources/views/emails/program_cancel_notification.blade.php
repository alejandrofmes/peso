<x-mail::message>
# Hello {{ $employeeName }},

We regret to inform you that the upcoming training program, **{{ $programTitle }}**, which was scheduled to be offered by **{{ $providerName }}** at **{{ $programLocation }}**, has unfortunately been **cancelled**.

We understand this may be disappointing, and we apologize for any inconvenience this may cause. If you had already registered for the program, rest assured that no further action is needed on your part.

If you have any questions or need assistance, feel free to reach out to us.

Thank you for your understanding.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
