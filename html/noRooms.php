<?php
include("connect.php");
session_start();
$uid = $_SESSION['uid'];
$amount = $_GET['amount'];

if ($uid) {
    $sql = "SELECT * FROM users WHERE id = '$uid'";
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo "<script> alert('Daten konnten nicht geladen Werden.'); </script>";
    }

    $row = mysqli_fetch_assoc($result);
    $json_id = $row['chat_rooms'];
    $json_names = $row['chat_rooms_name'];

    $array_id = json_decode($json_id, true);
    $array_name = json_decode($json_names, true);

    if ($row['token'] == $_SESSION['token']) {
        if ($amount != count($array_id)) {
            for ($i = 0; $i < count($array_id); $i++) {
                echo "<div><a class='linksRooms' href='https://edu-chat.me?r=" . $array_id[$i] . "'>" . $array_name[$i] . "</a></div>";
            }
            echo "<div style='font-size: 0px' id='amount'>" . count($array_id) . "</div>";
        } 
    } else {
        echo "You dont't have accsess";
    }
}else {
    echo "You dont't have accsess";
}
