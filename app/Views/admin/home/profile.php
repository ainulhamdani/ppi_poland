<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <?php if($student): ?>
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <?php if ($student['photo']) { ?>
                    <img id="photo" src="<?php echo base_url().'/assets/uploads/profile_pictures/'.$student['photo']?>" alt="User profile picture" class="img-fluid">
                  <?php } else { ?>
                    <img class="profile-user-img img-fluid img-circle"
                         src="<?php echo base_url()?>/assets/theme/adminlte/img/avatar.png"
                         alt="User profile picture">
                  <?php } ?>

                </div>

                <h3 class="profile-username text-center"><?php echo $student['fullname']; ?></h3>

                <!-- <p class="text-muted text-center">Software Engineer</p> -->

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right"><?php echo $student['followers_count']?$student['followers_count']:0; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right"><?php echo $student['following_count']?$student['following_count']:0; ?></a>
                  </li>
                </ul>
                <?php if($student['user_id']!=$user_id): ?>
                  <?php if($student['follow']==null): ?>
                    <a id="follow_button" href="/home/follow_user/<?php echo $student['user_id']; ?>?follow=1" class="btn btn-primary btn-block"><b>Follow</b></a>
                  <?php else: ?>
                    <a id="unfollow_button" href="/home/follow_user/<?php echo $student['user_id']; ?>?follow=0" class="btn btn-danger btn-block"><b>Unfollow</b></a>
                  <?php endif; ?>
                <?php endif; ?>
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
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  <?php echo $student['major']; ?> from <?php echo $student['university_name']; ?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted"><?php echo $student['location_name']; ?>, <?php echo $student['parent_loc_name']; ?></p>

                <!-- <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Biography</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p> -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <?php endif; ?>

          <!-- /.col -->
          <div id="the_posts" data-id="<?php echo isset($student)?$student['user_id']:'1'; ?>" class="col-md-<?php echo $student?'9':'12' ?>">

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-delete">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-danger">
        <div class="modal-header">
          <h4 class="modal-title">Delete <span id="_name">Post</span>?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-outline-light" id="go_delete">Delete</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <?php \CodeIgniter\Events\Events::on('custom_script', function() { ?>
    <script type='text/javascript'>
      var post_count = 0;
      var total_count = 0;
      $( document ).ready(function() {
        var user_id = $( "#the_posts" ).data('id');
        $.get( "/home/get_post_count/"+user_id, function( data ) {
          total_count = data.post_count;
        }, "json" );
        $.get( "/home/get_posts/10/0/"+user_id, function( data ) {
          $( "#the_posts" ).append( data );
          attach_comment_event();
        });
        $(window).on('scroll', function() {
            if( $(window).scrollTop() + $(window).height() == $(document).height() && post_count < total_count) {
              post_count = post_count+10;
              $.get( "/home/get_posts/10/"+post_count+"/"+user_id, function( data ) {
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
                    $( "#comments_"+post_id ).append( data );
                });
              }
            }
            event.stopPropagation();
          });
        });
      }

      function get_comments(post_id){
        if($( "#comments_"+post_id ).hasClass('has-data')){
          $( "#comments_"+post_id ).toggle();
        } else {
          $.get( "/home/get_comments/"+post_id, function( data ) {
            if (data!='empty') {
              $( "#comments_"+post_id ).addClass('has-data');
              $( "#comments_"+post_id ).append( data );
              $( "#view_comments_"+post_id ).hide();
            }
          });
        }

      }

      function view_comments(post_id){
        $.get( "/home/get_comments/"+post_id, function( data ) {
          $( "#comments_"+post_id ).addClass('has-data');
          $( "#comments_"+post_id ).append( data );
          $( "#view_comments_"+post_id ).hide();
        });
      }

      function like_post(post_id){

      }

      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      $('#modal-delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var post_id = button.data('post-id')
        var title = button.data('header')
        var url = button.attr('href')
        var modal = $(this)
        modal.find('#_name').text(title)

        $('#go_delete').click(function() {
          $.post( url, { <?php echo csrf_token();?>: "<?php echo csrf_hash();?>", delete:true})
          .done(function( data ) {
            if (data=='success') {
              let comment_count = $( "#comment_count_"+post_id ).text();
              if (comment_count!="") {
                comment_count = parseInt(comment_count);
                $( "#comment_count_"+post_id ).text(comment_count-1);
              }
              $('#'+id).remove()
            } else if(data=='warning') {
              Toast.fire({
                icon: 'danger',
                title: 'You are not authorized to do this!'
              })
            } else {
              Toast.fire({
                icon: 'warning',
                title: 'Some error occurred. Try again.'
              })
            }

            modal.modal('hide');
          })
        })
      });
    </script>
  <?php });?>
