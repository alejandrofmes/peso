<x-mail::message>
    Dear {{$employeeName}},

    Thank you for taking interest in the training program {{$programTitle}} conducted by {{$providerName}}.
    
    Unfortunately, we regret to inform you that all available slots for this training session have already been filled.
    
    As a result, your registration could not be processed.
    
    We encourage you to explore other training programs that may suit your needs and preferences.
    
    Stay updated on upcoming training opportunities by regularly checking our training posts and get notified

    on training opportunities best suited for your career development.
    
    Thank you for your understanding, and we hope to see you in future sessions!
    

<x-mail::button :url="''">
Button Text
</x-mail::button>

Best regards,,<br>
{{ config('app.name') }} {{ $PESO }}
</x-mail::message>
