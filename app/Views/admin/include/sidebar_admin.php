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
