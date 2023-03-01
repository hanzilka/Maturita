<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("assets/php/connection.php");  
if(!isset($_SESSION['role'])) {
    // pokud user není admin, pošli ho na login
    header("Location: login.php");
    exit;
}
?>