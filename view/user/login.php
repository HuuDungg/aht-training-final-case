<?php
if(isset($_SESSION["user_id"])){
    header("Location: http://localhost/aht-training/final-case/?act=list");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Login in</h1>
    <form action="?act=processLogin" method="POST">
        user name: <input type="text" name="username" required> <br>
        password: <input type="text" name="password" required> <br>
        <button>Login</button>
        create new account <a href="">click here</a>
    </form>
</body>
</html>