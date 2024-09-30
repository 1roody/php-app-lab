<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Screen</title>
    <link href="/Assets/form.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="login_form">
        <h1>Login</h1>
        <?php
            if(isset($_GET['msg'])) {
                echo $_GET['msg'];
            }
        ?>
        <input id="username" type="text" placeholder="Username">
        <input id="password" type="password" placeholder="Password">
        <button type="button" id="login_button" onclick="login()">Login</button>
        <button type="button" id="register_button"><a href="/register">Register your account</a></button>
    </div>

    <script src="/Assets/login.js"></script>
</body>
</html>
