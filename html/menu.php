<?php
include("connect.php");
$uid = $_COOKIE['uid'];

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

  if ($row['token'] == $_COOKIE['token']) {
  } else {
    exit;
  }
} else {
  header("Location: login.php");
}


?>
<html>
<head>
</head>

<body>
  <div id="mySidenav" class="sidenav">

    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <div id="top_menu">
      <?php
      for ($i = count($array_id)-1; $i > -1; $i--) {
        echo "<a class='ht' style='padding:20px;' href='https://edu-chat.me?r=" . $array_id[$i] . "'>" . $array_name[$i] . "</a>";
      }
      ?>
    </div>
    <div id="bottom_menu">
      <form method="get" action="createRoom.php">
        <input placeholder="Room Name" class="input_menu" type="text" name="r" required> <br>
        <button class="button_menu" type="submit" onclick="save()">Create Groupe</button>
      </form>
    </div>
  </div>

  <div class="zo">
    <span class="navib" onclick="openNav()"> &#9776; </span>
  </div>

  <script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
      document.getElementById("main").style.marginLeft = "250px";
      document.body.style.backgroundColor = "black";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0px";
      document.getElementById("main").style.marginLeft = "0";
      document.body.style.backgroundColor = "black";
    }
  </script>