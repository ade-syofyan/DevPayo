<!-- partial -->

<div class="content-wrapper">

  <div class="row ">

    <div class="col-md-8 offset-md-2 grid-margin stretch-card">

      <div class="card">

        <div class="card-body">

          <h4 class="card-title">Send Notification</h4>

          <?php if ($this->session->flashdata()) : ?>

            <div class="alert alert-success" role="alert">

              <?php echo $this->session->flashdata('send'); ?>

            </div>

          <?php endif; ?>

          <?= form_open_multipart('appnotification/send'); ?>

          <div class="form-group">

            <label for="newscategory">Send To</label>

            <select class="js-example-basic-single" style="width:100%" name='topic'>

              <option value="pelanggan">Users</option>

              <option value="driver">Drivers</option>

              <option value="mitra">Merchant Partner</option>

              <option value="ouride">All</option>

            </select>

          </div>

          <div class="form-group">

            <label for="title">Title</label>

            <input type="text" class="form-control" placeholder="notification" name="title" required>

          </div>

          <div class="form-group">

            <label for="message">Notification Content</label>

            <textarea type="text" class="form-control" placeholder="enter notification title" name="message" required></textarea>

          </div>



          <button type="submit" class="btn btn-success">Send<i class="mdi mdi-send ml-1"></i></button>



          <?= form_close(); ?>

        </div>

      </div>

    </div>

  </div>

</div>

<!-- end of content wrapper -->