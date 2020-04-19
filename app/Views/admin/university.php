<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>University <a href="/admin/university/add" type="button" class="btn btn-primary"><i class="right fas fa-plus"></i> Add New</a></h1>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">University</li>
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
              <h3 class="card-title">List University</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="university_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>University Name</th>
                  <th>University Type</th>
                  <th>Website</th>
                  <th>Region</th>
                  <th>Location</th>
                  <th>#</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($universities as $university): ?>
                <tr>
                  <td><?php echo $university['name'] ?></td>
                  <td><?php echo $university['type'] ?></td>
                  <td><a target="_blank" href="<?php echo $university['website'] ?>"><?php echo $university['website'] ?></a></td>
                  <td><?php echo $university['region'] ?></td>
                  <td><?php echo $university['latlang'] ?></td>
                  <td><a href="/admin/university/edit/<?php echo $university['id'] ?>" type="button" class="btn-sm btn-block btn-warning">Edit</a></td>
                </tr>
              <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>University Name</th>
                  <th>University Type</th>
                  <th>Website</th>
                  <th>Region</th>
                  <th>Location</th>
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
