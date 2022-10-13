<!-- JAI JAI SHREE RADHEKRISHN -->
<?php 
include "session.php";
include "../constant.inc.php";
$script_filename =  explode('/',$_SERVER['SCRIPT_FILENAME']);
$curr_path = $script_filename[count($script_filename)-1];

$dashboard_active = '';


if($curr_path == 'admin_dashboard' || $curr_path == 'admin_dashboard.php'){
  $dashboard_active = "active";
}
// Articles and Videos Content
elseif($curr_path == 'new_article' || $curr_path == 'new_article.php'){
  $new_article = "active";
  $articleCorner_active = "menu-is-opening menu-open";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo strtoupper(Site_Name)?> | Dashboard</title>
  <link rel="icon" href="../assets/img/favicon.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style type="text/css">
    .img_prop100{
      position: relative; overflow: hidden; height: 100px; width: 100px; max-height: 100px; max-width: 100px;
    }
    .roundImg{border-radius: 50%; height: 50px; width: 50px;}
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="admin_dashboard" class="nav-link">Home</a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="admin_dashboard.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['admin_fullName'];?></a>
        </div>
      </div>
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="admin_dashboard.php" class="nav-link <?php echo $dashboard_active;?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>


          <!-- <li class="nav-header">Public</li>
          <li class="nav-item <?php echo $articleCorner_active;?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Registered Public
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="new_article" class="nav-link <?php echo $new_article;?>">
                  <i class="fas fa-university nav-icon"></i>
                  <p>New Article</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="articles_list" class="nav-link <?php echo $articles_list;?>">
                  <i class="fas fa-info-circle nav-icon"></i>
                  <p>Articles List</p>
                </a>
              </li>
            </ul>
          </li> -->

          <!-- <li class="nav-item <?php echo $videoCorner_active;?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                YouTube Videos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="new_video" class="nav-link <?php echo $new_video;?>">
                  <i class="fas fa-university nav-icon"></i>
                  <p>New Video</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="videos_list" class="nav-link <?php echo $videos_list;?>">
                  <i class="fas fa-info-circle nav-icon"></i>
                  <p>Videos List</p>
                </a>
              </li>
            </ul>
          </li> -->

          <li class="nav-header">Public</li>
          <li class="nav-item">
            <a href="public_list.php" class="nav-link <?php echo $admins_list;?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Registered Public
              </p>
            </a>
          </li>

          

          <li class="nav-header">Important Tools</li>
          
          <li class="nav-item">
            <a href="https://localhost/donation_web" target="blank" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Visit Website
              </p>
            </a>
          </li>
          <li class="nav-header">Others</li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
