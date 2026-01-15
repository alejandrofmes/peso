@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'PESO')
<img src="https://rec-data.kalibrr.com/www.kalibrr.com/logos/Q9M85F9CS374JN5XP4ECK8K7D4FJKVXE5Z6KS7AH-5ef55667.png" class="logo" alt="">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
