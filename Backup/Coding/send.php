<?php
include("connect.php");
$message = $_POST['message'];
$uid = 1;
$sql = "INSERT INTO messages (room_id, content, sender_id, time, date) VALUES ('1', '$message', '1', 'lul', 'lul')";
$result = mysqli_query($connect, $sql);
?>