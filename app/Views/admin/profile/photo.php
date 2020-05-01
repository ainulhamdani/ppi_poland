<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Photo Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Photo Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">

        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-5 text-center mb-5">
              <?php if ($photo) { ?>
                <img id="photo" src="<?php echo base_url().'/assets/uploads/profile_pictures/'.$photo['name']?>" alt="" class="img-fluid" width="200">
              <?php } else { ?>
                <img id="photo" src="<?php echo base_url()?>/assets/theme/adminlte/img/avatar.png" alt="" class="img-fluid" width="200">
              <?php } ?>
            </div>
            <div class="col-12 col-md-7">
              <form id="photo_form" role="form" method="post" action="/profile/photo" enctype="multipart/form-data">
                  <?php if (isset($photo)) { ?>
                    <input id="user_id" name="id" type="hidden" value="<?php echo $photo['id'] ?>">
                  <?php } ?>
                  <div class="form-group">
                    <label for="exampleInputFile">Change Photo</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input name="photo_profile" type="file" class="custom-file-input" id="photofile" accept="image/png, image/jpeg" onchange="preview_image(event)" required>
                        <label class="custom-file-label" for="photofile">Choose photo</label>
                      </div>
                    </div>
                  </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php \CodeIgniter\Events\Events::on('custom_script', function() { ?>
  <script type='text/javascript'>
    function preview_image(event)
    {
       var reader = new FileReader();
       reader.onload = function()
       {
          var output = document.getElementById('photo');
          output.src = reader.result;
       }
       reader.readAsDataURL(event.target.files[0]);
    }
    $(function () {

      // console.log(user_id);
    });
    $('form').submit(function(event){
      event.preventDefault();
      let user_id = document.getElementById('user_id');
      let photo = document.getElementById("photofile").files[0];
      new ImageCompressor(photo, {
        maxWidth: 512,
        maxHeight: 512,
        convertSize: 0,
        quality: .9,
        success(result) {
          const formData = new FormData();
          formData.append('<?php echo csrf_token();?>', '<?php echo csrf_hash();?>');
          if (user_id) {
            formData.append('id', user_id.value);
          }
          formData.append('photo_profile', result, result.name);

          $.ajax({
            type: "POST",
            url: event.target.action,
            data: formData,
            success: function (data) {
                var reader = new FileReader();
                reader.onload = function()
                {
                   var output = document.getElementById('photo_sidebar');
                   output.src = reader.result;
                }
                reader.readAsDataURL(result);
                // console.log(data)
                window.location = "/profile/photo";
            },
            cache: false,
            contentType: false,
            processData: false
          });
        },
        error(e) {
          console.log(e.message);
        },
      });
    });
  </script>
<?php });?>
