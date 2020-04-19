 <?php
 $urls = explode('/',uri_string());
 ?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-danger elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url()?>" class="brand-link">
      <img src="<?php echo base_url()?>/android-icon-144x144.png" alt="PPI Polandia Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">PPI Polandia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url()?>/assets/theme/adminlte/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $username; ?></a>
        </div>
      </div>

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
                <a href="/profile/general" class="nav-link <?php echo $urls[1]=='general'?'active':'' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/profile/university" class="nav-link <?php echo $urls[1]=='university'?'active':'' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    University
                  </p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
