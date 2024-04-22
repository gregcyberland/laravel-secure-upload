<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved</title>
</head>
<body>
<h1>Hi, {{ ucwords($name) }} your request has been approved! </h1>
<ul>
    <li>Email: {{ $email }}</li>
    <li>Access Expiration: {{ date("Y-m-d H:i:s", $expiration) }}</li>
</ul>

<a href="http://simplelogin.test/">Login here</a>

</body>
</html>
