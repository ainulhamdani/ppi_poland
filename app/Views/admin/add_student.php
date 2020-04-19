<div class="content-wrapper" style="min-height: 1244.06px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Student</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item"><a href="#">Student</a></li>
              <li class="breadcrumb-item active">Add</li>
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
              <div class="card-header">
                <h3 class="card-title">Add New Student</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="/admin/student/add">
                <?php if (isset($student['id'])) { ?>
                  <input name="id" type="hidden" value="<?php echo $student['id'] ?>">
                <?php } ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Student Fullname</label>
                    <input name="fullname" type="text" class="form-control" id="name" value="<?php echo isset($student['fullname'])?$student['fullname']:'' ?>" placeholder="Enter Student Fullname" required>
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
                      <option value="<?php echo $university['id'] ?>"><?php echo $university['name'] ?></option>
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
                      <option value="<?php echo $status['id'] ?>"><?php echo $status['description'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
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
