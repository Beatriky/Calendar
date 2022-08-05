<?php
require_once('db-connect.php');
require_once('appointment.php');

session_start();
ob_start();

if (!isset($_SESSION['idUser'])) {
    header('Location: login.php');
    exit;
} else {
    // Show users the page!
}
?>

<!DOCTYPE html>
<html lang="en">
<script src="script.js" defer></script>

<?php

global $pdo;
function getLocations($idLocation)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM location");
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $counter = 1;
    while ($row = $stmt->fetch()) {
        echo "<option value=\"$counter\">" . $counter . " : " . $row['city'] . "</option>";
        $counter++;
    }
}


//request cu get    //de aici luam data si o bagam in db
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_GET['selectedDate']) && isset($_POST['checker'])) {
    $selectedTime = isset($_GET['selectedDate']) ? $_GET['selectedDate'] : date("Y-m-d");
    $idLocation = isset($_GET['$idLocation']) ? $_GET['$idLocation'] : null;
    makeAppointment($selectedTime, $idLocation);

    $selectedDate = htmlspecialchars($_GET['selectedDate']);
}
//$_GET['selectedDate'];

?>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="stylesheet" type="text/css" href="main.css"/>

    <title>Calendar</title>
</head>


<body style="background-color:#eee;">
<div class="containerbox">
    <box class="boxcalendar">

        <div id="calendar">
            <div class="month">
                <ul>
                    <li id="prev">&#10094;</li>
                    <li id="month"></li>
                    <li id="year"></li>
                    <li id="next">&#10095;</li>
                </ul>
            </div>

            <ul id="weekdays">
                <li>Su</li>
                <li>Mo</li>
                <li>Tu</li>
                <li>We</li>
                <li>Th</li>
                <li>Fr</li>
                <li>Sa</li>
            </ul>

            <ul id="days" class="days"></ul>

        </div>
    </box>

    <form method="GET" id="GetForm" style="visibility: hidden">
        <input type="text" id="selectedDateForm" name="selectedDate">
        <input type="text" id="selectedLocationForm" name="idLocation">
        <input type="submit" value="submit" id="selectedDateSubmit">
    </form>

    <box class="boxuser">

        <h1 id="schedule" class="schedule">Hello! There is nothing scheduled for today!</h1>
        <ul id="profileID" class="profiles">
            <h1 id="people-section"> Users </h1>
            <li class="people-list">
            </li>
        </ul>

        <!--        <form>-->
        <!--            <select name="users" onchange="showUser(this.value)">-->
        <!--                <option value="">Select a person:</option>-->
        <!--                <option value="1">Mitica</option>-->
        <!--                <option value="2">Joyce</option>-->
        <!--            </select>-->
        <!--        </form>-->
        <!--        -->
        <!--        <br>-->
        <!--        <div id="personInfo"><b>Person info will be listed here...</b></div>-->

        <div>
            <label for="locations">Location: </label>
            <select name="locations" id="locationID" form="locationForm">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    $idLocation = isset($_GET['idLocation']) ? $_GET['idLocation'] : null;
                    getLocations($idLocation);
                }
                ?>
            </select>

        </div>
        <div id="appointmentButton" class="appointment-button" onclick="appointmentOnClick()">Make an appointment
            <br>
            <form method="POST" id="formSubmit" name="formSubmit">
                <input name="checker" value="true" style="display: none">
                <input id="submit" type="submit" name="submit" value='Add event'/>
            </form>
        </div>
        <?php
        getAppointments();
        ?>
    <br>
        <a href='logout.php'>Click here to log out</a>


    </box>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"
        integrity="sha512-odNmoc1XJy5x1TMVMdC7EMs3IVdItLPlCeL5vSUPN2llYKMJ2eByTTAIiiuqLg+GdNr9hF6z81p27DArRFKT7A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

</script>
</body>

</html>

<?php


function makeAppointment($selectedTime, $idLocation)
{
    global $pdo;
    $selectedDate = $_GET['selectedDate'];
    $locationId = $_GET['idLocation'];

//        $inst = "INSERT INTO users(firstName, lastName ,email,password) VALUES (:firstName,:lastName,:email,:password)";


    $inst = $pdo->prepare("INSERT INTO `appointment` (`idLocation`,`date`,`idUser`) VALUES (:locationId, :selectedDate,:idUser)");
    $inst->bindParam(":selectedDate", $selectedDate);
    $inst->bindParam(":locationId", $locationId);
    $inst->bindParam(":idUser", $_SESSION["idUser"]);

    $inst->execute();
    //$pdo->query($inst);
    //$pdo->exec($sqlInsert);
    //      $queryRun = $pdo->prepare($inst);


//    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//        $userId = $_POST['userId'];
//        $locationId = $_POST['idLocation'];
//        $selectedTime = $_POST['selectedTime'];
//    }


}

unset($result);

$query = 'SELECT * FROM location ';

$result = $pdo->query($query);
$result->setFetchMode(PDO::FETCH_ASSOC);
$counter = 1;
while ($row = $result->fetch()) {
    echo '<li' . $counter . '>' . $row['idLocation'] . " " . $row['city'] . '<br/></p></li>';
    $counter++;
}

$queryLOC = "SELECT city FROM location ";

$result = $pdo->query($queryLOC);
echo "<select name = 'Location'>";

while (($row = $result->fetch()) != null) {
    echo "<option value = '" . json_encode($row) . "'</option>";
}
echo "</select>";


?>
<!--//AJAX-->
<!---->
<!--//$q = intval($_GET['q']);-->
<!--//$q=1;-->
<!--//-->
<!--//$sql="SELECT * FROM users WHERE id = '".$q."'";-->
<!--//$result = $pdo->query($query);-->
<!--//echo "<table>-->
<!--//<tr>-->
<!--//<th>Firstname</th>-->
<!--//<th>Lastname</th>-->
<!--//</tr>";-->
<!--//-->
<!--//while($row = ($result)->fetch_row()) {-->
<!--//    echo "<tr>";-->
<!--//    echo "<td>" . $row['FirstName'] . "</td>";-->
<!--//    echo "<td>" . $row['LastName'] . "</td>";-->
<!--//    echo "</tr>";-->
<!--//}-->
<!--//echo "</table>";-->
<!---->
<!---->
<!--//$data = array();-->
<!--//while ($row = fetch($result))-->
<!--//{-->
<!--//    array_push($data, $row);-->
<!--//}-->
<!--//echo json_encode($data);-->
<!--//exit();-->
<!---->
<!--//login to session-->
<!---->
<!--//session_start();-->
<!---->
<!--//if($_SERVER["REQUEST_METHOD"] == "POST") {-->
<!--// username and password sent from form-->
<!---->
<!--//    $email = mysqli_real_escape_string($pdo,$_POST['email']);-->
<!--//    $password = mysqli_real_escape_string($pdo,$_POST['password']);-->
<!--//-->
<!--//    $sql = "SELECT id FROM users WHERE email = '$email' and password = '$password'";-->
<!--//    $result = mysqli_query($pdo,$sql);-->
<!--//    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);-->
<!--//    $active = $row['active'];-->
<!--//-->
<!--//    $count = mysqli_num_rows($result);-->
<!--//-->
<!--//    if($count == 1) {-->
<!--//       // session_register("email");-->
<!--//        $_SESSION['login_user'] = $email;-->
<!--//-->
<!--//        header("location: index.php");-->
<!--//    }else {-->
<!--//        $error = "Your Login Name or Password is invalid";-->
<!--//    }-->
<!---->
<!--//cookie based-->
<!--//if (isset($_POST['email']) && isset($_POST['password'])) {-->
<!--//-->
<!--//    function validate($data){-->
<!--//-->
<!--//        $data = trim($data);-->
<!--//-->
<!--//        $data = stripslashes($data);-->
<!--//-->
<!--//        $data = htmlspecialchars($data);-->
<!--//-->
<!--//        return $data;-->
<!--//-->
<!--//    }-->
<!--//    $email= validate($_POST['email']);-->
<!--//-->
<!--//    $password = validate($_POST['password']);-->
<!--//}-->
<!--//-->
<!--//-->
<!--//-->
<!--//if (empty($email)) {-->
<!--//-->
<!--//    header("Location: index.php?error=User Name is required");-->
<!--//-->
<!--//    exit();-->
<!--//-->
<!--//}else if(empty($password)){-->
<!--//-->
<!--//    header("Location: index.php?error=Password is required");-->
<!--//-->
<!--//    exit();-->
<!--//-->
<!--//}else {-->
<!--//-->
<!--//    $sql = "SELECT * FROM users WHERE user_name='$email' AND password='$password'";-->
<!--//-->
<!--//    $result = mysqli_query($pdo, $sql);-->
<!--//}-->
<!--//$fn =$_GET('firstName');-->
<!--//$query = "SELECT *  FROM users where firstName=.$fn.";-->
<!---->
<!--//-->
<!--//foreach($pdo->query($query)as $user)-->
<!--//{-->
<!--//    echo '<pre>';-->
<!--//    var_dump($user);-->
<!--//    echo '</pre>';-->
<!--//}-->

<!--//$sth =$pdo->prepare("SELECT firstName, lastName  FROM users");-->
<!--//$sth->execute();-->
<!--//-->
<!--//-->
<!--//print("\n Return next row as an array indexed by column name\n");-->
<!--//$result = $sth->fetch(PDO::FETCH_ASSOC);-->
<!--//print_r($result);-->
<!--//print("\n");-->
