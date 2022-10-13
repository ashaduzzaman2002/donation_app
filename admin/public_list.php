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
                  
                      <!-- <tr>
                        <td><?php echo $value['id'];?></td>
                        <td><img src="../assets/blog_images/<?php echo $value['cover_img'];?>" height="50px" width="100px" loading='lazy'/></td>
                        <td><?php echo substr($value['title'], 0, 50).'...';?></td>
                        <td><?php echo $value['category'];?></td>
                        <td><?php echo date('jS M Y h:i', strtotime($value['updated_on']));?></td>
                        <td><?php echo $value['status'];?></td>
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-info">Action</button>
                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <form id="blog_article_form<?php echo $value['id'];?>" method="POST" action="dataProcess">
                              <div class="dropdown-menu" role="menu">
                                <button type="submit" class="dropdown-item" name="activeArticle" form="blog_article_form<?php echo $value['id'];?>" value="<?php echo $value['id'];?>">Active</button>
                                <button type="submit" class="dropdown-item" name="draftArticle" form="blog_article_form<?php echo $value['id'];?>" value="<?php echo $value['id'];?>">Draft</button>
                                <button type="button" class="dropdown-item" onclick="location.href=('update_article?bid=<?php echo $value['id'];?>');">Update</button>
                                <div class="dropdown-divider"></div>
                                <button type="submit" class="dropdown-item" name="deleteArticle" form="blog_article_form<?php echo $value['id'];?>" value="<?php echo $value['id'];?>" onclick="return confirm('Are you sure to delete the News?');">Delete</button>
                              </div>
                            </form>
                          </div>
                        </td>
                      </tr> -->
                    
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