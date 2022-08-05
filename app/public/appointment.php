<?php
//$_SERVER['REQUEST_METHOD']==="GET" AND

function getAppointments()
{
    if (!isset($_GET["selectedDate"]) or !isset($_GET["idLocation"])) {
        return;
    }

    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM appointment
                    INNER JOIN users ON appointment.idUser = users.idUser
                    INNER JOIN location ON appointment.idLocation = location.idLocation 
                    WHERE cast(appointment.date as date) = :date AND appointment.idLocation = :idLocation
                    ORDER BY appointment.date ASC");
    $stmt->bindParam(":date", $_GET["selectedDate"]);
    $stmt->bindParam(":idLocation", $_GET["idLocation"]);
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    while ($row = $stmt->fetch()) {
    //    echo '<li>' . $counter . '" ' . $counter . '">' . $row['firstName'] . " " . $row['lastName'] . '<p>' . $counter . '">' . $row['date']  . '</p></li><br>';

        echo "{$row['lastName']} {$row['firstName']}";
    }
}
