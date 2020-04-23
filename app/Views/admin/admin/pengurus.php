<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pengurus <a href="/admin/pengurus/add" type="button" class="btn btn-primary"><i class="right fas fa-plus"></i> Add New</a></h1>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Pengurus</li>
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
              <h3 class="card-title">List Pengurus</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="pengurus_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nama Pengurus</th>
                  <th>Jabatan</th>
                  <th>Kepengurusan</th>
                  <th>Aktif</th>
                  <th>#</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($penguruses as $pengurus): ?>
                <tr>
                  <td><?php echo $pengurus['fullname'] ?></td>
                  <td><?php echo $pengurus['jabatan_name'] ?></td>
                  <td><?php echo $pengurus['kepengurusan_name'] ?></td>
                  <td><?php echo $pengurus['is_active']?'Ya':'Tidak' ?></td>
                  <td>
                    <a href="/admin/pengurus/edit/<?php echo $pengurus['id'] ?>" type="button" class="btn-sm btn-warning">Edit</a>
                    <a href="/admin/pengurus/deactivate/<?php echo $pengurus['id'] ?>" type="button" class="btn-sm btn-<?php echo $pengurus['is_active']?'secondary':'primary' ?>" data-name="<?php echo $pengurus['fullname'] ?>" data-id="<?php echo $pengurus['id'] ?>" data-activate="<?php echo $pengurus['is_active']?'Deactivate':'Activate' ?>" data-toggle="modal" data-target="#modal-deactivate"><?php echo $pengurus['is_active']?'Deactivate':'Activate' ?></a>
                    <a href="/admin/pengurus/delete/<?php echo $pengurus['id'] ?>" type="button" class="btn-sm btn-danger" data-name="<?php echo $pengurus['fullname'] ?>" data-id="<?php echo $pengurus['id'] ?>" data-toggle="modal" data-target="#modal-delete">Del</a>
                  </td>
                </tr>
              <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nama Pengurus</th>
                  <th>Jabatan</th>
                  <th>Kepengurusan</th>
                  <th>Actif</th>
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
          <h4 class="modal-title">Delete Pengurus?</h4>
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

  <div class="modal fade" id="modal-deactivate">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-secondary" id="_de_modal">
        <div class="modal-header">
          <h4 class="modal-title" id="_de_title">Deactivate Pengurus?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="_name"></p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-outline-light" id="go_deactivate">Deactivate</button>
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
            window.location = "/admin/pengurus";
          }
        })
      })
    });

    $('#modal-deactivate').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var id = button.data('id')
      var name = button.data('name')
      var is_activate = button.data('activate')
      var url = button.attr('href')

      var modal = $(this)
      modal.find('#_name').text(name)
      modal.find('#_de_title').text(is_activate)
      modal.find('#go_deactivate').text(is_activate)

      if(is_activate=='Activate'){
        modal.find('#_de_modal').removeClass('bg-secondary').addClass('bg-primary');
      }else{
        modal.find('#_de_modal').removeClass('bg-primary').addClass('bg-secondary');
      }

      $('#go_deactivate').click(function() {
        $.post( url, { <?php echo csrf_token();?>: "<?php echo csrf_hash();?>", is_activate: is_activate})
        .done(function( data ) {
          if (data=='success') {
            window.location = "/admin/pengurus";
          }
        })
      })
    });


  </script>
  <?php });?>
