<?php include "header.php";
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gallery Images</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Gallery Images</li>
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
        <form class="form-horizontal" onsubmit="upload_gallery_image(); return false;">
          <div class="form-group">
            <label for="caption">Caption</label>
            <input type="text" class="form-control" id="caption" placeholder="Caption" required>
          </div>
          <div class="form-group">
            <label for="gallery_photo">File input (1920px x 520px recomm.)</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="gallery_photo" required>
                <label class="custom-file-label" for="gallery_photo">Choose file</label>
              </div>
              <div class="input-group-append">
                <input type="submit" value="Upload" class="input-group-text">
              </div>
            </div>
          </div>
        </form>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.card -->

      <div class="row" id="imageRowField">
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Progress Modal -->
  <div class="modal fade" id="progress_modal">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Uploading Gallery photo. Please keep patience.</h4>
          </div>
          <div class="modal-body">
            <div class="progress">
              <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" id="blog_progress" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <p style="text-align: center;" id='progress_status'>Almost Done</p>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: none;" id="modal_disbtn">Ok</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

  <?php include "footer.php";?>

  <script>
    function _(el){
      return document.getElementById(el);
    }
    fetch_gallery_images();
    function fetch_gallery_images(){
      $.ajax({
        url: "../admin_apis/get_gallery_list_api.php",
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
            _("imageRowField").insertAdjacentHTML('afterbegin', "<div class=\"col-md-6\"><div class=\"card card-widget\"><div class=\"card-header\"><div class=\"user-block\"><span>"+dataRow.caption+"</span></div><div class=\"card-tools\"><button type=\"button\" class=\"btn btn-tool\" data-card-widget=\"collapse\"><i class=\"fas fa-minus\"></i></button><button type=\"button\" onclick=\"delete_gallery_image('"+dataRow.id+"')\" class=\"btn btn-tool\" data-card-widget=\"remove\"><i class=\"fas fa-trash\"></i></button></div></div><div class=\"card-body\"><p>"+dataRow.caption+"</p><img class=\"img-fluid pad\" src=\""+dataRow.photo+"\" alt=\"Photo\"></div></div><div>");
          }
        }
      });
    }

    function upload_gallery_image(){
      var fi =_('gallery_photo'); 
      var file_len = fi.files.length;
      file_name = fi.files[0].name;
      var file_size = (fi.files[0].size / 1024 / 1024).toFixed(2); 
      var file_type = file_name.slice((file_name.lastIndexOf(".") - 1 >>> 0) + 2);
      var allowed_vid_ext = ["jpeg", "jpg", "png", "webp"];
      //alert(file_len+', '+file_name+', '+file_size+', '+file_type);
      if( file_len == 1 && file_size <= 5.00 && allowed_vid_ext.includes(file_type) ){
        // $("#publishBlog").attr("disabled", "disabled");
        // $("#draftBlog").attr("disabled", "disabled");
        var file = _("gallery_photo").files[0];
        var formdata = new FormData();
        formdata.append("gallery_photo", file);
        formdata.append("caption", _("caption").value);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.open("POST", "../admin_apis/upload_gallery_image_api.php");
        ajax.send(formdata);
        _("modal_disbtn").style.display = 'none';
        $("#progress_modal").modal({backdrop: 'static',keyboard: false});
      }
      else{
        alert("Upload Image File of maximum 5 mb !");
      }
    }//);
    function progressHandler(event){
      var percent = (event.loaded / event.total) * 100;
      _("blog_progress").style.width = percent+'%';
    }
    function completeHandler(event){
      var response = JSON.parse(event.target.responseText);
      if(response.error == false){
        _("blog_progress").className = 'progress-bar progress-bar-striped bg-success';
        _("progress_status").innerHTML = response.message;
        setTimeout(function () { location.reload(true); }, 1000); 
      }
      else{
        _("blog_progress").className = 'progress-bar progress-bar-striped bg-danger';
        _("progress_status").innerHTML = response.message;
        _("modal_disbtn").style.display = 'block';
      }
    }
    function errorHandler(event){
      alert("Status : Upload Failed");
    }

    function delete_gallery_image(imageId){
      $.ajax({
        url: "../admin_apis/delete_gallery_image_api.php",
        type: "POST",
        data: {
          scriptPassword: 'SaltedPassword',
          imageId: imageId,
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