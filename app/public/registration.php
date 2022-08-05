<?php
require_once("db-connect.php");
global $pdo;

if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $password = $_POST['password'];

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $query = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        echo '<p class="error">The email address is already registered!</p>';
    }

    if ($query->rowCount() == 0) {
        $query = $pdo->prepare("INSERT INTO users(firstName,lastName,password,email) VALUES (:firstName,:lastName,:password_hash,:email)");//:password_hash
        $query->bindParam(":firstName", $firstName);
        $query->bindParam(":lastName", $lastName);
        $query->bindParam(":password_hash", $password_hash);
       // $query->bindParam(":password", $password);
        $query->bindParam(":email", $email);
        $query->execute();
        unset($result);
        $result = $query->fetch();
        $_SESSION['idUser'] = $result['idUser'];
        // echo '<p class="success">Your registration was successful!</p>';
        header("Location:/login.php");

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
<form method="post" action="registration.php" name="registration-form">
    <div class="form-element">
        <label>First Name</label>
        <input type="text" name="firstName" required/>
    </div>
    <div class="form-element">
        <label>Last Name</label>
        <input type="text" name="lastName" required/>
    </div>
    <div class="form-element">
        <label>Email</label>
        <input type="text" name="email" required/>
    </div>
    <div class="form-element">
        <label>Password</label>
        <input type="password" name="password" required/>
    </div>

    <button type="submit" name="signup" value="signup">Sign Up</button>
</form>
</body>

</html>