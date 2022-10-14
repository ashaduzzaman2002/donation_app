<?php include "header.php";
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registered Public</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Registered Public</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
        </div>
        <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>DP</th>
                  <th>Fullname</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Registered on</th>
                </tr>
                </thead>
                <tbody id="dataRowField">
                  <tr></tr>
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>DP</th>
                  <th>Fullname</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Registered on</th>
                </tr>
                </tfoot>
              </table>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include "footer.php";?>

  <script>
    function _(el){
      return document.getElementById(el);
    }
    get_registered_publics();
    function get_registered_publics(){
      $.ajax({
        url: "../admin_apis/get_public_list_api.php",
        type: "POST",
        data: {
          scriptPassword: 'SaltedPassword',
        },
        cache: false,
        success: function(dataResult){
          var response = JSON.parse(dataResult);
          // alert(JSON.parse(response.response).length);
          var tableData = JSON.parse(response.response);
          var dataLength = tableData.length;
          for(let i = 0; i < dataLength; i++){
            var dataRow = tableData[i];
            _("dataRowField").insertAdjacentHTML('afterbegin', "<tr><td>"+dataRow.id+"</td><td><img src='"+dataRow.photo+"' height=\"50px\" width=\"50px\" loading='lazy'/></td><td>"+dataRow.fullname+"</td><td>"+dataRow.address+', '+dataRow.pincode+"</td><td>"+dataRow.email+', '+dataRow.phone+"</td><td>"+dataRow.registered_on+"</td>");
          }
          // _("dataRowField").insertAdjacentHTML('afterbegin','End of Data');
        }
      });
    }
  </script>