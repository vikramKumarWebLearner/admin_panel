<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Set Your Password</title>
</head>
<body>
    <h2>Set Your Password</h2>
    
    <p>Hello {{ $user->name }},</p>
    
    <p>Please click on the following link to set your password:</p>
    
    <p><a href="{{ $setPasswordUrl }}">Set Password</a></p>
    
    <p>If you did not request this email, you can safely ignore it.</p>
    
    <p>Thank you.</p>
</body>
</html>
