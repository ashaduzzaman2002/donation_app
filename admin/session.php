<?php
//error_reporting(0);
include "function.inc.php";
include "../dbcon.php";
session_start();
session_regenerate_id();

if(isset($_COOKIE['admin_username']) && $_COOKIE['admin_username']!='' && isset($_COOKIE['admin_password']) && $_COOKIE['admin_password']!=''){
  $username = getSafeValue($_COOKIE['admin_username']);
  $md_password = getSafeValue($_COOKIE['admin_password']);

  $res = mysqli_query($conn, "Select * from admin where username = '$username' and password = '$md_password'");
  if(mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
      setcookie('admin_username',$username,time() + (86400 * 30), "/");
      setcookie('admin_password',$md_password,time() + (86400 * 30), "/");
      $_SESSION['admin_username'] = $username;
      $_SESSION['admin_password'] = $md_password;
      $_SESSION['admin_id'] = $row['id'];
      $_SESSION['admin_fullName'] = $row['fullname'];
    }
  }
  else{
    header("Location:index.php");
  }
}
elseif(isset($_SESSION['admin_username']) && $_SESSION['admin_username']!='' && isset($_SESSION['admin_password']) && $_SESSION['admin_password']!=''){
  $username = getSafeValue($_SESSION['admin_username']);
  $md_password = getSafeValue($_SESSION['admin_password']);

  $res = mysqli_query($conn, "Select * from admin where username = '$username' and password = '$md_password'");
  if(mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
      $_SESSION['admin_username'] = $username;
      $_SESSION['admin_password'] = $md_password;
      $_SESSION['admin_id'] = $row['id'];
      $_SESSION['admin_fullName'] = $row['fullname'];
    }
  }
  else{
    header("Location:index.php");
  }

}
else{
  header("Location:index.php");
}

?>