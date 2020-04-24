<div class="content-wrapper" style="min-height: 1244.06px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Kepengurusan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item"><a href="#">Kepengurusan</a></li>
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
                <h3 class="card-title">Add New Kepengurusan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="/admin/kepengurusan/add">
                <?php echo csrf_field() ?>
                <?php if (isset($kepengurusan['id'])) { ?>
                  <input name="id" type="hidden" value="<?php echo $kepengurusan['id'] ?>">
                <?php } ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Kepenguruan Name</label>
                    <input name="name" type="text" class="form-control" id="name" value="<?php echo isset($kepengurusan['name'])?$kepengurusan['name']:'' ?>" placeholder="Enter Kepengurusan Name" required>
                  </div>
                  <div class="form-group">
                    <label for="periode_start">Periode Start</label>
                    <input name="periode_start" type="date" class="form-control" id="periode_start" value="<?php echo isset($kepengurusan['periode_start'])?$kepengurusan['periode_start']:'' ?>">
                  </div>
                  <div class="form-group">
                    <label for="periode_start">Periode End</label>
                    <input name="periode_end" type="date" class="form-control" id="periode_end" value="<?php echo isset($kepengurusan['periode_end'])?$kepengurusan['periode_end']:'' ?>">
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
