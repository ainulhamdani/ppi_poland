
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <?php if ($photo) { ?>
        <img id="photo_sidebar" src="<?php echo base_url().'/assets/uploads/profile_pictures/'.$photo['name']?>" alt="" class="img-circle elevation-2" style="object-fit: cover; width:35px;height:35px">
      <?php } else { ?>
        <img id="photo_sidebar" src="<?php echo base_url()?>/assets/theme/adminlte/img/avatar.png" class="img-circle elevation-2" alt="User Image">
      <?php } ?>
    </div>
    <div class="info">
      <a href="/home/user/<?php echo $user_id; ?>" class="d-block"><?php echo $username; ?></a>
    </div>
  </div>
