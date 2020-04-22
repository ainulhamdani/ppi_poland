<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Timeline</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Timeline</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form id="post_form" action="/home/add_post" method="post" enctype="multipart/form-data">
                  <div class="">
                    <textarea id="content" class="form-control" name="content" rows="2" placeholder="Share your thoughts ..."></textarea>
                    <div id="dropzone"  class="dropzone">
                      <div class="fallback">
                        <input id="photofile" class="custom-file-input" name="post_photo" type="file" multiple accept="image/x-png, image/jpeg" />
                        <label class="custom-file-label" for="photofile">Choose photo</label>
                      </div>
                    </div>
                    <button id="add_photo" class="btn btn-block btn-secondary">Add Photo</button>
                    <button id="add_cancel" class="btn btn-block btn-danger">Cancel</button>
                    <button type="submit" id="submit_button" class="btn btn-block btn-primary">Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <!-- <?php var_dump($posts); ?> -->
                <?php foreach($posts as $post): ?>
                <!-- Post -->
                <div class="post">
                  <div class="user-block">
                    <?php if ($post['photo']) { ?>
                      <img class="img-circle img-bordered-sm" src="<?php echo base_url().'/assets/uploads/profile_pictures/'.$post['photo']?>" alt="" style="object-fit: cover;">
                    <?php } else { ?>
                      <img class="img-circle img-bordered-sm" src="<?php echo base_url()?>/assets/theme/adminlte/img/avatar.png" alt="user image">
                    <?php } ?>
                    <span class="username">
                      <a href="/home/user/<?php echo $post['id'] ?>"><?php echo $post['fullname'] ?></a>
                    </span>
                    <span class="description"><?php echo $post['created_at'] ?></span>
                  </div>
                  <!-- /.user-block -->

                  <?php if($post['attach_count']): ?>
                  <div class="row mb-3">
                    <?php
                    $attachments = explode(',',$post['attachment']);
                    foreach($attachments as $attachment):
                    ?>
                    <div class="col-sm-6">
                      <img class="img-fluid mb-3" src="<?php echo base_url()?>/assets/uploads/posts/<?php echo $post['user_id'] ?>/<?php echo $attachment?>" alt="Photo">
                    </div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>

                  <p>
                    <?php echo $post['content'] ?>
                  </p>

                  <p>
                    <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a> <?php echo $post['likes_count']?' - '.$post['likes_count'].' people like this':'' ?>
                    <span class="float-right">
                      <a href="#" class="link-black text-sm">
                        <i class="far fa-comments mr-1"></i> Comments (<?php echo $post['comment_count']?$post['comment_count']:'0' ?>)
                      </a>
                    </span>
                  </p>

                  <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                </div>
                <!-- /.post -->
              <?php endforeach; ?>

              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php \CodeIgniter\Events\Events::on('custom_script', function() { ?>
    <script type='text/javascript'>
      var i = 1;
      var dropzoneDisabled = true;
      Dropzone.options.dropzone = {
        addRemoveLinks: true,
        dictDefaultMessage: 'Click to choose or drop your image',
        uploadMultiple: true,
        resizeQuality: 0.5,
        maxFiles: 5,
        parallelUploads: 5,
        acceptedFiles: 'image/png, image/jpeg',
        url: "/home/add_post",
        autoProcessQueue: false,
        paramName: "post_photo",
        maxFilesize: 10,
        init: function () {
          let myDropzone = this;

          // Update selector to match your button
          $("#submit_button").click(function (e) {
            e.preventDefault();
            let content = $.trim($("#content").val())
            if (!dropzoneDisabled) {
              myDropzone.processQueue();
            } else {
              if (content!='') {
                $.post( "/home/add_post", { content: content })
                  .done(function( data ) {
                    $("#content").val('');
                    console.log( "Data Loaded: " + data );
                    location.reload();
                })
              }
            }
          });

          $("#add_photo").click(function (e) {
            e.preventDefault();
            dropzoneDisabled = false;
            myDropzone.enable();
            $("#dropzone").show();
            $("#add_cancel").show();
            $(this).hide();
          });

          $("#add_cancel").click(function (e) {
            e.preventDefault();
            dropzoneDisabled = true;
            myDropzone.disable();
            $("#dropzone").hide();
            $("#add_photo").show();
            $(this).hide();
          });

          this.on('sending', function(file, xhr, formData) {
            // Append all form inputs to the formData Dropzone will POST
            var data = $('#post_form').serializeArray();
            $.each(data, function(key, el) {
                formData.append(el.name, el.value);
          });

          this.on('success', function(e, data) {
            // this.removeAllFiles();
            console.log( i + ". Data Loaded: " );
            i = i+1;
            location.reload();
          });
        });
        },
      };
      var myDropzone = new Dropzone("#dropzone", (Dropzone.options.dropzone));
      myDropzone.disable();
      $("#dropzone").hide();
      $("#add_cancel").hide();
    </script>
  <?php });?>
