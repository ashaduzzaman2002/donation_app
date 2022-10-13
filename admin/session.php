<?php
//error_reporting(0);
include "function.inc.php";
include "../dbcon.php";
session_start();
session_regenerate_id();

if(isset($_COOKIE['admin_phone']) && $_COOKIE['admin_phone']!='' && isset($_COOKIE['admin_password']) && $_COOKIE['admin_password']!=''){
  $phone = getSafeValue($_COOKIE['admin_phone']);
  $md_password = getSafeValue($_COOKIE['admin_password']);

  $res = mysqli_query($conn, "Select * from admin where phone = '$phone' and password = '$md_password'");
  if(mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
      setcookie('admin_phone',$phone,time() + (86400 * 30), "/");
      setcookie('admin_password',$md_password,time() + (86400 * 30), "/");
      $_SESSION['admin_phone'] = $phone;
      $_SESSION['admin_password'] = $md_password;
      $_SESSION['admin_id'] = $row['id'];
      $_SESSION['admin_fullName'] = $row['fullname'];
    }
  }
  else{
    header("Location:index");
  }
}
elseif(isset($_SESSION['admin_phone']) && $_SESSION['admin_phone']!='' && isset($_SESSION['admin_password']) && $_SESSION['admin_password']!=''){
  $phone = getSafeValue($_SESSION['admin_phone']);
  $md_password = getSafeValue($_SESSION['admin_password']);

  $res = mysqli_query($conn, "Select * from admin where phone = '$phone' and password = '$md_password'");
  if(mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
      $_SESSION['admin_phone'] = $phone;
      $_SESSION['admin_password'] = $md_password;
      $_SESSION['admin_id'] = $row['id'];
      $_SESSION['admin_fullName'] = $row['fullname'];
    }
  }
  else{
    header("Location:index");
  }

}
else{
  header("Location:index");
}

?>