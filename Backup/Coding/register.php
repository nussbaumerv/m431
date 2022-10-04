<script src="https://www.google.com/recaptcha/enterprise.js?render=6Ldv_OwdAAAAAJmyyZCsd0JaG0E4cdISgqjE6eEb"></script>
<script>
grecaptcha.enterprise.ready(function() {
    grecaptcha.enterprise.execute('6Ldv_OwdAAAAAJmyyZCsd0JaG0E4cdISgqjE6eEb', {action: 'login'}).then(function(token) {
       ...
    });
});
</script>
<?php
include "connect.php";
include("social-login/config-register.php");
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql_select = "SELECT * FROM users WHERE email = '$email'";
    $result_select = mysqli_query($connect, $sql_select);
    $row = mysqli_fetch_assoc($result_select);
    
    
            if($row['email'] != false) {
            echo '<br>Diese E-Mail-Adresse ist bereits vergeben';
            }
            else{
    
    
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
   $result = mysqli_query($connect, $sql);
   if($result){
    header("login.php");
   }
   else{
       echo "Something went wrong";
   }
            }
    
}
?>
<html>
    <head>
            <html lang="en">
    <meta charset="utf-8"/>
    <title>V-Todo</title>
    <link rel="apple-touch-icon" sizes="128x128" href="icon.png">
    <link rel="shortcut icon" href="icon.png" type="img/vnd.microsoft.icon"/>
    <link rel="manifest" href="manifest.webmanifest">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body{
            background-color: #dbdbdb;
            font-family: arial;
            margin: 0px;
            text-align:center;
            }
            input[type="email"], input[type="password"]{
            border: solid;
            border-color: grey;
            margin-bottom: 1vh;
            font-size: 16px;
            opacity: 0.97;
            border-radius: 0px;
            color: grey;
            padding: 20px 70px 20px 40px ;
            box-shadow: 5px 10px 18px #888888;
            }
            
             input[type="email"]:focus, input[type="password"]:focus {           
            border-radius: 0px;
            outline: none;
            background-color: rgb(220, 220, 220);
            box-shadow: 2px 4px 6px #888888;
             }
             
            #button {
            border: solid;
            -webkit-appearance: none;
            border-color: grey;
            background-color: rgb(209, 209, 209);
            margin-bottom: 1vh;
            font-size: 16px;
            opacity: 0.97;
            font-weight:normal;
            border-radius: 0px;
            padding: 10px 30px;
            color: grey;
            cursor: pointer;
            box-shadow: 2.5px 5px 9px #888888;
        }
        
        #button:hover {
            background-color: rgb(190, 190, 190);
        }
        
        #button:active {
            box-shadow: none;
        }
        h1{
        color: rgb(100, 100, 100);
        }
        
        .bottom{
            position:absolute;
            bottom:10px;
            left:10px;
            text-decoration:none;
        }
        vc{
            color:red;
        }
        </style>
        
    </head>
    <body>
        <br>
        <h1>Registrieren</h1>
        <form action="" method="post">
        <input  name="email" type="email" placeholder="Email"> <br>
        <input  name="password" type="password" placeholder="Password"> <br>
        <input id="button" name="submit" type="submit">
        </form>
    <br>
    ––– OR –––
    <br>
    <br>

                <?php   echo '<a href="'.$google_client->createAuthUrl().'"><img src="btn_google_signin_light_normal_web.png"></a>'; ?>

        <a class="bottom" id="button" href="login.php">Login</a>

    </body>
</html>