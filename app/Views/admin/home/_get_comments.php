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
