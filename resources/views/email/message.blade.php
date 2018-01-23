@component('mail::message')
# New Message
You've received a new message from {{ config('app.name') }}. To respond to this user simply reply to this email.

**From:** {{ $from }}

**Message:** {{ $message }}

**Time Sent:** {{ $sentAt }}

**IP Address:** {{ $ip }}

@endcomponent
