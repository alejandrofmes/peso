<x-mail::message>
    Dear {{$employeeName}},

    We are pleased to confirm your registration for the training program **{{$programTitle}}** conducted by **{{$providerName}}**.
    
    PESO {{$PESO}} has reviewed your registration and confirmed your slot for the upcoming session. 
    
    For additional information, kindly refer to the training post.
    
    Thank you, and we look forward to your participation!
    
<x-mail::button :url="$trainingUrl">
View Training Details
</x-mail::button>

Best regards,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
