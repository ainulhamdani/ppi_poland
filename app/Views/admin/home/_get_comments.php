<?php foreach($comments as $comment): ?>
  <div class="comment ml-3">
    <div class="user-block">
      <?php if ($comment['photo']) { ?>
        <img class="img-circle img-bordered-sm" src="<?php echo base_url().'/assets/uploads/profile_pictures/'.$comment['photo']?>" alt="" style="object-fit: cover;">
      <?php } else { ?>
        <img class="img-circle img-bordered-sm" src="<?php echo base_url()?>/assets/theme/adminlte/img/avatar.png" alt="user image">
      <?php } ?>
      <span class="username">
        <a href="/home/user/<?php echo $comment['user_id'] ?>"><?php echo $comment['fullname'] ?></a>
      </span>
      <span class="ml-2"><?php echo $comment['comment'] ?></span>
    </div>
  </div>
<?php endforeach; ?>
