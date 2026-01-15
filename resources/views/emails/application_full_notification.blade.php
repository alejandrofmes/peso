<x-mail::message>
# Hello {{ $employeeName }},

We regret to inform you that the job application process for the position of **{{ $jobTitle }}** at **{{ $companyName }}** has been completed, and all available job slots have been filled.

**Status:** Job Posting Completed

While your application was carefully reviewed, we were unable to move forward with your candidacy due to the limited number of available positions.

Although you were not selected for this position, we encourage you to keep exploring other opportunities available on our platform. Your skills and experience are valuable, and we are confident that the right opportunity will come your way.

If you have any questions or need further assistance, please don't hesitate to reach out to us.

Thank you for using the PESO platform to explore job opportunities. We wish you the best of luck in your job search.

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
