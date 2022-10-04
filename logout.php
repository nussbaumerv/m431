
<?php

session_start();

session_destroy();

//redirect page to index.php
header('location:login.php');

?>