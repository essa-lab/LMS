<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
@component('mail::message')
# Email Verification

Thank you for signing up. 
Your six-digit code is {{$pin}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
</body>
</html>