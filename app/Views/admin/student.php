<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Student <a href="/admin/student/add" type="button" class="btn btn-primary"><i class="right fas fa-plus"></i> Add New</a></h1>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Student</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">List Student</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="student_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>University</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Status</th>
                  <th>#</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                  <td><?php echo $student['fullname'] ?></td>
                  <td><?php echo $student['email'] ?></td>
                  <td><?php echo $student['university_name'] ?></td>
                  <td><?php echo $student['start_date'] ?></td>
                  <td><?php echo $student['end_date'] ?></td>
                  <td><?php echo $student['student_status'] ?></td>
                  <td><a href="/admin/student/edit/<?php echo $student['id'] ?>" type="button" class="btn-sm btn-block btn-warning">Edit</a></td>
                </tr>
              <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Student Name</th>
                  <th>Email</th>
                  <th>University</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Status</th>
                  <th>#</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
