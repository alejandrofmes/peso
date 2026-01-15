<x-mail::message>
# New Announcement from Your PESO Office

Dear {{ $residentName }},

We have an important new update from your local PESO office:

**{{ $announcementTitle }}**

We encourage you to read the full announcement to stay informed about what’s happening in our community.

To view the full details, please click the link below:

<x-mail::button :url="$announcementUrl">
View Announcement
</x-mail::button>

If you have any questions, feel free to contact our office.

Thank you,<br>
{{ config('app.name') }} {{$PESO}}
</x-mail::message>
