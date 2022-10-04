 <?php 
$host_name = 'localhost';
$user_name = 'phpmyadmin';
$password = 'SirO7799!';
$database = 'chat';

$connect = mysqli_connect($host_name, $user_name, $password, $database);
mysqli_query($connect, "SET NAMES 'utf8'");

if (!$connect) {
    echo "<script> alert('Es konnte keine Verbindung zum Server hergestellt werden.'); </script>";
}

?>