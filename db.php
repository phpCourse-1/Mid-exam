<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'Mid'; 

$conn = mysqli_connect($host, $user, $password, $db); 
