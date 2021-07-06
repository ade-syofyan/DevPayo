<!-- partial -->
<div class="content-wrapper">
  <div class="card">
    <div class="card-body">
      <div>
        <a class="btn btn-info" href="<?= base_url(); ?>promocode/addpromocode"><i class="mdi mdi-plus-circle-outline"></i>Add Promo Code</a>
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
      
      <h4 class="card-title">Promo Code</h4>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table id="order-listing" class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Image</th>
                  <th>Title</th>
                  <th>Kode Promo</th>
                  <th>Discount</th>
                  <th>Service</th>
                  <th>Expired</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1;
                foreach ($promocode as $prc) { ?>
                  <tr>
                    <td><?= $i ?></td>
                    <td>
                      <img src="<?= base_url('images/promo/') . $prc['image_promo']; ?>">
                    </td>
                    <td><?= $prc['nama_promo']; ?></td>
                    <td class="text-primary"><?= $prc['kode_promo']; ?></td>
                    
                    <?php if ($prc['type_promo'] == 'persen') { ?>
                        <td class="text-danger"><?= $prc['nominal_promo']; ?>%</td>
                        <?php } else { ?>
                        <td class="text-danger">$<?= number_format($prc['nominal_promo'] ,0, ".", "."); ?></td>
                        <?php } ?>

                    <td><?= $prc['fitur']; ?></td>
                    <td><?= $prc['expired']; ?></td>
                    <td>
                      <?php if ($prc['status'] == 1) { ?>
                        <label class="badge badge-success">Active</label>
                      <?php } else { ?>
                        <label class="badge badge-danger">Non Active</label>
                      <?php } ?>
                    </td>
                    <td>
                      <a href="<?= base_url(); ?>promocode/editpromocode/<?= $prc['id_promo']; ?>">
                        <button class="btn btn-outline-primary">Edit</button></a>
                      <a href="<?= base_url(); ?>promocode/hapus/<?= $prc['id_promo']; ?>" onclick="return confirm ('are you sure?')">
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