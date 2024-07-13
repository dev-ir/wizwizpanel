<?php
// include '../wizwizxui-timebot/baseInfo.php';
$servername = "localhost";
$conn = new mysqli('localhost', 'root', '', 'wiz');
$conn->set_charset("utf8mb4");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
