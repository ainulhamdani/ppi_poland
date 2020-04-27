<div class="content-wrapper" style="min-height: 1244.06px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mail Setting</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Mail Setting</li>
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
                <h3 class="card-title">Mail Setting</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="/admin/email_setting">
                <?php echo csrf_field() ?>
                <?php if (isset($email_setting['id'])) { ?>
                  <input name="id" type="hidden" value="<?php echo $email_setting['id'] ?>">
                <?php } ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" type="text" class="form-control" id="name" value="<?php echo isset($email_setting['name'])?$email_setting['name']:'' ?>" placeholder="Enter Email Name" required>
                  </div>
                  <div class="form-group">
                    <label for="SMTP_user">SMTP Username</label>
                    <input name="SMTP_user" type="email" class="form-control" id="SMTP_user" value="<?php echo isset($email_setting['SMTP_user'])?$email_setting['SMTP_user']:'' ?>" placeholder="Enter SMTP Username" required>
                  </div>
                  <div class="form-group">
                    <label for="SMTP_pass">SMTP Password</label>
                    <input name="SMTP_pass" type="password" class="form-control" id="SMTP_pass" value="<?php echo isset($email_setting['SMTP_pass'])?$email_setting['SMTP_pass']:'' ?>" placeholder="Enter SMTP Password" required>
                  </div>
                  <div class="form-group">
                    <label for="SMTP_host">SMTP Host</label>
                    <input name="SMTP_host" type="text" class="form-control" id="SMTP_host" value="<?php echo isset($email_setting['SMTP_host'])?$email_setting['SMTP_host']:'' ?>" placeholder="Enter SMTP Host" required>
                  </div>
                  <div class="form-group">
                    <label for="SMTP_crypto">SMTP Crypto</label>
                    <select name="SMTP_crypto" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="SMTP_crypto" style="width: 100%;">
                      <option value="ssl" <?php echo $email_setting['SMTP_crypto']=='ssl'?"selected":""; ?>>SSL</option>
                      <option value="tls" <?php echo $email_setting['SMTP_crypto']=='tls'?"selected":""; ?>>TLS</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="SMTP_port">SMTP Port</label>
                    <input name="SMTP_port" type="number" class="form-control" id="SMTP_user" value="<?php echo isset($email_setting['SMTP_port'])?$email_setting['SMTP_port']:'' ?>" placeholder="Enter SMTP Port" required>
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
