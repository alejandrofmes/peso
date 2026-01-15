<x-mail::message>
# Dear {{ $employeeName }},

We are pleased to inform you that your participation in **{{ $programTitle }}** offered by **{{ $providerName }}** has now been successfully completed. 

We want to extend our sincere gratitude for your commitment to enhancing your skills through this training program. We hope that the knowledge and experience gained will significantly benefit your professional development.

If you would like to review the details of the program or any materials provided, please visit your profile on the PESO platform. We encourage you to reflect on your learnings and consider how they can be applied in your current role or future endeavors.

Should you have any questions regarding the program or if you require further assistance, please do not hesitate to reach out. We are here to support you and provide any information you may need.

Thank you once again for your participation, and we wish you all the best in your ongoing journey of growth and development.

Warm regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>