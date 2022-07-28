<!DOCTYPE html>
<html lang="en">
<script src="script.js" defer></script>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" type="text/css" href="main.css" />

    <title>Calendar</title>
</head>

<body style="background-color:#eee;">
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
<h1 id="schedule" class="schedule">Schedule for July 27, 2022</h1>
<h2 id="dateField"> data </h2>

<ol id="profileID" class="profiles">
    <p id="people-section"> Users </p>
    <li class="people-list">
    </li>
</ol>

</body>
</html>



<?php
//echo "<h1>This is served with docker</h1>";
//
//$pdo = new PDO('mysql:dbname=tutorial;host=mysql', 'tutorial', 'secret', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
//
//$query = $pdo->query('SHOW VARIABLES like "version"');
//
//$row = $query->fetch();
//
//echo 'MySQL version:' . $row['Value'];
//
//var_dump($row);
//
//
//$query = 'SELECT firstName, lastName, profile_picture FROM users';
//$result = $pdo->query($query);