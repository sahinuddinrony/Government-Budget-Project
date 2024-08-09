<!-- resources/views/emails/approval.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Account Approved</title>
</head>
<body>
    <h1>Hello, {{ $name }}</h1>
    <p>Your account has been approved. Please verify your email by clicking the link below:</p>
    <a href="{{ $verificationUrl }}">Verify Email</a>
</body>
</html>
