<?php
global $pdo;

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $query = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        echo '<p class="error">The email address is already registered!</p>';
    }
    if ($query->rowCount() == 0) {
        $query = $pdo->prepare("INSERT INTO users(password,email) VALUES (:password_hash,:email)");
        $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $result = $query->execute();
        if ($result) {
            echo '<p class="success">Your registration was successful!</p>';
        } else {
            echo '<p class="error">Something went wrong!</p>';
        }
    }
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
<form method="post" action="" name="signin-form">
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
</body>

</html>