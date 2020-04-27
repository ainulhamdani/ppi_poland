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
         <li class="nav-item has-treeview <?php echo ($urls[1]=='university'||$urls[1]=='student'||$urls[1]=='kepengurusan'||$urls[1]=='jabatan'||$urls[1]=='pengurus')?'menu-open':'' ?>">
           <a href="#" class="nav-link <?php echo ($urls[1]=='university'||$urls[1]=='student'||$urls[1]=='kepengurusan'||$urls[1]=='jabatan'||$urls[1]=='pengurus')?'active':'' ?>">
             <i class="nav-icon fas fa-university"></i>
             <p>
               Student Affairs
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
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
         </li>
         <li class="nav-item has-treeview <?php echo ($urls[1]=='email_setting'||$urls[1]=='additional_form_setting')?'menu-open':'' ?>">
           <a href="#" class="nav-link <?php echo ($urls[1]=='email_setting'||$urls[1]=='additional_form_setting')?'active':'' ?>">
             <i class="nav-icon fas fa-window-maximize"></i>
             <p>
               Website Settings
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="/admin/email_setting" class="nav-link <?php echo $urls[1]=='email_setting'?'active':'' ?>">
                 <i class="nav-icon fas fa-envelope"></i>
                 <p>
                   Email
                 </p>
               </a>
             </li>
             <li class="nav-item">
               <a href="/admin/additional_form_setting" class="nav-link <?php echo $urls[1]=='additional_form_setting'?'active':'' ?>">
                 <i class="nav-icon fas fa-clipboard-list"></i>
                 <p>
                   Additional Info Field
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
