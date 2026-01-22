<?php 
$localhost = "localhost";
$user = "root";
$password = "";
$database = "bagong_ilog";

// Connect to the database
$connect = mysqli_connect($localhost, $user, $password, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>