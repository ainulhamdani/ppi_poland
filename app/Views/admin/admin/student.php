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
                  <td><a href="/admin/student/delete/<?php echo $student['id'] ?>" type="button" class="btn-sm btn-block btn-danger" data-name="<?php echo $student['fullname'] ?>" data-id="<?php echo $student['id'] ?>" data-toggle="modal" data-target="#modal-delete">Del</a></td>
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

  <div class="modal fade" id="modal-delete">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-danger">
        <div class="modal-header">
          <h4 class="modal-title">Delete Student?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="_name"></p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-outline-light" id="go_delete">Delete</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <?php \CodeIgniter\Events\Events::on('custom_script', function() { ?>
  <script>
    $('#modal-delete').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var id = button.data('id')
      var name = button.data('name')
      var url = button.attr('href');

      var modal = $(this)
      modal.find('#_name').text(name)

      $('#go_delete').click(function() {
        $.post( url, { <?php echo csrf_token();?>: "<?php echo csrf_hash();?>"})
        .done(function( data ) {
          if (data=='success') {
            window.location = "/admin/student";
          }
        })
      })
    });


  </script>
  <?php });?>
