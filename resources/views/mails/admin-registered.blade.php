@component('mail::message')
# Your Email Registered Successfully with our records.
 
Below are your login credentials!
 
Email       : {{ $email }}
<br>
Password    : {{ $password }}
 
Thanks,<br>
{{ config('app.name') }}
@endcomponent