<?php if(count($posts)==0): ?>
<div class="card">
  <div class="card-body">There is no post yet.</div>
</div>
<?php endif; ?>
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

      </div>
      <?php if($post['comment_count']):?>
      <span id="view_comments_<?php echo $post['id'] ?>">
        <a class="link-black text-sm" onclick="view_comments(<?php echo $post['id'] ?>)" style="cursor:pointer">
          View comments
        </a>
      </span>
      <?php endif; ?>
      <input data-post-id="<?php echo $post['id'] ?>" class="comment_text form-control form-control-sm" type="text" placeholder="Type a comment">
    </div>
  </div><!-- /.card-body -->
</div>
<!-- /.post -->
<?php endforeach; ?>
