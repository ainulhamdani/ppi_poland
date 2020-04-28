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

                <!-- <p class="text-muted text-center">Software Engineer</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li> -->
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
          <div class="col-md-<?php echo $student?'9':'12' ?>">
            <div class="card">
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
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
                  <?php endforeach; ?>

                  </div>

                </div>
                <!-- /.tab-content -->
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
