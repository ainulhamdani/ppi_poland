<div class="content-wrapper" style="min-height: 1244.06px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo ucwords($mode); ?> Pengurus</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item"><a href="#">Pengurus</a></li>
              <li class="breadcrumb-item active"><?php echo ucwords($mode); ?></li>
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
                <h3 class="card-title"><?php echo ucwords($mode); ?>Pengurus</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="/admin/pengurus/add">
                <?php echo csrf_field() ?>
                <?php if (isset($pengurus['id'])) { ?>
                  <input name="id" type="hidden" value="<?php echo $pengurus['id'] ?>">
                <?php } ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="user_id">Choose Student</label>
                    <select name="user_id" type="text" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="user_id">
                      <option value=""> --- </option>
                      <?php foreach ($students as $student) { ?>
                      <option value="<?php echo $student['user_id'] ?>" <?php echo $pengurus?($student['user_id']==$pengurus['user_id']?"selected":""):""; ?>><?php echo $student['fullname'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="jabatan_id">Choose Jabatan</label>
                    <select name="jabatan_id" type="text" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="jabatan_id">
                      <option value=""> --- </option>
                      <?php foreach ($jabatans as $jabatan) { ?>
                      <option value="<?php echo $jabatan['id'] ?>" <?php echo $pengurus?($jabatan['id']==$pengurus['jabatan_id']?"selected":""):""; ?>><?php echo $jabatan['name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="kepengurusan_id">Choose Kepengurusan</label>
                    <select name="kepengurusan_id" type="text" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="kepengurusan_id">
                      <option value=""> --- </option>
                      <?php foreach ($kepengurusans as $kepengurusan) { ?>
                      <option value="<?php echo $kepengurusan['id'] ?>" <?php echo $pengurus?($kepengurusan['id']==$pengurus['kepengurusan_id']?"selected":""):""; ?>><?php echo $kepengurusan['name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="is_active">Is Active?</label>
                    <select name="is_active" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="is_active">
                      <option value="1" <?php echo isset($jabatan['is_active'])?($jabatan['is_active']=='1'?'selected':''):'' ?>>Yes</option>
                      <option value="0" <?php echo isset($jabatan['is_active'])?($jabatan['is_active']=='0'?'selected':''):'' ?>>No</option>
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
