<div class="content-wrapper" style="min-height: 1244.06px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>General Information</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Profile</a></li>
              <li class="breadcrumb-item active">General</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="/profile/general">
                <?php echo csrf_field() ?>
                <?php if (isset($student['id'])) { ?>
                  <input name="id" type="hidden" value="<?php echo $student['id'] ?>">
                <?php } ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Student Fullname</label>
                    <input name="fullname" type="text" class="form-control" id="name" value="<?php echo isset($student['fullname'])?$student['fullname']:'' ?>" placeholder="Enter Student Fullname" required>
                  </div>
                  <div class="form-group">
                    <label for="nickname">Student Nickname</label>
                    <input name="nickname" type="text" class="form-control" id="nickname" value="<?php echo isset($student['nickname'])?$student['nickname']:'' ?>" placeholder="Enter Student Nickname" required>
                  </div>
                  <div class="form-group">
                    <label for="type">Student Email</label>
                    <input name="email" type="email" class="form-control" id="name" value="<?php echo isset($student['email'])?$student['email']:'' ?>" placeholder="Enter Student Email" required>
                  </div>
                  <div class="form-group">
                    <label for="university">University</label>
                    <select name="university_id" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="university" style="width: 100%;">
                      <option value=""> --- </option>
                      <?php foreach ($universities as $university) { ?>
                      <option value="<?php echo $university['id'] ?>" <?php echo $university['name']==$student['university_name']?"selected":""; ?>><?php echo $university['name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="major">Major</label>
                    <input name="major" list="majors" type="text" class="form-control" id="major" value="<?php echo isset($student['major'])?$student['major']:'' ?>" placeholder="Enter Student Major" required>
                    <datalist id="majors">
                      <?php foreach ($majors as $major) { ?>
                      <option><?php echo $major['major'] ?></option>
                      <?php } ?>
                    </datalist>
                  </div>
                  <div class="form-group">
                    <label for="location">Town</label>
                    <select name="location_id" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="location" style="width: 100%;">
                      <option value=""> --- </option>
                      <?php foreach ($locations as $location) { ?>
                      <option value="<?php echo $location['id'] ?>" <?php echo $location['id']==$student['location_id']?"selected":""; ?>><?php echo $location['parent_loc_name'].' - '.$location['name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input name="start_date" type="date" class="form-control" id="start_date" value="<?php echo isset($student['start_date'])?$student['start_date']:'' ?>" placeholder="Enter Start Date">
                  </div>
                  <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input name="end_date" type="date" class="form-control" id="end_date" value="<?php echo isset($student['end_date'])?$student['end_date']:'' ?>" placeholder="Enter End Date">
                  </div>
                  <div class="form-group">
                    <label for="status">Student Status</label>
                    <select name="student_status_id" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="status" style="width: 100%;">
                      <option value=""> --- </option>
                      <?php foreach ($statuses as $status) { ?>
                      <option value="<?php echo $status['id'] ?>" <?php echo $status['description']==$student['student_status']?"selected":""; ?>><?php echo $status['description'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
