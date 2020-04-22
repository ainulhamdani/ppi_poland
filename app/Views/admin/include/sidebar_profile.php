 <?php
 $urls = explode('/',uri_string());
 ?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-danger elevation-4">
    <?php echo view('admin/include/sidebar_logo');  ?>

    <!-- Sidebar -->
    <div class="sidebar">
      <?php echo view('admin/include/sidebar_user');  ?>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php if($is_admin): ?>
          <li class="nav-item">
            <a href="/home" class="nav-link">
              <i class="nav-icon fas fa-arrow-left"></i>
              <p>
                Back to Home
              </p>
            </a>
          </li>
          <?php endif; ?>
          <li class="nav-item has-treeview <?php echo $urls[0]=='profile'?'menu-open':'' ?>">
            <a href="#" class="nav-link <?php echo $urls[0]=='profile'?'active':'' ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Profile
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/profile/photo" class="nav-link <?php echo $urls[1]=='photo'?'active':'' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Photo Profile </p>
                </a>
              </li>
              <?php if(!$is_admin): ?>
              <li class="nav-item">
                <a href="/profile/general" class="nav-link <?php echo $urls[1]=='general'?'active':'' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General Information</p>
                </a>
              </li>
            <?php endif; ?>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
