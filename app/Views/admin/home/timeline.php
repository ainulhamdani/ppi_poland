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
        <?php if(!$is_active): ?>
        <div class="row">
          <div class="col-sm-12 col-12">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <center>
                  <div style="font-weight:900; font-size:24px">Account not activated</div>
                  <div>You cannot post or comment</div>
                  <div>Please activate your account with the link that sent to your email</div>
                </center>
              </div>
              <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
              </div>
              <a href="/profile/general" class="small-box-footer">
                Update email <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
        </div>
        <?php endif; ?>
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
                        <input id="photofile" class="custom-file-input" name="post_photo" type="file" multiple accept="image/png, image/jpeg" />
                        <!-- <label class="custom-file-label" for="photofile">Choose photo</label> -->
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
          <div id="the_posts" class="col-md-12">

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
      var post_count = 0;
      var total_count = 0;
      $( document ).ready(function() {
        $.get( "/api/get_post_count", function( data ) {
          total_count = data.post_count;
        }, "json" );
        $.get( "/home/get_posts", function( data ) {
          $( "#the_posts" ).append( data );
          attach_comment_event();
        });
        $(window).on('scroll', function() {
            if( $(window).scrollTop() + $(window).height() == $(document).height() && post_count < total_count) {
              post_count = post_count+10;
              $.get( "/home/get_posts/10/"+post_count, function( data ) {
                $( "#the_posts" ).append( data );
                attach_comment_event();
              });
            }
        });
      });

      function attach_comment_event(){
        $('.comment_text:not(.enter-bound)').each(function(index){
          let post_id = $(this).data('post-id');
          let text_box = $(this);
          text_box.addClass('enter-bound');
          text_box.keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
              if ($.trim(text_box.val())!="") {
                let comment = text_box.val();
                $.post( "/home/add_comment", { <?php echo csrf_token();?>: "<?php echo csrf_hash();?>", post_id: post_id, comment: comment })
                  .done(function( data ) {
                    text_box.val('');
                    let comment_count = $( "#comment_count_"+post_id ).text();
                    if (comment_count!="") {
                      comment_count = parseInt(comment_count);
                      $( "#comment_count_"+post_id ).text(comment_count+1);
                    }
                    $( "#comment_"+post_id ).append( data );
                });
              }
            }
            event.stopPropagation();
          });
        });
      }

      function get_comments(post_id){
        if($( "#comment_"+post_id ).hasClass('has-data')){
          $( "#comment_"+post_id ).toggle();
        } else {
          $.get( "/home/get_comments/"+post_id, function( data ) {
            if (data!='empty') {
              $( "#comment_"+post_id ).addClass('has-data');
              $( "#comment_"+post_id ).append( data );
              $( "#view_comments_"+post_id ).hide();
            }
          });
        }

      }

      function view_comments(post_id){
        $.get( "/home/get_comments/"+post_id, function( data ) {
          $( "#comment_"+post_id ).addClass('has-data');
          $( "#comment_"+post_id ).append( data );
          $( "#view_comments_"+post_id ).hide();
        });
      }

      function like_post(post_id){

      }

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
                $.post( "/home/add_post", { <?php echo csrf_token();?>: "<?php echo csrf_hash();?>", content: content })
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
            formData.append('<?php echo csrf_token();?>', '<?php echo csrf_hash();?>');

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
