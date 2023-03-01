<?php
$server = "websql.in.spsostrov.cz";
$data = parse_ini_file("assets/lib/database.ini");
$login = $data["username"];
$password = $data["password"];
$database = $data["database"];

 
/* Attempt to connect to MySQL database */
$connection = mysqli_connect($server, $login, $password, $database);
mysqli_set_charset($connection, 'utf8'); // nastavení utf8
 
// Check connection
if($connection === false){
    die("ERROR: Nelze navázat spojení. " . $connection->connect_error);
}

error_reporting(E_ALL);
ini_set("display_errors", 1);
?>