<x-mail::message>
# Hello {{ $applicantName }},

We are writing to update you on the status of your job application for the position of **{{ $jobTitle }}** at **{{ $companyName }}**.

**Status:** {{ $recommendationStatus === 'RECOMMENDED' ? 'Recommended' : 'Not Recommended' }}

@if($recommendationStatus === 'RECOMMENDED')
Great news! PESO has recommended your application. You can view your recommendation letter on the PESO platform. This is the first step before your application is visible to the employer. Rest assured, regardless of the recommendation status, your application will be seen by the employer.

@endif

@if($recommendationStatus === 'REJECT')
We regret to inform you that PESO has decided not to recommend your application at this time. However, your application will still be visible to the employer. We encourage you to continue exploring other opportunities.

@endif

Thank you for using the PESO platform for your job application. If you have any questions or need further assistance, please do not hesitate to contact us.

Best regards,<br>
{{ config('app.name') }} {{$PESO}}
</x-mail::message>
