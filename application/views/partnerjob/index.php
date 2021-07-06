<!-- partial -->
<div class="content-wrapper">
  <div class="card">
    <div class="card-body">
      <div>
        <a class="btn btn-info" href="<?= base_url(); ?>partnerjob/addpartnerjob"><i class="mdi mdi-plus-circle-outline"></i>Add Vehicle Type</a>
      </div>
      <br>
      <?php if ($this->session->flashdata('demo') or $this->session->flashdata('hapus')) : ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $this->session->flashdata('demo'); ?>
          <?php echo $this->session->flashdata('hapus'); ?>
        </div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('ubah') or $this->session->flashdata('tambah')) : ?>
        <div class="alert alert-success" role="alert">
          <?php echo $this->session->flashdata('ubah'); ?>
          <?php echo $this->session->flashdata('tambah'); ?>
        </div>
      <?php endif; ?>
      <h4 class="card-title">Partner Job</h4>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table id="order-listing" class="table">
              <thead>
              
                <tr>
                  <th>No</th>
                  <th>Icon Maps</th>
                  <th>Vehicle Type</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                
              </thead>
              <tbody>
              <?php $i = 1;
                foreach ($partnerjob as $prj) { ?>
              <tr>
                <td><?= $i ?></td>
                <td>
                  <?php if ($prj['icon'] == 1) {?>
                    <img src="<?= base_url('images/icon/bike.png'); ?>">
                  <?php } else if ($prj['icon'] == 2) {?>
                    <img src="<?= base_url('images/icon/sedan.png'); ?>">
                  <?php } else if ($prj['icon'] == 3) {?>
                    <img src="<?= base_url('images/icon/truck.png'); ?>"> 
                    <?php } else if ($prj['icon'] == 4) {?>
                    <img src="<?= base_url('images/icon/deliverybike.png'); ?>"> 
                    <?php } else if ($prj['icon'] == 5) {?>
                    <img src="<?= base_url('images/icon/hatchback.png'); ?>">
                    <?php } else if ($prj['icon'] == 6) {?>
                    <img src="<?= base_url('images/icon/suv.png'); ?>"> 
                    <?php } else if ($prj['icon'] == 7) {?>
                    <img src="<?= base_url('images/icon/van.png'); ?>">  
                    <?php } else if ($prj['icon'] == 8) {?>
                    <img src="<?= base_url('images/icon/bicycle.png'); ?>"> 
                    <?php } else if ($prj['icon'] == 9) {?>
                    <img src="<?= base_url('images/icon/tuktuk.png'); ?>"> 
                    <?php } ?> 
                    
                    
                </td>
                <td><?= $prj['driver_job']; ?></td>
                <td>
                    <?php if ($prj['status_job'] == 1) { ?>
                    <label class="badge badge-success">Active</label>
                    <?php } else { ?>
                    <label class="badge badge-danger">Non Active</label>
                    <?php } ?>
                </td>
                <td><a href="<?= base_url(); ?>partnerjob/editpartnerjob/<?= $prj['id']; ?>">
                        <button class="btn btn-outline-primary">Edit</button></a>
                      <a href="<?= base_url(); ?>partnerjob/deletepartnerjob/<?= $prj['id']; ?>" onclick="return confirm ('are you sure?')">
                        <button class="btn btn-outline-danger">Delete</button></a></td>
                </tr>
                <?php $i++;
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- content-wrapper ends -->