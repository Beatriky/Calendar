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
</body>

</html>

<?php


function makeAppointment($selectedTime, $idLocation)
{
    global $pdo;
    $selectedDate = $_GET['selectedDate'];
    $locationId = $_GET['idLocation'];
    $inst = $pdo->prepare("INSERT INTO `appointment` (`idLocation`,`date`,`idUser`) VALUES (:locationId, :selectedDate,:idUser)");
    $inst->bindParam(":selectedDate", $selectedDate);
    $inst->bindParam(":locationId", $locationId);
    $inst->bindParam(":idUser", $_SESSION["idUser"]);
    $inst->execute();
}

?>