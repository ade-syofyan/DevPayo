<!-- partial -->
<div class="content-wrapper">
  <div class="row ">
    <div class="col-md-8 offset-md-2 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <?php if ($this->session->flashdata()) : ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $this->session->flashdata('demo'); ?>
            </div>
          <?php endif; ?>
          <h4 class="card-title">Add Vehicle Type</h4>
          <?= form_open_multipart('partnerjob/addpartnerjob'); ?>
          <div class="form-group">
            <label for="status_berita">Icon Maps</label>
            <select class="js-example-basic-single" style="width:100%" name="icon" id="statusjob">
              <option value="1">Bike Icon</option>
              <option value="2">Car Icon</option>
              <option value="3">Truck Icon</option>
              <option value="4">Delivery Bike Icon</option>
              <option value="5">HatchBack Car Icon</option>
              <option value="6">SUV Car Icon</option>
              <option value="7">VAN Car Icon</option>
              <option value="8">Bicycle Icon</option>
              <option value="9">Tuk Tuk Icon</option>
            </select>
          </div>
          <div class="form-group">
            <label for="title">Vehicle Type</label>
            <input type="text" class="form-control" name="driver_job" id="job" placeholder="enter job title" required>
          </div>
          <div class="form-group">
            <label for="status_berita">Vehicle Type Status</label>
            <select class="js-example-basic-single" style="width:100%" name="status_job" id="statusjob">
              <option value="1">Active</option>
              <option value="0">NonActive</option>
            </select>
          </div>
          <button type="submit" class="btn btn-success mr-2">Submit</button>
          <button class="btn btn-light">Cancel</button>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end of content wrapper -->