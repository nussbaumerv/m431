<?php
include("connect.php");

$amount = $_GET['amount'];
$room = $_GET['room'];

$sql = "SELECT COUNT(`id`) AS total_messages FROM `messages` WHERE room_id = '$room'";
$result = mysqli_fetch_assoc(mysqli_query($connect, $sql));
$total_entries = $result["total_messages"];

if($amount != $total_entries){
    $limit = $total_entries - $_SESSION["total"];

    $sql = "SELECT * FROM `messages` WHERE room_id = '$room' ORDER BY `id` DESC";
    $result = mysqli_query($connect, $sql);
    if(mysqli_num_rows($result)>0){
        $counter = 0;
        while($row = mysqli_fetch_assoc($result)){
            $counter++;
            echo "<p>".$row["content"]."</p>";
        }
        echo "<script> amount=".$counter." </script>";
    }
}
?>