<?php
session_start();
include("connect.php");
$message = $_POST['message'];
$room = $_POST['room'];
$uid = $_SESSION['uid'];
$sql = "INSERT INTO messages (room_id, content, sender_id) VALUES ('$room', '$message', '$uid')";
$result = mysqli_query($connect, $sql);
?>