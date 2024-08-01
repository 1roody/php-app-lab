<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Screen</title>
    <link href="/Assets/form.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="login_form">
        <h1>Register</h1>
        <input id="username" type="text" placeholder="Username">
        <input id="password" type="password" placeholder="Password">
        <button type="button" id="login_button" onclick="register()">Create account</button>
        <button type="button" id="alreadyRegistered_button"><a href="/login">already registered?</a></button>
    </div>

    <script src="/Assets/register.js"></script>
</body>
</html>
