<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark navbar-danger">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <a href="/" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"><?php echo count($notifications)>0?count($notifications):""; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <?php foreach($notifications as $notification):
          $options = explode(',',$notification['options']);
          $notifData = [];
          foreach ($options as $col) {
            $notifData[] = $notification[$col];
          }
          ?>
          <a id="notification_<?php echo $notification['id']; ?>" href="<?php vprintf($notification['url'],$notifData) ?>" data-id="<?php echo $notification['id']; ?>" class="dropdown-item notification">
            <p><?php vprintf($notification['content'],[$notification['from']]) ?></p>
            <span class="float-left text-muted text-sm"><?php echo $notification['created_at']; ?></span>
          </a>
          <div class="dropdown-divider mt-3"></div>
          <?php endforeach; ?>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="/profile" class="dropdown-item">
            <i class="fas fa-user-cog mr-2"></i> Profile Setting
          </a>
          <div class="dropdown-divider"></div>
          <a href="/auth/logout" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
