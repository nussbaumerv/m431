<?php
include("connect.php");

$amount = $_GET['amount'];
$room = $_GET['r'];
$uid = $_COOKIE['uid'];

$sql = "SELECT COUNT(`id`) AS total_messages FROM `messages` WHERE room_id = '$room'";
$result = mysqli_fetch_assoc(mysqli_query($connect, $sql));
$total_entries = $result["total_messages"];

if ($amount != $total_entries) {
    $sql = "SELECT * FROM `messages` WHERE room_id = '$room' ORDER BY `id` ASC";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) > 0) {
        $counter = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $sender_id = $row['sender_id'];

            $sql_name = "SELECT * FROM `users` WHERE id = '$sender_id'";
            $result_name = mysqli_query($connect, $sql_name);
            $row_name = mysqli_fetch_assoc($result_name);
            $color = $row_name["color"];

            if ($sender_id == $uid) {
                $sender = "You";
            } else {
                $sender = $row_name["username"];
            }

            echo "<div style='background-color: ".$color.";' class='messageContainer'>
            <t class='user'>" . $sender . "  <i>" . $row['time'] . " | " . $row['date'] . "</i></t><br>
            <t class='content'>" . $row["content"] . "</t><br>
            </div>";
        }

        echo "<div style='font-size: 0px' id='amount'>" . $total_entries . "</div>";
    }
}
