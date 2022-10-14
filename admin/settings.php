<?php include "header.php";
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Settings</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="dist/img/avatar5.png"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $_SESSION['admin_fullName'];?></h3>

                <p class="text-muted text-center"><?php echo Site_Name.' - Admin';?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Earning</b> <a class="float-right">₹ <?php echo $_SESSION['admin_wallet'];?></a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Username</strong>
                <p class="text-muted"><?php echo $_SESSION['admin_username'];?></p>
                <hr>
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Phone</strong>
                <p class="text-muted"><?php echo $_SESSION['admin_phone'];?></p>
                <hr>
                <strong><i class="fas fa-pencil-alt mr-1"></i> Email</strong>
                <p class="text-muted"><?php echo $_SESSION['admin_email'];?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#basic_details" data-toggle="tab">Basic Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="#change_password" data-toggle="tab">Change Password</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="basic_details">
                    <form class="form-horizontal" onsubmit="change_basic_details_func(); return false;">
                        <div class="form-group row">
                            <label for="fullname" class="col-sm-2 col-form-label">Fullname</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="fullname" placeholder="Fullname" required value="<?php echo $_SESSION['admin_fullName'];?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                            <input type="number" class="form-control" id="phone" placeholder="Phone" required value="<?php echo explode("+91", $_SESSION['admin_phone'])[1];?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email Id</label>
                            <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" placeholder="Email Id" required value="<?php echo $_SESSION['admin_email'];?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-danger">Save Changes</button>
                            </div>
                        </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="change_password">
                    <form class="form-horizontal" onsubmit="change_password_func(); return false;">
                      <div class="form-group row">
                        <label for="currentPassword" class="col-sm-4 col-form-label">Current Password</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="currentPassword" placeholder="Current Password" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="newPassword" class="col-sm-4 col-form-label">New Password</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="newPassword" placeholder="New Password" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="confirmPassword" class="col-sm-4 col-form-label">Confirm Password</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Save Changes</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include "footer.php";?>

  <script>
    function _(el){
        return document.getElementById(el);
    }

    function change_basic_details_func(){
        $.ajax({
        url: "../admin_apis/change_basic_details_api.php",
        type: "POST",
        data: {
          admin_id: "<?php echo $_SESSION['admin_id'];?>",
          fullname: _("fullname").value,
          phone: _("phone").value,
          email: _("email").value,
          password: "<?php echo $_SESSION['admin_password'];?>",
        },
        cache: false,
        success: function(dataResult){
          var response = JSON.parse(dataResult);
          if(response.error == true){
            $(document).Toasts('create', {
              class: 'bg-danger',
              title: 'Error Occurred',
              autohide: true,
              delay: 1000,
              body: response.message
            });
          } else{
            $(document).Toasts('create', {
              class: 'bg-success',
              title: 'Done',
              autohide: true,
              delay: 1000,
              body: response.message
            });
          }
        }
      });
    }

    function change_password_func(){
        $.ajax({
        url: "../admin_apis/change_password_api.php",
        type: "POST",
        data: {
          admin_id: "<?php echo $_SESSION['admin_id'];?>",
          currentPassword: _("currentPassword").value,
          newPassword: _("newPassword").value,
          confirmPassword: _("confirmPassword").value,
        },
        cache: false,
        success: function(dataResult){
          var response = JSON.parse(dataResult);
          if(response.error == true){
            $(document).Toasts('create', {
              class: 'bg-danger',
              title: 'Error Occurred',
              autohide: true,
              delay: 1000,
              body: response.message
            });
          } else{
            $(document).Toasts('create', {
              class: 'bg-success',
              title: 'Done',
              autohide: true,
              delay: 1000,
              body: response.message
            });
          }
        }
      });
    }
  </script>