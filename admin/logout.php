<?php
session_start();
setcookie('admin_phone','',time() - 3600, "/");
setcookie('admin_password','',time() - 3600, "/");
unset($_SESSION['admin_phone']);
unset($_SESSION['admin_password']);
session_regenerate_id(true);
header('Location:index');
exit();
?>
