<?php
session_start();
ob_start();

$pdo = new PDO('mysql:dbname=tutorial;host=mysql', 'tutorial', 'secret', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

global $pdo;

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    //var_dump($password);die();

    $query = $pdo->prepare("SELECT * FROM users WHERE email= :email and password=:password");
    $query->bindParam(":email", $email);
    $query->bindParam(":password", $password);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        echo '<p class="error">Email password combination is wrong!</p>';
    } else {
        if ($password==$result['password']) {
            $_SESSION['idUser'] = $result['idUser'];
            echo '<p class="success">Congratulations, you are logged in!</p>';
            header("Location: index.php");
        } else {
            echo '<p class="error">Email combination is wrong!</p>';
        }
    }
}
//            array(
//                    'email'=>$_POST["email"];
//                    'password'=>$_POST["password"];
//            )
?>
<!--//if (isset($_POST['email']) && isset($_POST['psw'])) {-->
<!--//    $mail = $_POST['email'];-->
<!--//    $psw = $_POST['psw'];-->
<!--////$userName = $_POST['userName'];-->
<!--//    $sql = "select * from users where email='" . $mail . "'AND password='" . $psw . "'";-->
<!--//    $result1 = $pdo->query($sql);-->
<!--//    $result1->setFetchMode(PDO::FETCH_ASSOC);-->
<!--//    $row = $result1->fetch();-->
<!--//    if ($row != null) {-->
<!--//        //  echo " You Have Successfully Logged in ";-->
<!--//        $_SESSION['id'] = $row['id'];-->
<!--//        $_SESSION['email'] = $row['email'];-->
<!--//        exit();-->
<!--//    } else {-->
<!--//        echo " You Have Entered Incorrect Password";-->
<!--//        exit();-->
<!--//    }-->
<!--//}-->


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
</body>

</html>
<!---->
<!---->
<!--//if (isset($_POST['username']) && $_POST['username'] && isset($_POST['password']) && $_POST['password']) {-->
<!--//    // do user authentication as per your requirements-->
<!--//    // based on successful authentication-->
<!--//    echo json_encode(array('success' => 1));-->
<!--//} else {-->
<!--//    echo json_encode(array('success' => 0));-->
<!--//}-->
<!---->
<!--if (isset($_POST['submit'])) {-->
<!--    $firstName = $_POST['firstName'];-->
<!--    $lastName = $_POST['lastName'];-->
<!--    $email = $_POST['email'];-->
<!--    $password = $_POST['password'];-->
<!---->
<!--    $inst = "INSERT INTO users(firstName, lastName ,email,password)-->
<!--VALUES (:firstName,:lastName,:email,:password)";-->
<!--    $queryRun = $pdo->prepare($inst);-->
<!---->
<!---->
<!--//    $dataApointment = [-->
<!--//        ':idUser' => $_SESSION['id'],-->
<!--//        ':password' => $password,  ];-->
<!--//-->

<!--    $data = [-->
<!--        ':firstName' => $firstName,-->
<!--        'lastName' => $lastName,-->
<!--        ':email' => $email,-->
<!--        ':password' => $password,-->
<!--    ];-->
<!--    $queryExecute = $queryRun->execute($data);-->
<!--    if ($queryExecute) {-->
<!--        {-->
<!--            echo "Inserted Successfully";-->
<!--            exit(0);-->
<!--        }-->
<!--    } else {-->
<!--        echo "Not Inserted";-->
<!--        exit(0);-->
<!--    }-->
<!---->
<!--}-->
<!---->
<!--if (isset($_POST['email']) && isset($_POST['psw'])) {-->
<!--    $mail = $_POST['email'];-->
<!--    $psw = $_POST['psw'];-->
<!--    //$userName = $_POST['userName'];-->
<!--    $sql = "select idUser, email from users where email='" . $mail . "'AND password='" . $psw . "'";-->
<!--    $result1 = $pdo->query($sql);-->
<!--    $result1->setFetchMode(PDO::FETCH_ASSOC);-->
<!--    $row = $result1->fetch();-->
<!--    if ($row != null) {-->
<!--        //  echo " You Have Successfully Logged in ";-->
<!--        $_SESSION['id'] = $row['id'];-->
<!--        $_SESSION['email'] = $row['email'];-->
<!--        exit();-->
<!--    } else {-->
<!--        echo " You Have Entered Incorrect Password";-->
<!--        exit();-->
<!--    }-->
<!--}-->
<!---->


