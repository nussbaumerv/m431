<?php
include("connect.php");
session_start();
$uid = $_SESSION['uid'];

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
  } else {
    exit;
  }
} else {
  header("Location: login.php");
}


?>

<html>
<head>
  <style>
    * {
      font-family: arial;
      margin: 0px;
    }

    .sidenav {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: #111;
      overflow-x: hidden;
      transition: 0.5s;
      padding-top: 60px;
      text-align: left;
    }

    .sidenav a {
      padding: 8px 8px 8px 32px;
      text-decoration: none;
      font-size: 25px;
      transition: transform .2s;
      color: #818181;
      display: block;
      transition: 0.3s;
    }

    .sidenav a:hover {
      color: #f1f1f1;
      transition: transform .2s;
      transition: color: .2s;
      transform: scale(1.03);
    }

    .sidenav .closebtn {
      position: absolute;
      top: 0;
      right: 25px;
      font-size: 36px;
      margin-left: 50px;
    }

    .navib {
      font-size: 30px;
      cursor: pointer
    }

    .navib {
      font-size: 40px;
    }

    .zo {
      transition: margin-left .5s;
      color: black;
      text-align: left;
      position: fixed;
      transition: transform .2s;
      width: 40px;
      height: 50px;
      left: 0 auto;
      transition: color: .2s;
      top: 0;
    }

    .zo:hover {
      color: grey;
      transition: transform .2s;
      transition: color: .2s;
      transform: scale(1.12);

    }

    #bottom_menu {
      margin: 0;
      position: absolute;
      bottom: 5%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
    }

    #top_menu {
      height: 70%;
      overflow-x: hidden;
      overflow-y: scroll;
    }

    .input_menu {
      border: solid;
      border-color: grey;
      background-color: black;
      margin-bottom: 1vh;
      font-size: 14px;
      border-radius: 0px;
      color: white;
      padding: 10px 20px 10px 20px;
    }

    .input_menu:focus {
      border-radius: 0px;
      outline: none;
      background-color: grey;
    }

    .button_menu {
      border: solid;
      -webkit-appearance: none;
      border-color: grey;
      background-color: grey;
      margin-bottom: 1vh;
      font-size: 16px;
      opacity: 0.97;
      font-weight: normal;
      border-radius: 0px;
      padding: 5px 10px;
      color: white;
      cursor: pointer;
    }

    .button_menu:hover {
      background-color: black;
    }
  </style>
  <link rel="shortcut icon" href="https://avatars.githubusercontent.com/u/83828188?v=4" type="img/vnd.microsoft.icon" />

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>

<body>
  <div id="mySidenav" class="sidenav">

    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <div id="top_menu">
      <?php
      for ($i = 0; $i < count($array_id); $i++) {
        echo "<a class='ht' style='padding:20px;' href='https://edu-chat.me?r=" . $array_id[$i] . "'>" . $array_name[$i] . "</a>";
      }
      ?>
    </div>
    <div id="bottom_menu">
      <form method="get" action="createRoom.php">
        <input placeholder="Room" class="input_menu" type="text" name="r" required> <br>
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