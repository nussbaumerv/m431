<?php
include("connect.php");
include("menu.php");
session_start();
$uid = $_SESSION['uid'];

if ($uid) {
    $sql = "SELECT * FROM users WHERE id = '$uid'";
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo "<script> alert('Daten konnten nicht geladen Werden.'); </script>";
    }

    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];

    if ($row['token'] != $_SESSION['token']) {
        header("Location: login.php");
    }
} else {
    header("Location: login.php");
}
if ($_GET['r'] == "") {
    header("Location: index.php");

} else {
    $room = $_GET['r'];
    $sql_gr = "SELECT * FROM rooms WHERE id = '$room'";
    $result_gr = mysqli_query($connect, $sql_gr);
    $row_gr = mysqli_fetch_assoc($result_gr);

    $json_mods = $row_gr['mods'];
    $array_mods = json_decode($json_mods, true);

    $json_id = $row['chat_rooms'];
    $array_id = json_decode($json_id, true);

    $room_name = $row_gr['name'];

    if (in_array($uid, $array_mods)){
        include("mRSettings.php");
    }
    else if(in_array($room, $array_id)){
        include("sRSettings.php");
    }
    else{
        echo "You Dont have access to this site";
    }

}
?>