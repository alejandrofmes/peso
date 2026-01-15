<x-mail::message>
# Hi {{ $employeeName }},

We’re thrilled to let you know about an upcoming skills training that you might find interesting! **{{ $programTitle }}** is being offered by **{{ $providerName }}** and will be held at **{{ $programLocation }}**.

This is a fantastic opportunity to enhance your skills, and we think it could be a great fit for you. Please note that the registration deadline is **{{ $registrationDeadline }}**. Be sure to sign up before this date to secure your spot!

To get more details and register, click the link below:

<x-mail::button :url="$programUrl">
View Training Details and Register
</x-mail::button>

If you have any questions or need further assistance, don’t hesitate to reach out. We’re here to help!

Best,<br>
{{ config('app.name') }} {{$PESO}}
</x-mail::message>
