<div class="content-wrapper" style="min-height: 1244.06px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New University</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item"><a href="#">University</a></li>
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
                <h3 class="card-title">Add New University</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="/admin/university/add">
                <?php if (isset($university['id'])) { ?>
                  <input name="id" type="hidden" value="<?php echo $university['id'] ?>">
                <?php } ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">University Name</label>
                    <input name="name" type="text" class="form-control" id="name" value="<?php echo isset($university['name'])?$university['name']:'' ?>" placeholder="Enter University Name" required>
                  </div>
                  <div class="form-group">
                    <label for="type">University Type</label>
                    <select name="type" type="text" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="type">
                      <option value=""> --- </option>
                      <option value="Public University" <?php echo isset($university['type'])?($university['type']=='Public University'?'selected':''):'' ?>>Public University</option>
                      <option value="Private University" <?php echo isset($university['type'])?($university['type']=='Private University'?'selected':''):'' ?>>Private University</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="profile">University Profile</label>
                    <textarea name="profile" rows="5" class="form-control" id="profile" placeholder="Enter University Profile"><?php echo isset($university['profile'])?$university['profile']:'' ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="website">University Website</label>
                    <input name="website" type="text" class="form-control" id="website" value="<?php echo isset($university['website'])?$university['website']:'' ?>" placeholder="Enter University Website">
                  </div>
                  <div class="form-group">
                    <label for="region">University Region</label>
                    <select name="region" type="text" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" id="region" style="width: 100%;">
                      <option value=""> --- </option>
                      <option value="Dolnośląskie" <?php echo isset($university['region'])?($university['region']=='Dolnośląskie'?'selected':''):'' ?>>Dolnośląskie</option>
                      <option value="Kujawsko-Pomorskie" <?php echo isset($university['region'])?($university['region']=='Kujawsko-Pomorskie'?'selected':''):'' ?>>Kujawsko-Pomorskie</option>
                      <option value="Łódzkie" <?php echo isset($university['region'])?($university['region']=='Łódzkie'?'selected':''):'' ?>>Łódzkie</option>
                      <option value="Lubelskie" <?php echo isset($university['region'])?($university['region']=='Lubelskie'?'selected':''):'' ?>>Lubelskie</option>
                      <option value="Lubuskie" <?php echo isset($university['region'])?($university['region']=='Lubuskie'?'selected':''):'' ?>>Lubuskie</option>
                      <option value="Małopolskie" <?php echo isset($university['region'])?($university['region']=='Małopolskie'?'selected':''):'' ?>>Małopolskie</option>
                      <option value="Mazowieckie" <?php echo isset($university['region'])?($university['region']=='Mazowieckie'?'selected':''):'' ?>>Mazowieckie</option>
                      <option value="Opolskie" <?php echo isset($university['region'])?($university['region']=='Opolskie'?'selected':''):'' ?>>Opolskie</option>
                      <option value="Podkarpackie" <?php echo isset($university['region'])?($university['region']=='Podkarpackie'?'selected':''):'' ?>>Podkarpackie</option>
                      <option value="Podlaskie" <?php echo isset($university['region'])?($university['region']=='Podlaskie'?'selected':''):'' ?>>Podlaskie</option>
                      <option value="Pomorskie" <?php echo isset($university['region'])?($university['region']=='Pomorskie'?'selected':''):'' ?>>Pomorskie</option>
                      <option value="Śląskie" <?php echo isset($university['region'])?($university['region']=='Śląskie'?'selected':''):'' ?>>Śląskie</option>
                      <option value="Świętokrzyskie" <?php echo isset($university['region'])?($university['region']=='Świętokrzyskie'?'selected':''):'' ?>>Świętokrzyskie</option>
                      <option value="Warminsko-Mazurskie" <?php echo isset($university['region'])?($university['region']=='Warminsko-Mazurskie'?'selected':''):'' ?>>Warminsko-Mazurskie</option>
                      <option value="Wielkopolskie" <?php echo isset($university['region'])?($university['region']=='Wielkopolskie'?'selected':''):'' ?>>Wielkopolskie</option>
                      <option value="Zachodniopomorskie" <?php echo isset($university['region'])?($university['region']=='Zachodniopomorskie'?'selected':''):'' ?>>Zachodniopomorskie</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="latlang">University Location</label>
                    <input name="latlang" type="text" class="form-control" id="latlang" value="<?php echo isset($university['latlang'])?$university['latlang']:'' ?>" placeholder="Enter University Location">
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
