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
          <h4 class="card-title">Blog form</h4>
          <?= form_open_multipart('news/tambahblog'); ?>

          <div class="form-group">
            <label>Blog Image</label>
            <input type="file" class="dropify" name="foto_berita" id="foto_berita" data-max-file-size="3mb" required />
          </div>
          <div class="form-group">
            <label for="status_berita">News Purpose</label>
            <select class="js-example-basic-single" style="width:100%" name="purpose" id="purpose">
              <option value="P">Pelanggan</option>
              <option value="M">Mitra</option>
              <option value="D">Driver</option>
            </select>
          </div>
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="enter blog title" required>
          </div>
          <div class="form-group">
            <label for="id_kategori">Category</label>
            <select class="js-example-basic-single" style="width:100%" name="id_kategori" id = "id_kategori" >
              <?php foreach ($news as $nw) { ?>
                <option value="<?= $nw['id_kategori_news'] ?>"><?= $nw['kategori'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="status_berita">Blog Status</label>
            <select class="js-example-basic-single" style="width:100%" name="status_berita" id="status_berita">
              <option value="1">Active</option>
              <option value="0">NonActive</option>
            </select>
          </div>
          <div class="form-group">
            <label for="blogcontent">Blog Content</label>
            <textarea name="content" type="text" class="form-control" id="summernoteExample1" placeholder="Location" required></textarea>
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


