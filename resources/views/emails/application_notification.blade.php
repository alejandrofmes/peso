<x-mail::message>
# Hello {{ $employeeName }},

We are pleased to inform you about the current status of your job application for the position of **{{$jobTitle}}** at **{{$companyName}}**.

**Status:** {{ $applicationStatus }}

@if($applicationStatus === 'INTERVIEW')
We’re excited to invite you to an interview for this position. Please find the company's remarks below:

## Company Remarks
<div style="border-left: 4px solid #3b82f6; padding-left: 20px; margin-top: 20px; background-color: #F9F9F9; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
<p style="font-size: 16px; color: #555; line-height: 1.5;">
{{ $companyRemarks }}
</p>
</div>

Further details about the interview will be shared with you soon.

@endif

@if($applicationStatus === 'HIRED')
Congratulations! We are delighted to inform you that you have been hired. To confirm your hiring process, please log in to your account.

## Company Remarks
<div style="border-left: 4px solid #4CAF50; padding-left: 20px; margin-top: 20px; background-color: #FDECEA; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
<p style="font-size: 16px; color: #555; line-height: 1.5;">
{{ $companyRemarks }}
</p>
</div>

@endif

@if($applicationStatus === 'REJECTED')
We regret to inform you that your application was not successful. We encourage you to keep exploring other job opportunities through our platform.

@endif

Thank you for using the PESO platform to explore job opportunities. If you have any questions or need further assistance, please feel free to contact us.

Best regards,<br>
{{ config('app.name') }} {{$PESO}}
</x-mail::message>
