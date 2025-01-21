<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "sample";
$conn = new mysqli($servername, $username, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}