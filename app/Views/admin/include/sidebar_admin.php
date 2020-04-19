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
         <li class="nav-item">
           <a href="/admin/overview" class="nav-link <?php echo $urls[1]=='overview'?'active':'' ?>">
             <i class="nav-icon fas fa-th"></i>
             <p>
               Overview
             </p>
           </a>
         </li>
         <li class="nav-item has-treeview <?php echo $urls[1]=='university'?'menu-open':'' ?>">
           <a href="/admin/university" class="nav-link <?php echo $urls[1]=='university'?'active':'' ?>">
             <i class="nav-icon fas fa-university"></i>
             <p>
               University
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="/admin/university" class="nav-link <?php echo $urls[1]=='university'&&!isset($urls[2])?'active':'' ?>">
                 <i class="fas fa-list nav-icon"></i>
                 <p>University List</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="/admin/university/add" class="nav-link <?php echo $urls[1]=='university'&&isset($urls[2])?($urls[2]=='add'?'active':''):'' ?>">
                 <i class="fas fa-plus nav-icon"></i>
                 <p>
                   Add New University
                 </p>
               </a>
             </li>
           </ul>
         </li>
         <li class="nav-item has-treeview <?php echo $urls[1]=='student'?'menu-open':'' ?>">
           <a href="/admin/student" class="nav-link <?php echo $urls[1]=='student'?'active':'' ?>">
             <i class="nav-icon fas fa-users"></i>
             <p>
               Student
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="/admin/student" class="nav-link <?php echo $urls[1]=='student'&&!isset($urls[2])?'active':'' ?>">
                 <i class="fas fa-list nav-icon"></i>
                 <p>Student List</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="/admin/student/add" class="nav-link <?php echo $urls[1]=='student'&&isset($urls[2])?($urls[2]=='add'?'active':''):'' ?>">
                 <i class="fas fa-plus nav-icon"></i>
                 <p>
                   Add New Student
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
