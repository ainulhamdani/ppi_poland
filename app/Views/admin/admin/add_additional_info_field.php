<div class="content-wrapper" style="min-height: 1244.06px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo ucwords($mode); ?> New Additional Info Field</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item"><a href="#">Additional Info Field</a></li>
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
                <h3 class="card-title"><?php echo ucwords($mode); ?> New Field</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="/admin/additional_form_setting/add">
                <?php echo csrf_field() ?>
                <?php if (isset($info_field['id'])) { ?>
                  <input name="id" type="hidden" value="<?php echo $info_field['id'] ?>">
                <?php } ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Field Name</label>
                    <input name="name" type="text" class="form-control" id="name" value="<?php echo isset($info_field['name'])?$info_field['name']:'' ?>" placeholder="Enter Field Name" required>
                  </div>
                  <div class="form-group">
                    <label for="label">Field Label</label>
                    <input name="label" type="text" class="form-control" id="label" value="<?php echo isset($info_field['label'])?$info_field['label']:'' ?>" placeholder="Enter Field Label" required>
                  </div>
                  <div class="form-group">
                    <label for="type_id">Field Type</label>
                    <select name="type_id" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="type_id" style="width: 100%;">
                      <?php foreach ($field_types as $field_type) { ?>
                      <option value="<?php echo $field_type['id'] ?>"  <?php echo $info_field?($field_type['id']==$info_field['type_id']?"selected":""):""; ?>><?php echo $field_type['name'] ?></option>
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
