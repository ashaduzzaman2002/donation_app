<?php
include "function.inc.php";
include "../dbcon.php";
include "../constant.inc.php";
session_start();
$err_msg = 'Login to start your session';

if(isset($_COOKIE['admin_username']) && $_COOKIE['admin_username']!='' && isset($_COOKIE['admin_password']) && $_COOKIE['admin_password']!=''){
  $username = getSafeValue($_COOKIE['admin_username']);
  $md_password = getSafeValue($_COOKIE['admin_password']);

  $res = mysqli_query($conn, "Select * from admin where username = '$username' and password = '$md_password'");
  if(mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
      $err_msg = "<span style = 'color: green;'>Credentials Accepted! Redirecting to Dashboard</span>";
      setcookie('admin_username',$username,time() + (86400 * 30), "/");
      setcookie('admin_password',$md_password,time() + (86400 * 30), "/");
      $_SESSION['admin_username'] = $username;
      $_SESSION['admin_password'] = $md_password;
      header("location:admin_dashboard.php");
    }
  }
  else{
    $err_msg = "<span style = 'color: red;'>Session Expired! Do login again</span>";
  }
}

elseif(isset($_SESSION['admin_username']) && $_SESSION['admin_username']!='' && isset($_SESSION['admin_password']) && $_SESSION['admin_password']!=''){
  $username = getSafeValue($_SESSION['admin_username']);
  $md_password = getSafeValue($_SESSION['admin_password']);

  $res = mysqli_query($conn, "Select * from admin where username = '$username' and password = '$md_password'");
  if(mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
      $err_msg = "<span style = 'color: green;'>Credentials Accepted! Redirecting to Dashboard</span>";
      setcookie('admin_username',$username,time() + (86400 * 30), "/");
      setcookie('admin_password',$md_password,time() + (86400 * 30), "/");
      $_SESSION['admin_username'] = $username;
      $_SESSION['admin_password'] = $md_password;
      header("location:admin_dashboard.php");
    }
  }
  else{
    $err_msg = "<span style = 'color: red;'>Session Expired! Do login again</span>";
  }
}


if(isset($_POST['sign_in_btn'])){
  $username = getSafeValue($_POST['username']);
  $password = getSafeValue($_POST['password']);
  $md_password = md5($password);
  $md_password = $password;

  $res = mysqli_query($conn, "Select * from admin where username = '$username' and password = '$md_password'");
  if(mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
      $err_msg = "<span style = 'color: green;'>Credentials Accepted! Redirecting to Dashboard</span>";
      if(isset($_POST['remember_me'])){
        setcookie('admin_username',$username,time() + (86400 * 30), "/");
        setcookie('admin_password',$md_password,time() + (86400 * 30), "/");
      }
      $_SESSION['admin_username'] = $username;
      $_SESSION['admin_password'] = $md_password;
      header("location:admin_dashboard.php");
    }
  }
  else{
    $err_msg = "<span style = 'color: red;'>Wrong Credentials</span>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index" class="h1"><b>Admin</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg"><?php echo $err_msg;?></p>

      <form method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="username" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" name="remember_me" id="remember_me">
              <label for="remember_me">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="sign_in_btn">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
