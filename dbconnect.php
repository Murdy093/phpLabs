<?php
$servername = "localhost:3306";
$username = "root";
$password = "1111";
$dbname = "basic";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}