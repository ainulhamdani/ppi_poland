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
                    <b>Followers</b> <a class="float-right">0</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">0</a>
                  </li>
                </ul>

                <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
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
            <?php foreach($posts as $post): ?>
            <!-- Post -->
            <div id="post_<?php echo $post['id'] ?>" class="card">
              <div class="card-body">
                <div class="post">
                  <div class="user-block">
                    <?php if ($post['photo']) { ?>
                      <img class="img-circle img-bordered-sm" src="<?php echo base_url().'/assets/uploads/profile_pictures/'.$post['photo']?>" alt="" style="object-fit: cover;">
                    <?php } else { ?>
                      <img class="img-circle img-bordered-sm" src="<?php echo base_url()?>/assets/theme/adminlte/img/avatar.png" alt="user image">
                    <?php } ?>
                    <?php if($post['user_id']==$user_id): ?>
                      <div class="card-tools float-right">
                        <a href="/home/delete_post/<?php echo $post['id'] ?>" type="button" class="btn bg-light btn-sm" data-header="Post" data-id="post_<?php echo $post['id'] ?>" data-toggle="modal" data-target="#modal-delete">
                          <i class="fas fa-times"></i>
                        </a>
                      </div>
                    <?php endif; ?>
                    <span class="username">
                      <a href="/home/user/<?php echo $post['user_id'] ?>"><?php echo $post['fullname'] ?></a>
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
                  <hr>
                  <p>
                    <a onclick="like_post(<?php echo $post['id'] ?>)" class="link-black text-sm" style="cursor:pointer">&nbsp</a>
                    <span class="float-right">
                      <a class="link-black text-sm" onclick="get_comments(<?php echo $post['id'] ?>)" style="cursor:pointer">
                        <i class="far fa-comments mr-1"></i> <span id="comment_count_<?php echo $post['id'] ?>"><?php echo $post['comment_count']?$post['comment_count']:0 ?></span> Comments
                      </a>
                    </span>
                  </p>

                  <div id="comments_<?php echo $post['id'] ?>">
                    <?php foreach($comments as $comment): ?>
                      <div id="comment_<?php echo $comment['id'] ?>" class="card pt-2">

                        <div class="comment ml-3">
                          <div class="user-block">
                            <?php if ($comment['photo']) { ?>
                              <img class="img-circle img-bordered-sm" src="<?php echo base_url().'/assets/uploads/profile_pictures/'.$comment['photo']?>" alt="" style="object-fit: cover;">
                            <?php } else { ?>
                              <img class="img-circle img-bordered-sm" src="<?php echo base_url()?>/assets/theme/adminlte/img/avatar.png" alt="user image">
                            <?php } ?>
                            <?php if($comment['user_id']==$user_id): ?>
                              <div class="card-tools float-right">
                                <a href="/home/delete_comment/<?php echo $comment['id'] ?>" type="button" class="btn bg-light btn-sm" data-header="Comment" data-id="comment_<?php echo $comment['id'] ?>" data-post-id="<?php echo $comment['post_id'] ?>" data-toggle="modal" data-target="#modal-delete">
                                  <i class="fas fa-times"></i>
                                </a>
                              </div>
                            <?php endif; ?>
                            <span class="username">
                              <a href="/home/user/<?php echo $comment['user_id'] ?>"><?php echo $comment['fullname'] ?></a>
                            </span>
                            <span class="ml-2"><?php echo $comment['comment'] ?></span>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                  <input data-post-id="<?php echo $post['id'] ?>" class="comment_text form-control form-control-sm" type="text" placeholder="Type a comment">
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.post -->
            <?php endforeach; ?>
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
