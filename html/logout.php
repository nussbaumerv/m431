
<?php

setcookie("token", "", time() - 3600);
setcookie("uid", "", time() - 3600);

//redirect page to index.php
header('location:login.php');

?>