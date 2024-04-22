<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Request</title>
</head>
<body>
<h1>User {{ ucwords($name) }} is requesting account access</h1>
<ul>
    <li>Email: {{ $email }}</li>
    <li>Access Expiration: {{ $expiration }}</li>
</ul>

<a href="{{ route('staff.approve', ['link' => $link]) }}">Approve?</a>

</body>
</html>
