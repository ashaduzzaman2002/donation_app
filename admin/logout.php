<?php
session_start();
setcookie('admin_username','',time() - 3600, "/");
setcookie('admin_password','',time() - 3600, "/");
unset($_SESSION['admin_username']);
unset($_SESSION['admin_password']);
session_regenerate_id(true);
header('Location:index.php');
exit();
?>
