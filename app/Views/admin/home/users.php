<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Students</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Students</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row" style="position: relative;">
          <div class="col-md-5">
            <form id="university-filter" method="get" action="/home/users">
              <div class="form-group">
                <label for="university">University</label>
                <select name="university_id" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="university" style="width: 100%;">
                  <option value=""> --- </option>
                  <?php foreach ($universities as $university) { ?>
                  <option value="<?php echo $university['id'] ?>" <?php echo isset($university_id)?($university['id']==$university_id?"selected":""):""; ?>><?php echo $university['name'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </form>
          </div>
          <div class="col-md-1 mb-3">
            <label class="d-none d-sm-block" for="filter">&nbsp</label>
            <button type="submit" form="university-filter" class="btn btn-primary">Filter</button>
          </div>
          <div class="col-md-5">
            <form id="location-filter" method="get" action="/home/users">
              <div class="form-group">
                <label for="location">Location</label>
                <select name="location_id" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="location" style="width: 100%;">
                  <option value=""> --- </option>
                  <?php foreach ($locations as $location) { ?>
                  <option value="<?php echo $location['id'] ?>" <?php echo isset($location_id)?($location['id']==$location_id?"selected":""):""; ?>><?php echo $location['parent_loc_name'].' - '.$location['name'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </form>
          </div>
          <div class="col-md-1 mb-3">
            <label class="d-none d-sm-block" for="filter">&nbsp</label>
            <button type="submit" form="location-filter" class="btn btn-primary">Filter</button>
          </div>
        </div>
        <div class="row">
          <?php foreach($students as $student): ?>
          <div class="col-md-3 mb-3">
            <!-- Widget: user widget style 1 -->
            <a href="/home/user/<?php echo $student['user_id'] ?>" >
              <div class="card card-widget widget-user h-100">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-danger">
                  <h3 class="widget-user-username"><?php echo $student['fullname'] ?></h3>
                  <!-- <h5 class="widget-user-desc">Founder &amp; CEO</h5> -->
                </div>
                <div class="widget-user-image">
                  <?php if ($student['photo']) { ?>
                    <img class="img-circle img-bordered-sm" src="<?php echo base_url().'/assets/uploads/profile_pictures/'.$student['photo']?>" alt="" style="object-fit: cover; width:90px;height:90px">
                  <?php } else { ?>
                    <img class="img-circle img-bordered-sm" src="<?php echo base_url()?>/assets/theme/adminlte/img/avatar.png" alt="user image">
                  <?php } ?>
                </div>
                <div class="card-footer" style="background:white">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="description-block" style="color:black">
                        <h5 class="description-header"><?php echo $student['university_name'] ?></h5>
                        <span class="description-text"><?php echo $student['location_name'] ?></span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
              </div>
            </a>
            <!-- /.widget-user -->
          </div>
          <?php endforeach; ?>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
