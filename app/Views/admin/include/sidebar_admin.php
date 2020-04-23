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
         <li class="nav-item">
           <a href="/admin/overview" class="nav-link <?php echo $urls[1]=='overview'?'active':'' ?>">
             <i class="nav-icon fas fa-th"></i>
             <p>
               Overview
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="/admin/university" class="nav-link <?php echo $urls[1]=='university'?'active':'' ?>">
             <i class="nav-icon fas fa-university"></i>
             <p>
               University
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="/admin/student" class="nav-link <?php echo $urls[1]=='student'?'active':'' ?>">
             <i class="nav-icon fas fa-users"></i>
             <p>
               Student
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="/admin/kepengurusan" class="nav-link <?php echo $urls[1]=='kepengurusan'?'active':'' ?>">
             <i class="nav-icon fas fa-business-time"></i>
             <p>
               Kepengurusan
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="/admin/jabatan" class="nav-link <?php echo $urls[1]=='jabatan'?'active':'' ?>">
             <i class="nav-icon fas fa-briefcase"></i>
             <p>
               Jabatan
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="/admin/pengurus" class="nav-link <?php echo $urls[1]=='pengurus'?'active':'' ?>">
             <i class="nav-icon fas fa-id-badge"></i>
             <p>
               Pengurus
             </p>
           </a>
         </li>
       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>
