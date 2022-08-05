<?php
//connection to db
$host     = 'localhost';
$username = 'tutorial';
$password = 'secret';
$dbname   ='tutorial';

try {
    $pdo = new PDO('mysql:dbname=tutorial;host=mysql', $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), $e->getCode());
}
if(!$pdo){
    die("Cannot connect to the database.". $pdo->error);
}

//$pdo = new PDO('mysql:dbname=tutorial;host=mysql', 'tutorial', 'secret', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
