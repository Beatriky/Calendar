<?php
require_once("db-connect.php");
session_start();
ob_start();

global $pdo;
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $pdo->prepare("SELECT * FROM users WHERE email= :email");
    $query->bindParam(":email", $email);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);


    if (!$result) {
        echo '<p class="error">Email password combination is wrong!</p>';
    } else {
        if (password_verify($password, $result['password'])) {
            $_SESSION['idUser'] = $result['idUser'];
            echo '<p class="success">Congratulations, you are logged in!</p>';
            header("Location: index.php");
        } else {
            echo '<p class="error">Email is wrong!</p>';
        }
    }
}

if (isset($_POST['signup'])) {
    header("location:/registration.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<script src="script.js" defer></script>

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="stylesheet" type="text/css" href="login.css"/>
    <title>Login</title>
</head>

<body>
<form method="post" action="login.php" name="signin-form">
    <div class="form-element">
        <label>Email</label>
        <input type="text" name="email" required/>
    </div>
    <div class="form-element">
        <label>Password</label>
        <input type="password" name="password" required/>
    </div>
    <button type="submit" name="login" value="login">Log In</button>
</form>

<form action="registration.php" name="signup-form">
    <label>Don't have an account?Click to sign up</label>
    <button type="submit" name="signup" value="signup">Sign Up</button>
</form>
</body>
</html>
