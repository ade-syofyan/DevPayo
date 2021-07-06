<!-- partial -->
<div class="content-wrapper">
  <div class="card">
    <div class="card-body">
      <div>
        <a class="btn btn-info" href="<?= base_url(); ?>promoslider/tambah"><i class="mdi mdi-plus-circle-outline"></i>Add Promo Slider</a>
      </div>
      <br>
      <?php if ($this->session->flashdata('demo') or $this->session->flashdata('hapus')) : ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $this->session->flashdata('demo'); ?>
          <?php echo $this->session->flashdata('hapus'); ?>
        </div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('ubah') or $this->session->flashdata('tambah')) : ?>
        <div class="alert alert-succees" role="alert">
          <?php echo $this->session->flashdata('ubah'); ?>
          <?php echo $this->session->flashdata('tambah'); ?>
        </div>
      <?php endif; ?>
      <h4 class="card-title">Promo Slider</h4>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table id="order-listing" class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Image</th>
                  <th>Exp Date</th>
                  <th>Type</th>
                  <th>Service</th>
                  <th>Promo Link</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1;
                foreach ($promo as $pr) { ?>
                  <tr>
                    <td><?= $i ?></td>
                    <td>
                      <img src="<?= base_url('images/promo/') . $pr['foto']; ?>">
                    </td>
                    <td><?= $pr['tanggal_berakhir']; ?></td>
                    <td><?= $pr['type_promosi']; ?></td>
                    <td>
                      <?php if ($pr['fitur_promosi'] == 0) {
                        echo 'Link';
                      } else {
                        echo $pr['fitur'];
                      } ?>
                    </td>
                    <td>
                      <?php if ($pr['link_promosi'] == NULL) { ?>
                        Service
                      <?php } else {
                        echo $pr['link_promosi'];
                      } ?>
                    </td>
                    <td>
                      <?php if ($pr['is_show'] == 1) { ?>
                        <label class="badge badge-success">Active</label>
                      <?php } else { ?>
                        <label class="badge badge-danger">Non Active</label>
                      <?php } ?>
                    </td>
                    <td>
                      <a href="<?= base_url(); ?>promoslider/ubah/<?= $pr['id']; ?>">
                        <button class="btn btn-outline-primary">Edit</button></a>
                      <a href="<?= base_url(); ?>promoslider/hapus/<?= $pr['id']; ?>" onclick="return confirm ('are you sure?')">
                        <button class="btn btn-outline-danger">Delete</button></a>
                    </td>
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