<?php
session_start();
include("connect.php");

$name = $_GET['r'];
$uid = $_SESSION['uid'];
$mods = '["'.$uid.'"]';

$sql = "SELECT * FROM users WHERE id = '$uid'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);


$sql_insert = "INSERT INTO rooms (name, description, creator, mods, availability) VALUES ('$name', '$name', '$uid', '$mods', '1')";
$result_insert = mysqli_query($connect, $sql_insert);
$last_id = mysqli_insert_id($connect);


$json_id = $row['chat_rooms'];
$json_names = $row['chat_rooms_name'];

$array_id = json_decode($json_id, true);
$array_name = json_decode($json_names, true);

array_push($array_id, $last_id);
array_push($array_name, $name);

$array_id = json_encode($array_id);
$array_name = json_encode($array_name);

$sql_update = "UPDATE users SET chat_rooms ='$array_id', chat_rooms_name ='$array_name' WHERE id = '$uid'";
$result_update = mysqli_query($connect, $sql_update);

if($result_update){
    header("Location: index.php?r=".$last_id);
}
else{
    echo "Something went wrong";
}

?>